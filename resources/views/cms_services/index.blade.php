@extends('layouts.app')
@section('title')
    {{ __('messages.cms_services') }}
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
                {{ Form::open(['route' => 'cms.services.update','files' => true]) }}
                @include('cms_services.fields')
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

