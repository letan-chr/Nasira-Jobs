@extends('employer.layouts.app')
@section('title')
    {{ __('messages.employer_menu.manage_subscriptions') }}
@endsection
@section('content')
    @include('flash::message')
    <div class="row justify-content-center">
        @foreach ($plans as $plan)
            <div class="col-xl-4 col-md-6 d-flex align-items-stretch">
                <div class="card pricing-card text-center flex-fill">
                    <div class="card-body px-xl-10 px-7 py-xl-14 py-10 d-flex flex-column">
                        <h3 class="text-gray-900 fs-2">{{ html_entity_decode($plan->name) }}</h3>
                        <div class="d-flex justify-content-center mt-5">
                            <h4 class="text-center mb-6 mt-2">
                                <span
                                    class="fa-3x fw-bolder">{{ empty($plan->salaryCurrency->currency_icon) ? '$' : $plan->salaryCurrency->currency_icon }}{{ $plan->amount }}</span>
                                    @if ($plan->unlimited_plan == 1)
                                    <span class="h6 text-gray-800 ml-2">{{ __('messages.plan.unlimited') }}</span>
                                    @else
                                    <span class="h6 text-gray-800 ml-2">{{ __('messages.plan.per_month') }}</span>
                                    @endif
                            </h4>
                        </div>
                        @if (isset($subscription) && $subscription->plan_id == $plan->id)
                            @if ($subscription->stripe_status != 'trialing')
                                <div class="py-4 fs-2 text-center">
                                    @if (isset($subscription->ends_at))
                                        {{ __('messages.plan.ends_at') . ': ' . \Carbon\Carbon::parse($subscription->ends_at)->translatedFormat('jS M,Y') }}
                                    @else
                                        {{ __('messages.plan.renews_on') . ': ' . \Carbon\Carbon::parse($subscription->current_period_end)->translatedFormat('jS M,Y') }}
                                    @endif
                                </div>
                            @endif
                        @endif
                        <ul class="pricing-plan-features text-gray-600 fs-4 mb-9 p-0">
                            <li>
                                <i
                                    class="fa-solid fa-check {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}"></i>{{ $plan->allowed_jobs . ' ' . ($plan->allowed_jobs > 1 ? __('messages.plan.jobs_allowed') : __('messages.plan.job_allowed')) }}
                            </li>
                            <li>
                                @if ($plan->is_trial_plan)
                                    <i class="fa-solid fa-check {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}"></i>
                                @else
                                    <i class="fas fa-times text-danger {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}"></i>
                                @endif
                                {{ __('messages.plan.is_trial_plan') }}
                            </li>
                            <li>
                                @if (isset($subscription) && $subscription->plan_id == $plan->id)
                                    <i class="fas fa-briefcase text-primary {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}"></i>
                                    {{ $jobsCount . ' ' . ($jobsCount > 1 ? __('messages.plan.jobs_used') : __('messages.plan.job_used')) }}
                                @endif
                            </li>
                        </ul>
                        @if (isset($subscription) && $subscription->plan_id == $plan->id)
                            <div class="d-flex justify-content-center">
                                @if ($subscription->current_period_end <= date('Y-m-d H:i:s'))
                                    <a href="{{ route('payment-method-screen', $plan->id) }}"
                                        data-id="{{ $plan->id }}"
                                        class="btn btn-warning pricing-plan-btn mt-auto align-self-center">
                                        {{ __('messages.plan.upgrade') }}
                                    </a>
                                @else
                                    <a href="javascript:void(0)"
                                        class="btn btn-success pricing-plan-btn mt-auto align-self-center">{{ __('messages.plan.current_plan') }}
                                    </a>
                                @endif
                                @if ($subscription->ststripe_statu != 'trialing')
                                    @if (isset($subscription->ends_at))
                                        <a href="javascript:void(0)"
                                            class="btn btn-danger pricing-plan-btn mt-auto align-self-center subscription {{ checkLanguageSession() == 'ar' ? 'me-3' : 'ms-3' }}">{{ __('messages.plan.subscription_cancelled') }}</a>
                                    @else
                                        @if ($subscription['name'] != 'Trial Plan')
                                            <a href="javascript:void(0)"
                                                class="btn btn-danger pricing-plan-btn mt-auto align-self-center cancel-subscription {{ checkLanguageSession() == 'ar' ? 'me-3' : 'ms-3' }}">{{ __('messages.plan.cancel_subscription') }}</a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        @else
                            @if ($plan->is_trial_plan)
                                <a href="javascript:void(0)" data-id="{{ $plan->id }}"
                                    class="btn btn-info pricing-plan-btn mt-auto align-self-center"
                                    style="pointer-events: none;">{{ __('messages.plan.is_trial_plan') }} </a>
                            @elseif(!empty(processingPlan($plan->id)))
                                <a data-id="{{ $plan->id }}"
                                    class="btn btn-secondary pricing-plan-btn mt-auto align-self-center cursor-default">
                                    {{ __('messages.plan.processing') }}</a>
                            @else
                                @if ($activePlanId !== $plan->id)
                                    <a href="{{ route('payment-method-screen', $plan->id) }}"
                                        data-id="{{ $plan->id }}"
                                        class="btn btn-info pricing-plan-btn mt-auto align-self-center">
                                        {{ __('messages.plan.purchase') }}</a>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        @include('pricing.cancel_subscription_modal')
    </div>
    {{ Form::hidden('subscribe-text', __('messages.plan.purchase'), ['id' => 'subscribeText']) }}
@endsection
