<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\FrontSetting;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use App\Models\FeaturedRecord;
use App\Models\SalaryCurrency;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class FeaturedCompanySubscriptionController
 */
class FeaturedCompanySubscriptionController extends AppBaseController
{
    /**
     * @throws ApiErrorException
     */
    public function createSession(Request $request): JsonResponse
    {
        $amount = FrontSetting::where('key', 'featured_companies_price')->first()->value;
        $companyId = $request->get('companyId');
        $company = Company::with('user')->findOrFail($companyId);
        $user = Auth::user();
        $userEmail = $user->email;
        $featuredListingCurrency = FrontSetting::where('key', 'currency')->first()->value;
        $featuredCurrency = SalaryCurrency::whereId($featuredListingCurrency)->first();
        setStripeApiKey();
        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $userEmail,
            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => 'Make '.$company->user->first_name.' as featured Company',
                        ],
                        'unit_amount' => $amount * 100,
                        'currency' => $featuredCurrency->currency_code,
                    ],
                    
                    'quantity' => 1,
                    // 'description' => 'Make '.$company->user->first_name.' as featured Company',
                ],
            ],
            'client_reference_id' => $companyId,
            'mode' => 'payment',
            'success_url' => url('company-payment-success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => url('company-failed-payment?error=payment_cancelled'),
        ]);
        $result = [
            'sessionId' => $session['id'],
        ];

        return $this->sendResponse($result, __('messages.flash.session_created'));
    }

    /**
     * @return RedirectResponse|RedirectorStripe::setApiKey(<API-KEY>)
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
        $companyId = $sessionData->client_reference_id;
        $userId = getLoggedInUserId();
        $addDays = FrontSetting::where('key', 'featured_companies_days')->first()->value;

        $company = Company::findOrFail($companyId);
        $employer = User::findOrFail($company->user_id);
        $adminId = User::role('Admin')->first()->id;

        $featuredRecord = [
            'owner_id' => $companyId,
            'owner_type' => Company::class,
            'user_id' => $userId,
            'stripe_id' => $stripeID,
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now()->addDays($addDays),
            'meta' => $sessionData->toJSON(),
        ];
        FeaturedRecord::create($featuredRecord);
        NotificationSetting::where('key', 'MARK_COMPANY_FEATURED')->where('type',
            'employer')->first()->value == 1 ?
            addNotification([
                Notification::MARK_COMPANY_FEATURED,
                $adminId,
                Notification::ADMIN,
                'The company marked as featured by '.$employer->first_name.' '.$employer->last_name,
            ])
            : false;
        $transaction = [
            'owner_id' => $companyId,
            'owner_type' => Company::class,
            'user_id' => $userId,
            'plan_currency_id' => $currency->id,
            'amount' => intval($sessionData->amount_total / 100),
        ];
        Transaction::create($transaction);
        Flash::success(__('messages.flash.payment_success'));

        return redirect(route('company.edit.form', $companyId));
    }

    /**
     * @return Factory|View
     */
    public function handleFailedPayment(): RedirectResponse
    {
        $companyId = Auth::user()->company->id;
        Flash::error(__('messages.flash.payment_not_complete'));

        return redirect(route('company.edit.form', $companyId));
    }
}
