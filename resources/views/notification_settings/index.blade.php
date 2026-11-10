@extends('layouts.app')
@section('title')
    {{ __('messages.setting.notification_settings') }}
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
                    {{ Form::open(['route' => 'notification.settings.update']) }}
                    @include('notification_settings.fields')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection

