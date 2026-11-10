@extends('layouts.app')
@section('title')
    {{ __('messages.settings') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/inttel/css/intlTelInput.css') }}">
    {{--    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link href="{{ asset('css/header-padding.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            @include('layouts.errors')
            <div class="alert alert-danger fs-4 text-white d-flex align-items-center d-none" id="validationErrorsBox">
                <i class="fa-solid fa-face-frown me-5"></i>
            </div>
            <div class="mb-5 py-0">
                @include("settings.setting_menu")
                </div>
            <div class="card">
                <div class="card-body py-0">
                    @yield('section')
                </div>
            </div>
        </div>
    </div>
    {{ Form::hidden('enableEditText', __('messages.setting.enable_edit'), ['id' => 'enableEditText']) }}
    {{ Form::hidden('disableEditText', __('messages.setting.disable_edit'), ['id' => 'disableEditText']) }}
    {{ Form::hidden('enableCookie', __('messages.setting.enable_cookie'), ['id' => 'enableCookie']) }}
    {{ Form::hidden('disableCookie', __('messages.setting.disable_cookie'), ['id' => 'disableCookie']) }}
@endsection
{{--@push('scripts')--}}
{{--    <script>--}}
{{--        let enableEditText = "{{ __('messages.setting.enable_edit') }}";--}}
{{--        let disableEditText = "{{ __('messages.setting.disable_edit') }}";--}}
{{--        let enableCookie = "{{ __('messages.setting.enable_cookie') }}";--}}
{{--        let disableCookie = "{{ __('messages.setting.disable_cookie') }}";--}}
{{--    </script>--}}
    {{--    <script src="{{ asset('assets/js/summernote.min.js') }}"></script>--}}
{{--    <script src="{{ mix('assets/js/settings/settings.js') }}"></script>--}}
{{--@endpush--}}
