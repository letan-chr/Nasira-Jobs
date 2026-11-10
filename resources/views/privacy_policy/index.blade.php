@extends('layouts.app')
@section('title')
    {{ __('messages.setting.privacy_policy') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column">
        @include('flash::message')
        <div class="card">
            <div class="card-body">
                @include('privacy_policy.privacy_policy')
                {{--                    @include('privacy_policy.terms_conditions')--}}
            </div>
        </div>
    </div>
</div>
{{Form::hidden('termConditionData', $privacyPolicy['terms_conditions'], ['id' => 'termConditionData'])}}
{{Form::hidden('privacyPolicyData', $privacyPolicy['privacy_policy'], ['id' => 'privacyPolicyData'])}}
@endsection
@push('scripts')
{{--    <script src="{{ mix('assets/js/privacy_policy/privacy_policy.js') }}"></script>--}}
@endpush
