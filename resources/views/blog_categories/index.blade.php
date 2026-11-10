@extends('layouts.app')
@section('title')
    {{ __('messages.post_category.post_categories') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:post-category-table/>
        </div>
    </div>
    @include('blog_categories.add_modal')
    @include('blog_categories.edit_modal')
    @include('blog_categories.show_modal')
@endsection
