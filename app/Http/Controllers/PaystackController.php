<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\Plan as SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaystackController extends Controller
{
    public function __construct()
    {
        $publicKey = ! empty(getEnvSetting()['paystack_key']) ? getEnvSetting()['paystack_key'] : config('paystack.publicKey');
        $secrtKey = ! empty(getEnvSetting()['paystack_secret']) ? getEnvSetting()['paystack_secret'] : config('paystack.secretKey');
        $paymentUrl = ! empty(getEnvSetting()['paystack_payment_url']) ? getEnvSetting()['paystack_payment_url'] : config('paystack.paymentUrl');

        config([
            'paystack.publicKey' => $publicKey,
            'paystack.secretKey' => $secrtKey,
            'paystack.paymentUrl' => $paymentUrl,
        ]);
    }

    public function redirectToGateway(SubscriptionPlan $plan): RedirectResponse
    {
        $user = Auth::user();
        $pendingApproval = Transaction::where('user_id', $user->id)->where('is_approved', Transaction::PENDING)->first();

        if ($pendingApproval) {
            Flash::error(__('messages.flash.pending_manual_purchase'));

            return redirect()->route('manage-subscription.index');
        }
        if ($plan->salaryCurrency != null && ! in_array(
            $plan->salaryCurrency->currency_code,
            getPaystackSupportedCurrencies()
        )) {
            Flash::error(__('messages.flash.this_currency_is_not'));

            return redirect()->route('manage-subscription.index');
        }

        $data = [];
        $user = Auth::user();

        try {
            $data = [
                'email' => $user->email, // email of recipients
                'amount' => $plan->amount * 100,
                'orderID' => rand(10000, 99999), // generate a random order ID for the client
                'currency' => strtoupper($plan->currency_id),
                'reference' => Paystack::genTranxRef(),
                'metadata' => json_encode([
                    'plan_id' => $plan->id,
                ]),
            ];

            return Paystack::getAuthorizationUrl($data)->redirectNow();
        } catch (Exception $e) {
            Flash::error('Error initiating Paystack payment.');

            return redirect()->route('manage-subscription.index');
        }
    }

    public function paymentSuccess()
    {
        $paymentDetails = Paystack::getPaymentData();

        if (! $paymentDetails['status']) {
            Flash::error(__('messages.payment_failed'));

            return redirect(route('manage-subscription.index'));
        }

        $planId = $paymentDetails['data']['metadata']['plan_id'];
        $transactionId = $paymentDetails['data']['reference'];
        $amount = $paymentDetails['data']['amount'] / 100;
        $metaData = json_encode($paymentDetails['data']);

        /** @var User $user */
        $user = Auth::user();

        /** @var \App\Models\Plan $plan */
        $plan = SubscriptionPlan::findOrFail($planId);

        /** @var Subscription $existingSubscription */
        $existingSubscription = Subscription::NotOnTrial()
            ->whereUserId($user->id)
            ->active()
            ->first();
        // end trial subscription
        Subscription::whereUserId($user->id)->where(function (Builder $query) {
            $query->where('stripe_status', '=', 'trialing');
        })->whereNotNull('trial_ends_at')
            ->update([
                'ends_at' => Carbon::now(),
                'trial_ends_at' => Carbon::now(),
            ]);

        /** @var Subscription $tsSubscription */
        $tsSubscription = Subscription::create([
            'name' => $plan->name,
            'stripe_status' => 'active',
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'current_period_start' => Carbon::now(),
            'current_period_end' => Carbon::now()->addMonth(),
        ]);

        $adminId = User::role('Admin')->first()->id;
        NotificationSetting::where('key', 'EMPLOYER_PURCHASE_PLAN')->first()->value == 1 ?
                 addNotification([
                     Notification::EMPLOYER_PURCHASE_PLAN,
                     $adminId,
                     Notification::ADMIN,
                     $user->first_name.' '.$user->last_name.' purchase '.$plan->name,
                 ]) : false;

        $transaction = Transaction::create([
            'user_id' => $tsSubscription->user_id,
            'owner_id' => $tsSubscription->id,
            'owner_type' => Subscription::class,
            'amount' => $amount,
            'status' => Transaction::PAYSTACK_PAYMENT,
            'plan_currency_id' => $plan->salary_currency_id,
        ]);

        // if another account subscription already running than cancel it
        if ($existingSubscription && $existingSubscription->user_id === $user->id) {
            // immediately cancel old subscription from strip
            $existingSubscription->update(['ends_at' => Carbon::now()]);
        }

        Flash::success(__('messages.flash.your_payment_comp'));

        return redirect()->route('manage-subscription.index');
    }
}
