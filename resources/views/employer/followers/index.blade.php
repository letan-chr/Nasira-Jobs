@extends('employer.layouts.app')
@section('title')
    {{ __('messages.company.followers') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:employer-follower-table/>
        </div>
@endsection

