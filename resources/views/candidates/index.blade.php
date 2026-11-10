@extends('layouts.app')
@section('title')
    {{ __('messages.candidates') }}
@endsection
@push('css')
{{--    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">--}}
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:candidate-table/>
        </div>
    </div>
    {{Form::hidden('candidateData',true,['id'=>'indexCandidateData'])}}
@endsection
