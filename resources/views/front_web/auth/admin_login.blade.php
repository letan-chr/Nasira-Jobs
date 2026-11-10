@extends('front_web.layouts.app')
@section('title')
    {{ __('web.login') }} — Admin
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('front_web/css/nasira-auth.css') }}?v=2">
@endsection
@section('content')
    <div class="nasira-auth-page">
        <div class="nasira-auth-split">
            <aside class="nasira-auth-visual">
                <div class="nasira-auth-visual-content">
                    <span class="nasira-auth-kicker">Nasira Jobs</span>
                    <h1>Admin console</h1>
                    <p>Sign in to manage jobs, employers, candidates, appearance, and Telegram sync.</p>
                    <ul class="nasira-auth-points">
                        <li><i class="fa-solid fa-check"></i><span>Moderate listings and companies</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Configure branding &amp; settings</span></li>
                        <li><i class="fa-solid fa-check"></i><span>Keep Nasira Jobs running smoothly</span></li>
                    </ul>
                </div>
            </aside>

            <div class="nasira-auth-form-side">
                <div class="nasira-auth-card">
                    <h2>Admin {{ __('web.login') }}</h2>
                    <p class="nasira-auth-sub">Use your administrator email and password.</p>

                    @include('flash::message')

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div id="candidateValidationErrBox">
                            @include('layouts.errors')
                        </div>

                        <div class="nasira-auth-field">
                            <label for="email">{{ __('web.common.email') }} <span class="req">*</span></label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ Cookie::get('email') !== null ? Cookie::get('email') : old('email') }}"
                                autofocus placeholder="@lang('web.login_menu.enter_email')" required
                                autocomplete="username">
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
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">{{ __('web.login_menu.remember_me') }}</label>
                            </div>
                            <a href="{{ route('password.request') }}">{{ __('web.login_menu.forget_password') }}</a>
                        </div>

                        <button type="submit" class="nasira-auth-btn">{{ __('web.login') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
