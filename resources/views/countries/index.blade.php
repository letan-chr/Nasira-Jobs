@extends('layouts.app')
@section('title')
    {{ __('messages.country.countries') }}
@endsection
@push('css')
{{--    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">--}}
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:country-table lazy/>
        </div>
    </div>
    @include('countries.add_modal')
    @include('countries.edit_modal')
    {{Form::hidden('countriesData',true,['id'=>'indexCountriesData'])}}
@endsection
