@extends('layouts.app')
@section('title')
    {{ __('messages.job_categories') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column ">
        @include('flash::message')
        <livewire:job-category-table lazy/>
    </div>
</div>
@include('job_categories.add_modal')
@include('job_categories.edit_modal')
@include('job_categories.show_modal')
{{ Form::hidden('default-document-image-url', asset('front_web/images/job-categories.png'), ['id' => 'defaultDocumentImageUrl']) }}
{{ Form::hidden('indexJobCategory', true, ['id' => 'indexJobCategoryData']) }}
@endsection
