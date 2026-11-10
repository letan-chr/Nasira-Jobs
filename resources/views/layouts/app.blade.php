<!DOCTYPE html>
<html lang="en" {{ checkLanguageSession() == 'ar' ? 'dir=rtl' : '' }}>
<!--begin::Head-->

<head>
    <base href="/">
    <title>@yield('title') | {{ getAppName() }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ getSettingValue('favicon') }}" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->

    {{-- Root-relative asset paths avoid https://127.0.0.1 (HSTS/APP_URL) breaking local artisan serve. --}}
    <link rel="stylesheet" type="text/css" href="/assets/css/third-party.css">
    @if (getLoggedInUser()->theme_mode)
        <link rel="stylesheet" type="text/css" href="/assets/css/custom-dark.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/style.dark.css">
        <link rel="stylesheet" type="text/css" href="/css/plugins.dark.css">
    @else
        <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="/css/plugins.css">
        <link rel="stylesheet" type="text/css" href="/css/custom.css">
    @endif
    <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
    @livewireStyles
    <link rel="stylesheet" type="text/css" href="/vendor/rappasoft/livewire-tables/css/laravel-livewire-tables.min.css">
    <link rel="stylesheet" type="text/css" href="/vendor/rappasoft/livewire-tables/css/laravel-livewire-tables-thirdparty.min.css">

    @routes
    @livewireScripts
    <script src="/vendor/rappasoft/livewire-tables/js/laravel-livewire-tables.min.js"></script>
    <script src="/vendor/rappasoft/livewire-tables/js/laravel-livewire-tables-thirdparty.min.js"></script>

    <script src="{{ mix('js/third-party.js') }}"></script>

    <script data-turbo-eval="false">
        let lancode = "{{ checkLanguageSession() }}";
    </script>
    <script data-turbo-eval="false">
        let lang = "{{ checkLanguageSession() ?? 'en' }}"
    </script>
    <script src="{{ mix('js/pages.js') }}"></script>

    @if (checkLanguageSession() == 'ar')
        <style>
            /* img{
                margin-left: 10px;
            } */
            .aside-menu-container {
                right: 0;
            }
            @media (min-width: 1200px) {
                .wrapper {
                    padding-right: 16.563rem;
                    padding-left: 0;
                    transition: padding-left 0.3s ease;
                }
            }
            .collapsed-menu .wrapper {
                padding-right: 5rem !important;
                padding-left: 0 !important;
            }
            /* .aside-menu-container {
                right: 0 !important;
            } */
            ul.aside-menu-container__aside-menu.nav.flex-column {
                padding: 0 !important;
            }

            /* new code ad */
            .wrapper.d-flex.flex-column.flex-row-fluid {
                padding-left: 0 !important;
            }
            @media (min-width: 1200px) {
                .wrapper {
                    transition: padding-left 0.3s ease;
                    padding-right: 16.563rem;
                }
            }

            /* .dropdown.dropdown-hover .dropdown-menu {
                right: -250px !important;
            } */
            @media (max-width: 1199px) {
                .aside-menu-container.collapsed-menu {
                    right: 0 !important;
                }
            }
            @media (max-width: 1199px) {
                .aside-menu-container {
                    position: fixed;
                    width: calc(100% - 30px);
                    top: 0;
                    right: -265px !important;
                    max-width: 265px;
                }
            }
            @media (max-width: 1199px) {
                .header .top-navbar {
                    transition: width, left, right, 0.3s;
                    position: fixed;
                    left: -265px;
                    top: 0;
                    bottom: 0;
                    width: 265px;
                    z-index: 999;
                    background: #FFFFFF;
                }
            }
            @media (max-width: 1199px) {
                .header .show-nav {
                    left: 0;
                }
            }






            .aside-menu-container__aside-menu .nav-item .nav-link:hover, .aside-menu-container__aside-menu .nav-item.active>.nav-link {
                border-right-color: #6571ff !important;
                border-left-color: none;
            }
            .aside-menu-container__aside-menu .nav-item .nav-link {
                border-right: .313rem solid transparent !important;
                border-left: none;
            }
            .aside-menu-container__search-icon {
                right: 10px;
            }
            .aside-menu-container__aside-search .form-control {
                padding-right: 1.875rem;
            }
            .table.table-striped > :not(caption) > * > * , .table.table-striped > thead > tr > th{
                padding: 0.625rem 1.875rem 0.625rem 0.25rem !important;
                vertical-align: middle;
            }
            .dropdown-toggle:after {
                margin-right: 10px;
                margin-left: 0;
            }
            .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
                border-bottom-right-radius: 0;
                border-top-right-radius: 0;
                border-bottom-left-radius: 5px;
                border-top-left-radius: 5px;
            }
            .input-group.has-validation>:nth-last-child(n+3):not(.dropdown-toggle):not(.dropdown-menu).select2-container--bootstrap-5 .select2-selection, .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu).select2-container--bootstrap-5 .select2-selection {
                border-bottom-left-radius: 0;
                border-top-left-radius: 0;
                border-bottom-right-radius: 5px;
                border-top-right-radius: 5px;
            }
            .ql-editor {
                direction: rtl;
                text-align: right;
            }
            .iti--allow-dropdown .iti__flag-container, .iti--separate-dial-code .iti__flag-container {
                right: 0;
                left: auto;
            }
            #phoneNumber {
                text-align: end;
                padding-right: 85px;
            }
            #defaultCountryData {
                text-align: start;
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
            .modal-header .btn-close {
                margin: -0.9375rem -0.9375rem -0.9375rem -0.9375rem !important;
            }
            .form-switch .form-check-input {
                margin-left: 0px !important;
            }
            .form-check {
                padding-left: 0px !important;
            }.daterangepicker{
                left: 68px !important;
            }
            .alert span{
                margin: 10px;
            }
            .iti__country-list {
                text-align: right;
            }
            .iti__flag-box, .iti__country-name {
                margin-left: 6px;
            }
            .toast-title, .toast-message {
                margin-right: 20px;
            }
        </style>
    @else
        <style>
            @media (max-width: 1199px) {
            .header .top-navbar {
                transition: width, left, right, 0.3s;
                position: fixed;
                right: -265px;
                top: 0;
                bottom: 0;
                width: 265px;
                z-index: 999;
                background: #FFFFFF;
            }
            }
            @media (max-width: 1199px) {
            .header .show-nav {
                right: 0;
            }
            }
        </style>
    @endif

    @include('partials.appearance-css')
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="overflow-x-hidden">
    <div class="d-flex flex-column flex-root vh-100">
        <div class="d-flex flex-row flex-column-fluid">
            @include('layouts.sidebar')
            <div class="wrapper d-flex flex-column flex-row-fluid">
                <div class='container-fluid d-flex align-items-stretch justify-content-between px-0'>
                    @include('layouts.header')
                </div>
                <div class='content d-flex flex-column flex-column-fluid pt-7'>
                    @yield('header_toolbar')
                    <div class='d-flex flex-wrap flex-column-fluid'>
                        @yield('content')
                    </div>
                </div>
                <div class='container-fluid'>
                    @include('layouts.footer')
                </div>
            </div>
        </div>
    </div>
    {{ Illuminate\Support\Facades\Log::info(Config::get('app.locale')) }}
    {{ Illuminate\Support\Facades\Log::info(getLoggedInUser()->language) }}
    @include('user_profile.edit_profile_modal')
    @include('user_profile.change_password_modal')

    <!--begin::Javascript-->
    {{ Form::hidden('profile-phone-no', old('region_code') . old('phone'), ['id' => 'profilePhoneNo']) }}


    <script data-turbo-eval="false">
        (function($) {
            let currentLocale = "{{ Config::get('app.locale') }}";
            Lang.setLocale(currentLocale);
            $.fn.button = function(action) {
                if (action === 'loading' && this.data('loading-text')) {
                    this.data('original-text', this.html()).html(this.data('loading-text')).prop('disabled', true);
                }
                if (action === 'reset' && this.data('original-text')) {
                    this.html(this.data('original-text')).prop('disabled', false);
                }
            };
        }(jQuery));
        $(document).ready(function() {
            $('.alert').delay(5000).slideUp(300);
        });
        $('[data-dismiss=modal]').on('click', function(e) {
            var $t = $(this),
                target = $t[0].href || $t.data('target') || $t.parents('.modal') || [];

            $(target).modal('hide');
        });
        let utilsScript = "{{ asset('assets/js/inttel/js/utils.min.js') }}";
        {{--    let loggedInUserId = "{{ getLoggedInUserId() }}"; --}}
        let currentUrlName = "{{ Request::url() }}";
        let readAllNotifications = "{{ url('admin/read-all-notification') }}";
        let readNotification = "{{ url('admin/notification') }}";
        let ajaxCallIsRunning = false;
        let usersRole = '{{ !empty(getLoggedInUser()->roles->first()) ? getLoggedInUser()->roles->first()->name : '' }}';
        let sweetAlertIcon = "{{ asset('images/remove.png') }}"
        let getLoggedInUserLang = '{{ getCurrentLanguageCode() }}';
        let defaultCountryCodeValue = "{{ getSettingValue('default_country_code') }}"
    </script>
    @yield('page_scripts')
    <!--end::Page Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
