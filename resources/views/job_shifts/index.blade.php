@extends('layouts.app')
@section('title')
    {{ __('messages.job_shifts') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column ">
        @include('flash::message')
        <livewire:job-shift-table lazy/>
    </div>
</div>

@include('job_shifts.add_modal')
@include('job_shifts.edit_modal')
@include('job_shifts.show_modal')

{{Form::hidden('indexJobShiftData',true,['id'=>'indexJobShiftData'])}}

@endsection

