@extends('employer.layouts.app')
@section('title')
    {{ __('messages.employer_menu.manage_subscriptions') }}
@endsection
@section('content')
    <div class="card-body">
        <div class="row">
            <div class="col-12 offset-0 offset-md-2 col-md-8">
                <img src="{{ asset('assets/img/payment.png') }}" class="img-fluid">
            </div>
            <div class="col-12">
                <div class="row justify-content-lg-around">
                    <a class="btn btn-primary btn-lg mt-2 col-md-2 col-12 subscribe" href="javascript:void(0)"
                       data-id="{{ $plan->id }}">
                        <span class="fs-4">{{ __('messages.plan.pay_with_stripe') }}</span>
                    </a>
                    <a class="btn btn-primary btn-lg mt-2 col-md-2 col-12 pay-with-paypal"
                       href="{{ route('paypal-payment', $plan->id) }}">
                        <span class="fs-4">{{ __('messages.plan.pay_with_paypal') }}</span>
                    </a>
                    <a class="btn btn-primary btn-lg mt-2 col-md-2 col-12 pay-with-paypal"
                       href="{{ route('manually-payment', $plan->id) }}">
                        <span class="fs-4">{{ __('messages.plan.pay_with_manually') }}</span>
                    </a>
                    <a class="btn btn-primary btn-lg mt-2 col-md-2 col-12 pay-with-paypal"
                    href="{{ route('paystack.payment', $plan->id) }}">
                     <span class="fs-4">{{ __('messages.plan.pay_with_stack') }}</span>
                 </a>
                </div>
            </div>
        </div>
    </div>

@endsection
