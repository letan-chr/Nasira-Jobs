@extends('layouts.app')
@section('title')
    {{ __('messages.job_types') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column ">
        @include('flash::message')
        <livewire:job-type-table lazy/>
    </div>
</div>

@include('job_types.add_modal')
@include('job_types.edit_modal')
@include('job_types.show_modal')

{{Form::hidden('indexJobType',true,['id'=>'indexJobTypeData'])}}
@endsection
