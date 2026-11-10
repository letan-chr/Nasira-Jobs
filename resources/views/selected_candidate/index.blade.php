@extends('layouts.app')
@section('title')
    {{ __('messages.selected_candidate') }}
@endsection
@push('css')
<link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:selected-candidate-table/>
        </div>
    </div>
@endsection
