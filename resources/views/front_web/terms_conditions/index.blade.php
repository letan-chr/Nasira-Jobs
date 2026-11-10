@extends('front_web.layouts.app')
@section('title')
    {{ __('messages.setting.terms_conditions') }}
@endsection
@section('content')

    <section class="hero-section position-relative bg-gradient pt-15 pb-40">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 text-center mb-lg-0 mb-md-5 mb-sm-4">
                    <div class="hero-content">
                        <h1 class="text-secondary mb-2">{{ __('messages.setting.terms_conditions') }}</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('front.home') }}" class="fs-18 text-gray">{{ __('web.home') }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item text-primary fs-18" aria-current="page">
                                    {{ __('messages.setting.terms_conditions') }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="privacy-policy-section pt-60 pb-100">
        <div class="container">
            <div class="about-infyjob">
                <h5 class="fs-18 text-secondary mb-3">{{ __('messages.setting.terms_conditions') }}</h5>
                <p class="fs-16 text-gray mb-0">
                    {!! nl2br(e($termsConditions['value'])) !!}
                </p>
            </div>
        </div>
    </div>
@endsection

{{-- @section('scripts') --}}
{{--    <script> --}}
{{--        let registerSaveUrl = "{{ route('front.save.register') }}"; --}}
{{--        let logInUrl = "{{ route('login') }}"; --}}
{{--    </script> --}}
{{--    <script src="{{asset('assets/js/front_register/front_register.js')}}"></script> --}}
{{-- @endsection --}}
