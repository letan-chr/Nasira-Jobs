@extends('front_web.layouts.app')
@section('title')
    {{ __('web.register') }}
@endsection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('front_web/css/nasira-auth.css') }}?v=2">
@endsection
@section('content')
    @php
        $envSetting = getEnvSetting();
        $defaultRole = request()->routeIs('employer.register') ? '2' : '1';
    @endphp
    <div class="nasira-auth-page">
        <div class="nasira-auth-split">
            <aside class="nasira-auth-visual">
                <div class="nasira-auth-visual-content">
                    <span class="nasira-auth-kicker">Create your Nasira account</span>
                    <h1>Join as a candidate, employer, or continue as a guest</h1>
                    <p>One clean signup. Pick your role, fill a few details, and start exploring jobs or hiring talent.</p>
                    <ul class="nasira-auth-points">
                        <li><i class="fa-solid fa-user"></i><span>Candidates — apply faster with a strong CV</span></li>
                        <li><i class="fa-solid fa-building"></i><span>Employers — post jobs and find talent</span></li>
                        <li><i class="fa-solid fa-compass"></i><span>Guests — browse freely without an account</span></li>
                    </ul>
                </div>
            </aside>

            <div class="nasira-auth-form-side">
                <div class="nasira-auth-card">
                    <h2>{{ __('web.register') }}</h2>
                    <p class="nasira-auth-sub">Choose your role and create your account.</p>

                    @include('flash::message')

                    <form method="POST" id="addCandidateNewForm">
                        @csrf
                        <div id="candidateValidationErrBox">
                            @include('layouts.errors')
                        </div>

                        <div class="nasira-auth-field">
                            <label for="registerRole">I want to join as <span class="req">*</span></label>
                            <select id="registerRole" class="form-select" aria-label="Select role">
                                <option value="1" {{ $defaultRole === '1' ? 'selected' : '' }}>Candidate</option>
                                <option value="2" {{ $defaultRole === '2' ? 'selected' : '' }}>Employer</option>
                                <option value="guest">Guest (browse without account)</option>
                            </select>
                            <input type="hidden" name="type" id="registerType" value="{{ $defaultRole }}" />
                        </div>

                        <div id="nasiraAccountFields" class="nasira-auth-account-fields">
                            <div class="nasira-auth-row">
                                <div class="nasira-auth-field">
                                    <label for="candidateFirstName" id="firstNameLabel">{{ __('web.common.first_name') }} <span class="req">*</span></label>
                                    <input type="text" class="form-control" name="first_name" id="candidateFirstName"
                                        placeholder="{{ __('web.register_menu.enter_first_name') }}" required>
                                </div>
                                <div class="nasira-auth-field" id="lastNameWrap">
                                    <label for="candidateLastName">{{ __('web.common.last_name') }} <span class="req">*</span></label>
                                    <input type="text" class="form-control" name="last_name" id="candidateLastName"
                                        placeholder="{{ __('web.register_menu.enter_last_name') }}" required>
                                </div>
                            </div>

                            <div class="nasira-auth-field">
                                <label for="candidateEmail">{{ __('web.common.email') }} <span class="req">*</span></label>
                                <input type="email" class="form-control" name="email" id="candidateEmail"
                                    placeholder="{{ __('web.register_menu.enter_email_address') }}" required>
                            </div>

                            <div class="nasira-auth-row">
                                <div class="nasira-auth-field">
                                    <label for="candidatePassword">{{ __('web.common.password') }} <span class="req">*</span></label>
                                    <div class="nasira-auth-pass">
                                        <input type="password" class="form-control" name="password" id="candidatePassword"
                                            placeholder="{{ __('web.register_menu.enter_password') }}" required
                                            onkeypress="return avoidSpace(event)">
                                        <span class="input-icon input-password-hide change-type change-type-register">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="nasira-auth-field">
                                    <label for="candidateConfirmPassword">{{ __('web.common.confirm_password') }} <span class="req">*</span></label>
                                    <div class="nasira-auth-pass">
                                        <input type="password" class="form-control" name="password_confirmation"
                                            id="candidateConfirmPassword"
                                            placeholder="{{ __('web.register_menu.confirm_password') }}" required
                                            onkeypress="return avoidSpace(event)">
                                        <span class="input-icon input-password-hide change-type change-type-register">
                                            <i class="fas fa-eye-slash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" name="privacyPolicy" class="form-check-input" id="privacyPolicy" required>
                                <label class="form-check-label" for="privacyPolicy">
                                    @lang('messages.by_signing_up_you_agree_to_our')
                                    <a href="{{ route('terms.conditions.list') }}" target="_blank" class="text-primary">{{ __('messages.setting.terms_conditions') }}</a>
                                    &
                                    <a href="{{ route('privacy.policy.list') }}" target="_blank" class="text-primary">{{ __('messages.setting.privacy_policy') }}</a>.
                                </label>
                            </div>

                            @if ($isGoogleReCaptchaEnabled)
                                <div class="mb-3">
                                    <div class="g-recaptcha d-flex justify-content-center"
                                        id="gRecaptchaContainerCompanyRegistration"
                                        data-sitekey="{{ config('app.google_recaptcha_site_key') }}"></div>
                                    <div id="g-recaptcha-error"></div>
                                </div>
                            @endif

                            <button type="submit" class="nasira-auth-btn" id="btnCandidateSave"
                                data-loading-text="<span class='spinner-border spinner-border-sm'></span> {{ __('messages.common.process') }}">
                                {{ __('web.register_menu.create_account') }}
                            </button>
                        </div>

                        <div id="nasiraGuestPanel" class="nasira-auth-guest">
                            <p>No account needed. Continue browsing jobs, companies, CV tools, and Solutions as a guest. You can create an account anytime.</p>
                            <a href="{{ route('front.home') }}" class="nasira-auth-btn nasira-auth-btn--ghost">
                                Continue as Guest <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>

                        <div class="nasira-auth-switch">
                            Already have an account?
                            <a href="{{ route('front.candidate.login') }}">{{ __('web.login') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{ Form::hidden('isGoogleReCaptchaEnabled', (bool) $isGoogleReCaptchaEnabled, ['id' => 'isGoogleReCaptchaEnabled']) }}
@endsection
@section('page_scripts')
    <script>
        let registerSaveUrl = "{{ route('front.save.register') }}";
        let candidateLogInUrl = "{{ route('front.candidate.login') }}";
        let isGoogleReCaptchaEnabled = {{ $isGoogleReCaptchaEnabled ? 'true' : 'false' }};
    </script>
    @if ($isGoogleReCaptchaEnabled)
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script src="{{ asset('assets/js/front_register/google-recaptcha.js') }}"></script>
    @endif
    <script src="{{ asset('assets/js/front_register/front_register.js') }}"></script>
    <script>
        (function () {
            var role = document.getElementById('registerRole');
            var type = document.getElementById('registerType');
            var fields = document.getElementById('nasiraAccountFields');
            var guest = document.getElementById('nasiraGuestPanel');
            var lastWrap = document.getElementById('lastNameWrap');
            var lastInput = document.getElementById('candidateLastName');
            var firstLabel = document.getElementById('firstNameLabel');
            if (!role) return;

            function sync() {
                var v = role.value;
                if (v === 'guest') {
                    fields.classList.add('is-hidden');
                    guest.classList.add('is-visible');
                    fields.querySelectorAll('input,button').forEach(function (el) {
                        if (el.name === 'type') return;
                        el.disabled = true;
                    });
                    return;
                }
                fields.classList.remove('is-hidden');
                guest.classList.remove('is-visible');
                fields.querySelectorAll('input,button').forEach(function (el) { el.disabled = false; });
                type.value = v;
                if (v === '2') {
                    firstLabel.innerHTML = '{{ __('web.common.name') }} <span class="req">*</span>';
                    lastWrap.style.display = 'none';
                    lastInput.required = false;
                    lastInput.value = '';
                } else {
                    firstLabel.innerHTML = '{{ __('web.common.first_name') }} <span class="req">*</span>';
                    lastWrap.style.display = '';
                    lastInput.required = true;
                }
            }
            role.addEventListener('change', sync);
            sync();
        })();
    </script>
@endsection
