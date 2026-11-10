@extends('layouts.app')
@section('title')
    {{ __('messages.email_templates') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:email-template-table/>
        </div>
    </div>
@endsection
