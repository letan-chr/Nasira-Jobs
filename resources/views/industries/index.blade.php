@extends('layouts.app')
@section('title')
    {{ __('messages.industries') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:industries-table/>
        </div>
    </div>
    @include('industries.add_modal')
    @include('industries.edit_modal')
    @include('industries.show_modal')
    {{Form::hidden('industries',true,['id'=>'indexIndustriesData'])}}
@endsection
{{--@push('scripts')--}}
    {{--    <script src="{{mix('assets/js/industries/industries.js')}}"></script>--}}
{{--@endpush--}}
