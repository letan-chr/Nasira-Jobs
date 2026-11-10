<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\PlanRepository;
use App\Repositories\SubscriptionRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use UnexpectedValueException;

class SubscriptionController extends AppBaseController
{
    private $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        /** @var PlanRepository $planRepo */
        $planRepo = app(PlanRepository::class);
        $plans = $planRepo->getPlans();

        return view('pricing.index')->with($plans);
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function purchaseSubscription(Request $request)
    {
        $user = Auth::user();
        $pendingApproval = Transaction::where('user_id', $user->id)->where('is_approved', Transaction::PENDING)->first();

        if ($pendingApproval) {
            return $this->sendError(__('messages.flash.pending_manual_purchase'));
        }
        $planId = $request->get('plan_id');
        if (empty($planId)) {
            throw new Exception('plan_id required', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /** @var Plan $plan */
        $plan = Plan::with('salaryCurrency')->findOrFail($planId);

        if (! $plan->stripe_plan_id) {
            createStripePlan($plan);
        }

        $plan->refresh();

        /** @var User $user */
        $user = Auth::user();

        $userEmail = isset($user->email) ? $user->email : null;

        setStripeApiKey();
        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $userEmail,
            'subscription_data' => [
                'items' => [
                    ['plan' => $plan->stripe_plan_id],
                ],
            ],
            'success_url' => url('employer/payment-success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => url('employer/failed-payment?error=payment_cancelled'),
        ]);
        $result = [
            'sessionId' => $session['id'],
        ];

        return $this->sendResponse($result, __('messages.flash.subscription_resume'));
    }

    /**
     * @return RedirectResponse|Redirector
     *
     * @throws Exception
     */
    public function paymentSuccess(Request $request): RedirectResponse
    {
        $sessionId = $request->get('session_id');
        if (empty($sessionId)) {
            throw new UnprocessableEntityHttpException('session_id required');
        }

        /** @var SubscriptionRepository $subscriptionRepo */
        $subscriptionRepo = app(SubscriptionRepository::class);
        $subscriptionRepo->purchaseSubscription($sessionId);
        Flash::success('Your Payment is successfully completed');

        return redirect(route('manage-subscription.index'));
    }

    /**
     * @return Factory|View
     */
    public function handleFailedPayment(): View
    {
        return view('transactions.failed_payments');
    }

    public function cancelSubscription(Request $request): JsonResponse
    {
        $input = $request->all();

        /** @var User $user */
        $user = Auth::user();

        setStripeApiKey();
        /** @var Subscription $subscription */
        $subscription = $user->subscriptions()->active()->first();

        if (! $subscription) {
            return $this->sendError(__('messages.flash.your_are_not_author'));
        }

        $subscription->cancellation_reason = $input['cancellation_reason'];

        $subscription->stripe_id ? $subscription->cancel() : $subscription->ends_at = $subscription->current_period_end;

        $subscription->save();

        return $this->sendSuccess(__('messages.flash.subscription_cancel'));
    }

    /**
     * @throws Exception
     */
    public function purchaseTrialSubscription(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var SubscriptionRepository $subscriptionRepo */
        $subscriptionRepo = app(SubscriptionRepository::class);

        $result = $subscriptionRepo->createStripeCustomer($user);

        return $this->sendResponse($result, __('messages.flash.subscription_resume'));
    }

    /**
     * @return bool
     */
    public function updateSubscription(Request $request)
    {
        $envSetting = getEnvSetting();
        if (! empty($envSetting['stripe_webhook_key'])) {
            $stripeWebHookSecret = $envSetting['stripe_webhook_key'];
        } else {
            $stripeWebHookSecret = config('services.stripe.webhook_secret_key');
        }

        $data = $request->all();

        $payload = @file_get_contents('php://input');
        $sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $stripeWebHookSecret
            );
            $input = $request->all();
            $this->subscriptionRepository->updateSubscription($input);

            return true;
        } catch (UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function showPaymentSelect(Plan $plan): View
    {
        return view('pricing.payment_methods', compact('plan'));
    }

    /**
     * @return JsonResponse|RedirectResponse
     */
    public function manuallyPayment(Plan $plan): RedirectResponse
    {
        $user = Auth::user();

        $pendingApproval = Transaction::where('user_id', $user->id)->where('is_approved', Transaction::PENDING)->first();

        if ($pendingApproval) {
            Flash::error(__('messages.flash.please_wait_for'));
        } else {
            /** @var Subscription $tsSubscription */
            $tsSubscription = Subscription::create([
                'name' => $plan->name,
                'stripe_id' => null,
                'stripe_status' => Subscription::PENDING,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'type' => Subscription::MANUALLY,
            ]);

            $transaction = [
                'owner_id' => $tsSubscription->id,
                'owner_type' => Subscription::class,
                'user_id' => $user->id,
                'amount' => $plan->amount,
                'plan_currency_id' => $plan->salary_currency_id,
                'status' => Transaction::MANUALLY,
                'is_approved' => Transaction::PENDING,
            ];

            Transaction::create($transaction);

            Flash::success(__('messages.flash.please_wait_for_com'));
        }

        return redirect(route('manage-subscription.index'));
    }

    /**
     * @return mixed
     */
    public function changeTransactionStatus(Request $request)
    {
        $input = $request->all();
        $approve_by = Auth::user()->id;
        $transaction = Transaction::where('id', $input['id'])->first();
        $subscription = Subscription::where('id', $transaction->owner_id)->first();
        if ($input['status'] == Transaction::APPROVED) {
            $transaction->is_approved = Transaction::APPROVED;
            $transaction->approved_id = $approve_by;
            $transaction->save();

            $existingSubscription = Subscription::NotOnTrial()
                ->whereUserId($transaction->user_id)
                ->where('stripe_status', '!=', Subscription::PENDING)
                ->first();

            if ($existingSubscription && $existingSubscription->user_id === $transaction->user_id) {
                $existingSubscription->update(['ends_at' => Carbon::now()]);
            }

            // end trial subscription
            Subscription::whereUserId($transaction->user_id)->where(function (Builder $query) {
                $query->where('stripe_status', '=', 'trialing');
            })->whereNotNull('trial_ends_at')
                ->update([
                    'trial_ends_at' => Carbon::now(),
                ]);

            $subscription->stripe_status = 'active';

            $is_unlimited = Subscription::with('planCurrency')->where('id', $transaction->owner_id)->first();

            if($is_unlimited->planCurrency->unlimited_plan == 1){
                $subscription->current_period_start = Carbon::now();
                $subscription->current_period_end = Carbon::now()->addYears(100);
            }else{
                $subscription->current_period_start = Carbon::now();
                $subscription->current_period_end = Carbon::now()->addMonths();
            }
            $subscription->save();

            return $this->sendSuccess(__('messages.flash.manual_payment'));
        }

        $subscription->stripe_status = Subscription::REJECTED;
        $subscription->save();
        $transaction->is_approved = Transaction::REJECTED;
        $transaction->approved_id = $approve_by;
        $transaction->save();

        return $this->sendSuccess(__('messages.flash.manual_payment_denied'));
    }
}
