<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\Plan as SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Laracasts\Flash\Flash;
use PayPalHttp\HttpException;
use PayPalHttp\IOException;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

/** All Paypal Details class **/
class PaypalController extends Controller
{
         private $_api_context;

         /**
          * Create a new controller instance.
          *
          * @return void
          */
         public function __construct()
         {
                  /** setup PayPal api context **/
                  //        $paypal_conf = \Config::get('paypal');
                  //        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'],
                  //            $paypal_conf['secret']));
                  //        $this->_api_context->setConfig($paypal_conf['settings']);
         }

         /**
          * @return JsonResponse|RedirectResponse
          *
          * @throws HttpException
          * @throws IOException
          */
         public function oneTimePayment(SubscriptionPlan $plan): RedirectResponse
         {
                  $user = Auth::user();
                  $pendingApproval = Transaction::where('user_id', $user->id)->where('is_approved', Transaction::PENDING)->first();

                  if ($pendingApproval) {
                           Flash::error(__('messages.flash.pending_manual_purchase'));

                           return redirect()->route('manage-subscription.index');
                  }
                  if ($plan->salaryCurrency != null && !in_array(
                           $plan->salaryCurrency->currency_code,
                           getPayPalSupportedCurrencies()
                  )) {
                           Flash::error(__('messages.flash.this_currency_is'));

                           return redirect()->route('manage-subscription.index');
                  }
                  //        $currency = $plan->with('salaryCurrency')->findOrFail($plan->id);
                  $clientId = !empty(getEnvSetting()['paypal_client_id']) ? getEnvSetting()['paypal_client_id'] : config('paypal.paypal.client_id');
                  $clientSecret = !empty(getEnvSetting()['paypal_secret']) ? getEnvSetting()['paypal_secret'] : config('paypal.paypal.client_secret');
                  $mode = config('paypal.mode');

                  config([
                           'paypal.mode' => $mode,
                           'paypal.sandbox.client_id' => $clientId,
                           'paypal.sandbox.client_secret' => $clientSecret,
                           'paypal.live.client_id' => $clientId,
                           'paypal.live.client_secret' => $clientSecret,
                  ]);
                  $provider = new PayPalClient();
                  $provider->getAccessToken();

                  $data = [
                           'intent' => 'CAPTURE',
                           'purchase_units' => [
                                    [
                                             'reference_id' => $plan->id,
                                             'amount' => [
                                                      'value' => (int) $plan->amount,
                                                      'currency_code' => $plan->salaryCurrency != null ? $plan->salaryCurrency->currency_code : 'USD',
                                             ],
                                    ],
                           ],
                           'application_context' => [
                                    'cancel_url' => URL::route('status'),
                                    'return_url' => URL::route('status'),
                           ],
                  ];

                  $order = $provider->createOrder($data);

                  return redirect($order['links'][1]['href']);
         }

         public function getPaymentStatus(Request $request): RedirectResponse
         {
                  $clientId = !empty(getEnvSetting()['paypal_client_id']) ? getEnvSetting()['paypal_client_id'] : config('paypal.paypal.client_id');
                  $clientSecret = !empty(getEnvSetting()['paypal_secret']) ? getEnvSetting()['paypal_secret'] : config('paypal.paypal.client_secret');
                  $mode = config('paypal.mode');

                  config([
                           'paypal.mode' => $mode,
                           'paypal.sandbox.client_id' => $clientId,
                           'paypal.sandbox.client_secret' => $clientSecret,
                           'paypal.live.client_id' => $clientId,
                           'paypal.live.client_secret' => $clientSecret,
                  ]);

                  $provider = new PayPalClient();
                  $provider->getAccessToken();
                  $token = $request->get('token');
                  $orderInfo = $provider->showOrderDetails($token);
                  try {
                           // Call API with your client and get a response for your call
                           $response = $provider->capturePaymentOrder($token);

                           // If call returns body in response, you can get the deserialized version from the result attribute of the response
                           $planId = $response['purchase_units'][0]['reference_id'];
                           $paymentAmount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
                           $paymentId = $response['id'];

                           session()->flash('success', 'Payment success');

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
                                    'paypal_payment_id' => $paymentId,
                           ]);
                           $adminId = User::role('Admin')->first()->id;
                           NotificationSetting::where('key', 'EMPLOYER_PURCHASE_PLAN')->first()->value == 1 ?
                                    addNotification([
                                             Notification::EMPLOYER_PURCHASE_PLAN,
                                             $adminId,
                                             Notification::ADMIN,
                                             $user->first_name . ' ' . $user->last_name . ' purchase ' . $plan->name,
                                    ]) : false;

                           $transaction = (new \App\Models\Transaction())->fill([
                                    'user_id' => $tsSubscription->user_id,
                                    'owner_id' => $tsSubscription->id,
                                    'owner_type' => Subscription::class,
                                    'amount' => $paymentAmount,
                                    'status' => Transaction::PAYPAL_PAYMENT,
                                    'plan_currency_id' => $plan->salary_currency_id,
                           ]);

                           $transaction->save();

                           // if another account subscription already running than cancel it
                           if ($existingSubscription && $existingSubscription->user_id === $user->id) {
                                    // immediately cancel old subscription from strip
                                    $existingSubscription->update(['ends_at' => Carbon::now()]);
                           }
                           Flash::success(__('messages.flash.your_payment_comp'));

                           return Redirect::route('manage-subscription.index');
                  } catch (HttpException $ex) {
                           Flash::error('Your Payment is Cancelled');

                           return Redirect::route('manage-subscription.index');
                  }
         }
}
