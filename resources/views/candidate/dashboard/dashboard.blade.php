@extends('candidate.layouts.app')
@section('title')
    {{ __('messages.candidate.dashboard') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/candidate-dashboard.css') }}">
@endpush
@section('content')
    @include('flash::message')
    <livewire:candidate-dashboard lazy/>
@endsection
