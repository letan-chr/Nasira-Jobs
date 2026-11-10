@php
    $settings = settings();
    $lang = session()->get('languageName');
@endphp
<!DOCTYPE html>
<html lang="en" {{ checkLanguageSession() == 'ar' ? 'dir=rtl' : '' }}>
<!--begin::Head-->
<head>
    <base href="../../../">
    <title>@yield('title') | {{ getAppName() }}</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="{{ getSettingValue('favicon') }}" type="image/x-icon">
    <!--begin::Fonts-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--end::Fonts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/third-party.css') }}">
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{ mix('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ mix('css/plugins.css') }}" rel="stylesheet">
    <link href="{{ mix('assets/css/custom-auth.css') }}" rel="stylesheet">
    @include('partials.appearance-css')
    @if (checkLanguageSession() == 'ar')
        <style>
            .dropdown-toggle:after {
                margin-left: 0px;
                margin-right: 10px;
            }
        </style>
    @endif
    {{-- <link href="{{ mix('css/front-pages.css') }}" rel="stylesheet" type="text/css"> --}}
{{--    <link href="{{ asset('assets/plugins/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>--}}
{{--    <link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>--}}
<!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->
<body {{ $lang == 'pt' || $lang == 'fr' || $lang == 'es' ? 'languages' : '' }}>
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-row flex-column-fluid">
        <div class="d-flex flex-column flex-row-fluid">
            <header class="bg-gradient">
                <nav class="navbar navbar-expand-lg">
                    <div class="d-flex align-items-center my-3 mx-5 ms-auto">
                        <ul class="navbar-nav d-flex justify-content-end align-items-lg-center w-100">
                            <li class="nav-item">
                                <div class="dropdown">
                                    <a class="nav-link btn text-white dropdown-toggle language-dropdown-btn px-4 py-2" type="button"
                                            aria-expanded="false">
                                        {{ getCurrentLanguageName() }}
                                    </a>
                                    <ul class="language-dropdown-menu language-menu">
                                        @foreach (getUserLanguages() as $key => $value)
                                            <li class="languageSelection {{ checkLanguageSession() == $key ? 'languageSelection-active' : '' }}"
                                                data-prefix-value="{{ $key }}">
                                                <a href="javascript:void(0)"
                                                    class="dropdown-item text-gray d-flex align-items-center {{ checkLanguageSession() == $key ? 'active' : '' }}">
                                                    @if (array_key_exists($key, \App\Models\User::LANGUAGES_IMAGE))
                                                        @foreach (\App\Models\User::LANGUAGES_IMAGE as $imageKey => $imageValue)
                                                            @if ($imageKey == $key)
                                                                <img class="{{ checkLanguageSession() == 'ar' ? 'ms-2' : 'me-2' }} country-flag"
                                                                    src="{{ asset($imageValue) }}" />
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <i class="fa fa-flag me-2 fs-7 text-danger" aria-hidden="true"
                                                            style="width: 20px;"></i>
                                                    @endif
                                                    {{ $value }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <div class="content d-flex flex-column flex-column-fluid pt-7">
                <div class='d-flex flex-wrap flex-column-fluid'>
                    @yield('content')
                </div>
            </div>
            <div class='container-fluid'>
                <footer class="border-top w-100 pt-4 mt-7 text-center">
{{--                    <p class="fs-6 text-gray-600">{{$settings['copy_right_text']}} <a href="{{route('front.home')}}" class="text-decoration-none">--}}
{{--                            {{$settings['application_name']}}</a>--}}
{{--                    </p>--}}
                </footer>
            </div>
        </div>
    </div>
</div>

<script src="{{ mix('js/auth-third-party.js') }}"></script>
<script data-turbo-eval="false">
    let defaultCountryCodeValue = "{{ getSettingValue('default_country_code') }}";
    let currentFrontLang = "{{ session()->get('languageName') ?? 'en' }}";
    let lancode = "{{ getFrontSelectLanguage() }}";
    Lang.setLocale(currentFrontLang);
</script>
<script>
    $(document).ready(function () {
        $('.alert').delay(5000).slideUp(300);
        $('#loginBtn').click(function () {
            $(this).addClass('disabled')
        })
    })

</script>
<script src="{{ asset('assets/js/custom/custom.js') }}"></script>
<script src="{{ asset('assets/js/auto_fill/auto_fill.js')}}"></script>
</body>
<!--end::Body-->
</html>
