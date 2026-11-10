<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Stripe\StripeClient;

/**
 * Class TransactionController
 */
class TransactionController extends AppBaseController
{
    /**
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index(): View
    {
        if (Auth::user()->hasRole('Employer')) {
            return view('employer.transactions.index');
        }

        return view('transactions.index');
    }

    /**
     * @return mixed
     *
     * @throws Exception
     */
    public function getTransactionInvoice(string $invoiceId)
    {
        try {
            setStripeApiKey();
            $envSetting = getEnvSetting();
            if(!empty($envSetting['stripe_secret'])){
                $stripe = new StripeClient(
                    $envSetting['stripe_secret']
                );
            }else{
                $stripe = new StripeClient(
                    config('services.stripe.secret_key')
                );
            }

            $invoice = $stripe->invoices->retrieve(
                $invoiceId,
                []
            );

            $userStripeId = getLoggedInUser()->stripe_id ?? null;
            if (! getLoggedInUser()->hasRole('Admin') && ($invoice->customer !== $userStripeId)) {
                return $this->sendError(__('messages.common.seems_message'), 403);
            }

            $charge = $stripe->charges->retrieve($invoice->charge);
            $receiptUrl = $charge->receipt_url;

            return $this->sendResponse($receiptUrl, __('messages.flash.invoice_retrieve'));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
