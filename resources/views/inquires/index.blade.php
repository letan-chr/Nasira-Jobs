@extends('layouts.app')
@section('title')
    {{ __('messages.inquires') }}
@endsection
@section('content')@include('flash::message')
<div class="container-fluid">
    <div class="d-flex flex-column ">
        <livewire:inquiries-table/>
    </div>
</div>
@include('inquires.show_modal')
@endsection
{{--@push('scripts')--}}
{{--    <script src="{{mix('assets/js/inquires/inquires.js')}}"></script>--}}
{{--@endpush--}}
