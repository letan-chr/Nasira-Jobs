@extends('layouts.app')
@section('title')
    Admins
@endsection
@push('css')
    {{--    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>--}}
    {{--    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">--}}
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:admin-table/>
        </div>
    </div>
    {{Form::hidden('companiesData',true,['id'=>'indexCompanyData'])}}
@endsection

