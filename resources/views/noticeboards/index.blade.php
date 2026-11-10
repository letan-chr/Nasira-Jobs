@extends('layouts.app')
@section('title')
    {{ __('messages.noticeboards') }}
@endsection
@push('css')
    <link href="{{ asset('css/header-padding.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:noticeboard-table/>
        </div>
    </div>
    @include('noticeboards.add_modal')
    @include('noticeboards.edit_modal')
    @include('noticeboards.show_modal')

@endsection
