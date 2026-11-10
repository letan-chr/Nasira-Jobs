@php
    $settings = settings();
    $lang = session()->get('languageName');
@endphp
<!DOCTYPE html>
<html lang="en" {{ getFrontSelectLanguage() == 'ar' ? 'dir=rtl' : '' }}>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection('meta_title')
            @yield('meta_title')
        @elseif (!empty($seo['meta_title']))
            {{ $seo['meta_title'] }}
        @else
            @yield('title') | {{ getAppName() }}
        @endif
    </title>
    @hasSection('seo_head')
        @yield('seo_head')
    @elseif (!empty($seo))
        @include('front_web.solutions.partials.seo-head', ['seo' => $seo])
    @endif
    <link rel="shortcut icon" href="{{ getSettingValue('favicon') }}" type="image/x-icon">
    <link rel="icon" href="{{ getSettingValue('favicon') }}" type="image/x-icon">
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front_web/scss/bootstrap.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="{{ asset('front_web/css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/iziToast.min.css') }}">

    <link href="{{ asset('assets/css/front-third-party.css') }}" rel="stylesheet" type="text/css">
    @if (getFrontSelectLanguage() == 'ar')
        <style>
            .notice-section .notice-content span {
                border-radius: 0px 10px 0px 10px !important;
                left: 12px;
                right: auto !important;
            }
            footer .email input {
                border-radius: 0px 10px 10px 0px !important;
            }
            footer .email .icon {
                border-radius: 10px 0px 0px 10px !important;
            }
            header .navbar .navbar-nav .nav-item .submenu {
                right: 0;
            }
            .hero-content-row {
                left: 0% !important;
            }
            .how-it-works-section .work-process .arrow1 {
                right: 24%;
            }
            .how-it-works-section .work-process .arrow2 {
                right: 57%;
            }
            .iti--allow-dropdown .iti__flag-container, .iti--separate-dial-code .iti__flag-container {
                left: auto !important;
                right: 0 !important;
            }
            .mani-blog .blog-card .card-img-top {
                border-radius: 0px 10px 10px 0px !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                left: 10px !important;
            }
            .change-type {
                top: 15%;
                right: 91% !important;
            }
            .change-type-register {
                top: 15% !important;
                right: 83% !important;
            }
            .iti__country-list {
                text-align: right;
            }
            .iti__flag-box, .iti__country-name {
                margin-left: 6px;
            }
            #phoneNumber, #defaultCountryData {
                text-align: end;
                padding-right: 85px;
            }
            .iti--separate-dial-code .iti__selected-dial-code {
                margin-right: 6px;
                margin-left: 0px;
            }
            .iti__arrow {
                margin-right: 6px !important;
                margin-left: 0px;
            }
            .toast-title, .toast-message {
                margin-right: 20px;
            }
            .breadcrumb-item + .breadcrumb-item::before {
                float: right !important;
                padding-left: 0.5rem !important;
                color: #6c757d;
                content: var(--bs-breadcrumb-divider, "/");
            }
        </style>
    @else
        <style>
            .change-type {
                top: 15%;
                left: 91%;
            }
            .change-type-register {
                top: 15% !important;
                left: 83%;
            }
        </style>
    @endif
    <link href="{{ mix('css/front-pages.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front_web/css/nasira-brand.css') }}?v=16" rel="stylesheet" type="text/css">
    <link href="{{ asset('front_web/css/nasira-solutions.css') }}?v=20" rel="stylesheet" type="text/css">
    @include('partials.appearance-css')

    @yield('page_css')
    @livewireStyles
    <link rel="stylesheet" type="text/css" href="/vendor/rappasoft/livewire-tables/css/laravel-livewire-tables.min.css">
    <link rel="stylesheet" type="text/css" href="/vendor/rappasoft/livewire-tables/css/laravel-livewire-tables-thirdparty.min.css">
    @routes

    @livewireScriptConfig
    <script src="/vendor/livewire/livewire.min.js" data-csrf="{{ csrf_token() }}" data-update-uri="/livewire/update"></script>
    <script src="/vendor/rappasoft/livewire-tables/js/laravel-livewire-tables.min.js"></script>
    <script src="/vendor/rappasoft/livewire-tables/js/laravel-livewire-tables-thirdparty.min.js"></script>

    <script src="{{ mix('js/auth-third-party.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ mix('js/front-third-party.js') }}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
        let siteKey = "{{ config('app.google_recaptcha_site_key') }}"
    </script>
    {{-- <script src="{{ mix('js/front_pages.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/custom/custom.js') }}"></script> --}}

    @yield('page_scripts')
    @foreach (googleJobSchema() as $jobSchema)
        {!! nl2br($jobSchema) !!}
    @endforeach
    <script src="{{ mix('js/front_pages.js') }}"></script>
</head>

<body {{ $lang == 'pt' || $lang == 'fr' || $lang == 'es' ? 'languages' : '' }}>
    <span class="header-padding"></span>
    @include('front_web.layouts.header')

    @yield('content')

    @if (Request::segment(1) != 'candidate-register' &&
            Request::segment(1) != 'employer-register' &&
            Request::segment(1) != 'users')
        @include('front_web.layouts.footer')
    @endif

    {{ Form::hidden('createNewLetterUrl', route('news-letter.create'), ['id' => 'createNewLetterUrl']) }}
    <script data-turbo-eval="false">
        let defaultCountryCodeValue = "{{ getSettingValue('default_country_code') }}";
        let currentFrontLang = "{{ session()->get('languageName') ?? 'en' }}";
        let lancode = "{{ getFrontSelectLanguage() }}";
        Lang.setLocale(currentFrontLang);
    </script>
     <script src="{{ asset('assets/js/custom/custom.js') }}"></script>
    <script>
        (function () {
            var item = document.querySelector('.nasira-solutions-item');
            var trigger = document.querySelector('.nasira-solutions-trigger');
            var mega = document.querySelector('.nasira-solutions-mega');
            if (!item || !trigger || !mega) return;

            function isMobileNav() {
                return window.matchMedia('(max-width: 991.98px)').matches;
            }

            function placeMega() {
                if (isMobileNav()) {
                    mega.style.left = '';
                    mega.style.width = '';
                    return;
                }

                var pad = 16;
                var width = Math.min(1100, window.innerWidth - pad * 2);
                var itemRect = item.getBoundingClientRect();
                var desiredLeft = itemRect.left + (itemRect.width / 2) - (width / 2);
                var clampedLeft = Math.max(pad, Math.min(desiredLeft, window.innerWidth - pad - width));
                mega.style.width = width + 'px';
                mega.style.left = (clampedLeft - itemRect.left) + 'px';
            }

            item.addEventListener('mouseenter', placeMega);
            item.addEventListener('focusin', placeMega);
            window.addEventListener('resize', function () {
                if (item.matches(':hover') || item.contains(document.activeElement)) {
                    placeMega();
                }
            });

            trigger.addEventListener('click', function (e) {
                if (isMobileNav()) {
                    e.preventDefault();
                    item.classList.toggle('is-open');
                }
            });
            document.addEventListener('click', function (e) {
                if (!isMobileNav()) return;
                if (!item.contains(e.target)) item.classList.remove('is-open');
            });
        })();
    </script>

    </body>

</html>
