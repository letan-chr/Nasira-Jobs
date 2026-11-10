<?php

namespace App\Http\Controllers;

use App\Models\FeaturedRecord;
use App\Models\FrontSetting;
use App\Models\Job;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\SalaryCurrency;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class FeaturedJobSubscriptionController
 */
class FeaturedJobSubscriptionController extends AppBaseController
{
    /**
     * @throws ApiErrorException
     */
    public function createSession(Request $request): JsonResponse
    {
        $amount = FrontSetting::where('key', 'featured_jobs_price')->first()->value;
        $featuredListingCurrency = FrontSetting::where('key', 'currency')->first()->value;
        $featuredCurrency = SalaryCurrency::whereId($featuredListingCurrency)->first();

        try {
            $jobId = $request->get('jobId');
            $companyId = getLoggedInUser()->company->id;
            $companyJobsId = Job::whereCompanyId($companyId)->pluck('id')->toArray();

            if (! in_array($jobId, $companyJobsId)) {
                return $this->sendError(__('messages.common.seems_message'));
            }
            $job = Job::findOrFail($jobId);
        } catch (\Exception $e) {
            return $this->sendError(__('messages.common.seems_message'));
        }

        $user = Auth::user();
        $userEmail = $user->email;

        setStripeApiKey();
        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $userEmail,
            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => 'Make '.$job->job_title.' as featured Job',
                        ],
                        'unit_amount' => $amount * 100,
                        'currency' => $featuredCurrency->currency_code,
                    ],
                    'quantity' => 1,
                    // 'description' => 'Make '.$job->job_title.' as featured Job',
                ],
            ],
            'client_reference_id' => $jobId,
            'mode' => 'payment',
            'success_url' => url('job-payment-success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => url('job-failed-payment?error=payment_cancelled'),
        ]);
        $result = [
            'sessionId' => $session['id'],
        ];

        return $this->sendResponse($result, __('messages.flash.session_created'));
    }

    /**
     * @return Application|Redirector|RedirectResponse
     *
     * @throws Exception
     */
    public function paymentSuccess(Request $request): RedirectResponse
    {
        $sessionId = $request->get('session_id');

        if (empty($sessionId)) {
            throw new UnprocessableEntityHttpException('session_id required');
        }
        setStripeApiKey();

        $sessionData = \Stripe\Checkout\Session::retrieve($sessionId);
        $currency = SalaryCurrency::where('currency_code', $sessionData->currency)->select('id')->first();
        $stripeID = $sessionData->id;
        $jobId = $sessionData->client_reference_id;
        $userId = getLoggedInUserId();
        $addDays = FrontSetting::where('key', 'featured_jobs_days')->first()->value;
        $adminId = User::role('Admin')->first()->id;

        $featuredRecord = [
            'owner_id' => $jobId,
            'owner_type' => Job::class,
            'user_id' => $userId,
            'stripe_id' => $stripeID,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addDays($addDays),
            'meta' => $sessionData->toJSON(),
        ];
        FeaturedRecord::create($featuredRecord);
        $loggedInUser = getLoggedInUser();
        NotificationSetting::where('key', 'MARK_JOB_FEATURED')->where('type',
            'employer')->first()->value == 1 ?
            addNotification([
                Notification::MARK_JOB_FEATURED,
                $adminId,
                Notification::ADMIN,
                'Company '.$loggedInUser->first_name.' '.$loggedInUser->last_name.' marked as featured',
            ])
            : false;
        $transaction = [
            'owner_id' => $jobId,
            'owner_type' => Job::class,
            'user_id' => $userId,
            'plan_currency_id' => $currency->id,
            'amount' => intval($sessionData->amount_total / 100),
        ];
        Transaction::create($transaction);
        Flash::success(__('messages.flash.payment_success'));

        return redirect(route('job.index'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function handleFailedPayment(): RedirectResponse
    {
        Flash::error(__('messages.flash.payment_not_complete'));

        return redirect(route('job.index'));
    }
}
