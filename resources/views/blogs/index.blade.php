@extends('layouts.app')
@section('title')
    {{ __('messages.post.posts') }}
@endsection
@push('css')
{{--    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">--}}
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:post-table lazy/>
        </div>
    </div>
@endsection
