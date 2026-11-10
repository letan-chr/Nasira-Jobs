@extends('layouts.app')
@section('title')
    {{ __('messages.career_levels') }}
@endsection
@push('css')
{{--<link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">--}}
@endpush
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:career-level-table/>
        </div>
    </div>
    @include('career_levels.add_modal')
    @include('career_levels.edit_modal')
    {{Form::hidden('careerLevelData',true,['id'=>'indexCareerLevelData'])}}
@endsection
