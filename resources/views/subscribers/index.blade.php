@extends('layouts.app')
@section('title')
    {{ __('messages.subscribers') }}
@endsection
@push('css')
        <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column ">
        @include('flash::message')
        <livewire:subscriber-table/>
    </div>
</div>
@endsection
{{--@push('scripts')--}}
{{--    <script src="{{mix('assets/js/subscribers/subscribers.js')}}"></script>--}}
{{--@endpush--}}
