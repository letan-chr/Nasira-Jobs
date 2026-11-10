<!DOCTYPE html>
<html lang="en" {{ checkLanguageSession() == 'ar' ? 'dir=rtl' : '' }}>
<!--begin::Head-->
<head>
    @include('google_analytics')
    <base href="/">
    <title>@yield('title') | {{ getAppName() }}</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ getSettingValue('favicon') }}"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/third-party.css">
    @if(getLoggedInUser()->theme_mode)
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
    <link rel="stylesheet" type="text/css" href="/css/admin-livewire-tables.css?v=3">
    <style>[wire\:cloak], [x-cloak] { display: revert !important; }</style>

    @routes
    @livewireScriptConfig
    <script src="/vendor/livewire/livewire.min.js" data-csrf="{{ csrf_token() }}" data-update-uri="/livewire/update"></script>
    <script src="/vendor/rappasoft/livewire-tables/js/laravel-livewire-tables.min.js"></script>
    <script src="/vendor/rappasoft/livewire-tables/js/laravel-livewire-tables-thirdparty.min.js"></script>

        @if (checkLanguageSession() == 'ar')
            <style>
                .daterangepicker{
                    left: 355px !important;
                    right: auto !important;
                }
                .modal-header .btn-close {
                    margin: -0.9375rem -0.9375rem -0.9375rem -0.9375rem !important;
                }
                .horizontal-sidebar .horizontal-menu .nav-item .nav-link .horizontal-menu-icon {
                    padding-left: .625rem;
                }
                .iti--allow-dropdown .iti__flag-container, .iti--separate-dial-code .iti__flag-container {
                    right: 0;
                    left: auto;
                }
                #phoneNumber, #defaultCountryData {
                    text-align: end;
                    padding-right: 85px
                }
                .ql-editor {
                    direction: rtl;
                    text-align: right;
                }
                .input-group.has-validation>.dropdown-toggle:nth-last-child(n+4), .input-group.has-validation>:nth-last-child(n+3):not(.dropdown-toggle):not(.dropdown-menu), .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3), .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu) {
                    border-bottom-left-radius: 0;
                    border-top-left-radius: 0;
                    border-bottom-right-radius: 5px;
                    border-top-right-radius: 5px;
                }
                .input-group>:not(:first-child):not(.dropdown-menu):not(.valid-tooltip):not(.valid-feedback):not(.invalid-tooltip):not(.invalid-feedback) {
                    border-bottom-right-radius: 0;
                    border-top-right-radius: 0;
                    border-bottom-left-radius: 5px;
                    border-top-left-radius: 5px;
                }
                .table.table-striped > :not(caption) > * > * , .table.table-striped > thead > tr > th{
                    padding: 0.625rem 1.875rem 0.625rem 0.25rem !important;
                    vertical-align: middle;
                }
                .toast-title, .toast-message {
                    margin-right: 20px;
                }
            </style>
        @endif
    @include('partials.appearance-css')
</head>
<script data-turbo-eval="false">
    let lancode = "{{ checkLanguageSession() }}";
</script>
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ mix('js/third-party.js') }}"></script>
<script src="{{ mix('js/pages.js') }}"></script>
<body class="overflow-x-hidden">
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid">
        <div class="header fixed-header">
            @include('employer.layouts.header')
        </div>
        <div class="theme-wrapper d-flex flex-column flex-row-fluid">
            <div class='d-flex flex-column flex-row-fluid'>
                <div class="d-flex flex-column flex-column-fluid pt-7">
                    <div class="content flex-column-fluid">
                        <div class="container-fluid container-xxl">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='container-fluid container-xxl'>
            @include('layouts.footer')
        </div>
        @include('employer_profile.edit_profile_modal')
        @include('employer_profile.change_password_modal')
    </div>
</div>
{{Form::hidden('employerProfileData',true,['id'=>'indexEmployerProfileData'])}}
{{Form::hidden('default-image-url', asset('assets/img/infyom-logo.png'), ['id' => 'defaultImageUrl'])}}
<script data-turbo-eval="false">
    var hostUrl = 'assets/';
    let getLoggedInUserLang = '{{getCurrentLanguageCode()}}';
    let defaultCountryCodeValue = "{{ getSettingValue('default_country_code')}}";
    Lang.setLocale(getLoggedInUserLang);
</script>
<script>
    $(document).ready(function () {
        $('.alert').delay(5000).slideUp(300);
    });
    var stripe = '';
    @if(!empty(getEnvSetting()['stripe_key']))
         stripe = Stripe('{{ getEnvSetting()['stripe_key'] }}');
    @elseif(config('services.stripe.key'))
        stripe = Stripe('{{config('services.stripe.key')}}');
    @endif

    //fix menu overflow under the responsive table
    // hide menu on click... (This is a must because when we open a menu )
    $(document).click(function (event) {
        //hide all our dropdowns
        $('.dropdown-menu[data-parent]').hide();
    });

    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css("overflow", "unset");
    }).on('hide.bs.dropdown', function () {
        $('.table-responsive').css("overflow", "auto");
    })

</script>
@stack('scripts')
</body>
</html>
