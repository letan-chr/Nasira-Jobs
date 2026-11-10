@extends('layouts.app')
@section('title')
    {{ __('messages.functional_areas') }}
@endsection
@push('css')
{{--       @livewireStyles--}}
{{--    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">--}}
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:functional-area-table/>
        </div>
    </div>
    @include('functional_areas.add_modal')
    @include('functional_areas.edit_modal')
    {{Form::hidden('functionalAreas',true,['id'=>'indexFunctionalAreas'])}}
@endsection
{{--@push('scripts')--}}
{{--    <script src="{{mix('assets/js/functional_areas/functional_areas.js')}}"></script>--}}
{{--@endpush--}}
