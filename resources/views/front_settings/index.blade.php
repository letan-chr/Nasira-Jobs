@extends('layouts.app')
@section('title')
    {{ __('messages.setting.front_settings') }}
@endsection
@push('css')
    <link href="{{ asset('css/header-padding.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <div class="alert alert-danger d-none" id="validationErrorsBox">
        <i class="fa-solid fa-face-frown me-5"></i>
    </div>
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            @include('layouts.errors')
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => 'front.settings.update','files' => true,]) }}
                    @include('front_settings.fields')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
{{--@push('scripts')--}}
{{--    <script src="{{mix('assets/js/web/front_settings/front_settings.js')}}"></script>--}}
{{--@endpush--}}
