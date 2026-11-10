@extends('front_web.layouts.app')
@section('title')
    {{ __('web.login') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('front_web/css/nasira-auth.css') }}?v=2">
@endsection
@section('content')
    @php
        $envSetting = getEnvSetting();
    @endphp
    <div class="nasira-auth-page">
        <div class="nasira-auth-split">
            <aside class="nasira-auth-visual">
                <div class="nasira-auth-visual-content">
                    <span class="nasira-auth-kicker">Nasira Jobs</span>
                    <h1>Welcome back — your next opportunity is waiting</h1>
                    <p>Sign in once. We detect whether you are a candidate or employer and take you to the right dashboard.</p>
                    <ul class="nasira-auth-points">
                        <li><i class="fa-solid fa-check"></i><span>Track applications and saved jobs</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Build a professional CV in minutes</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Connect with trusted employers</span></li>
                    </ul>
                </div>
            </aside>

            <div class="nasira-auth-form-side">
                <div class="nasira-auth-card">
                    <h2>{{ __('web.login') }}</h2>
                    <p class="nasira-auth-sub">Enter your email and password to continue.</p>

                    @include('flash::message')

                    <form method="POST" action="{{ route('front.login') }}" id="candidateForm">
                        @csrf
                        <div id="candidateValidationErrBox">
                            @include('layouts.errors')
                        </div>

                        <div class="nasira-auth-field">
                            <label for="email">{{ __('web.common.email') }} <span class="req">*</span></label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ Cookie::get('email') !== null ? Cookie::get('email') : old('email') }}"
                                autofocus placeholder="@lang('web.login_menu.enter_email')" required>
                        </div>

                        <div class="nasira-auth-field">
                            <label for="password">{{ __('web.common.password') }} <span class="req">*</span></label>
                            <div class="nasira-auth-pass">
                                <input type="password" class="form-control" name="password" id="password"
                                    placeholder="@lang('web.login_menu.enter_password')"
                                    value=""
                                    required
                                    autocomplete="current-password">
                                <span class="input-icon input-password-hide change-type">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <div class="nasira-auth-meta">
                            <div class="form-check mb-0">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember"
                                    {{ Cookie::get('email') !== null || old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">{{ __('web.login_menu.remember_me') }}</label>
                            </div>
                            <a href="{{ route('password.request') }}">{{ __('web.login_menu.forget_password') }}</a>
                        </div>

                        <button type="submit" class="nasira-auth-btn">{{ __('web.login') }}</button>

                        <div class="nasira-auth-switch">
                            {{ __('web.login_menu.don\'t_have_an_account') }}
                            <a href="{{ route('candidate.register') }}">{{ __('web.sign_up') }}</a>
                        </div>

                        <div class="nasira-auth-social">
                            @if (
                                !empty($envSetting['facebook_app_id'] || config('services.facebook.client_id')) &&
                                    !empty($envSetting['facebook_app_secret'] || config('services.facebook.client_secret')) &&
                                    !empty($envSetting['facebook_redirect'] || config('services.facebook.redirect')))
                                <a href="{{ url('/login/facebook?type=1') }}"
                                    class="btn facebook-btn d-flex align-items-center justify-content-center">
                                    <i class="fa-brands fa-facebook-f me-2"></i>{{ __('web.login_menu.login_via_facebook') }}
                                </a>
                            @endif
                            @if (
                                !empty($envSetting['google_client_id'] || config('services.google.client_id')) &&
                                    !empty($envSetting['google_client_secret'] || config('services.google.client_secret')) &&
                                    !empty($envSetting['google_redirect'] || config('services.google.redirect')))
                                <a href="{{ url('/login/google?type=1') }}"
                                    class="btn google-btn d-flex align-items-center justify-content-center">
                                    <i class="fa-brands fa-google me-2"></i>{{ __('web.login_menu.login_via_google') }}
                                </a>
                            @endif
                            @if (
                                !empty($envSetting['linkedin_client_id'] || config('services.linkedin-openid.client_id')) &&
                                    !empty($envSetting['linkedin_client_secret'] || config('services.linkedin-openid.client_secret')) &&
                                    !empty(config('services.linkedin-openid.redirect')))
                                <a href="{{ url('/login/linkedin-openid?type=1') }}"
                                    class="btn linkedin-btn d-flex align-items-center justify-content-center">
                                    <i class="fa-brands fa-linkedin-in me-2"></i>{{ __('web.login_menu.login_via_linkedin') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
