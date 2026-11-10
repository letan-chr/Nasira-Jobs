@extends('layouts.app')
@section('title')
    {{ __('messages.company.reported_employers') }}
@endsection
@push('css')
{{--    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">--}}
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:reported-employer-table lazy/>
        </div>
    </div>
    @include('employer.companies.reported_companies_show_modal')
@endsection

