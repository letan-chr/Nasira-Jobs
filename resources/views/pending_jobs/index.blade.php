@extends('layouts.app')
@section('title')
    {{ __('messages.jobs') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:pending-jobs-table lazy/>
        </div>
    </div>
    @include('pending_jobs.reason_model')
@endsection

