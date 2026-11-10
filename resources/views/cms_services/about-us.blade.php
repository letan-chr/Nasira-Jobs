@extends('layouts.app')
@section('title')
    {{ __('messages.about_us_services')}}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            @include('layouts.errors')
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => 'cms.about-us.update','files' => true,]) }}
                    @include('cms_services.about-edit')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
