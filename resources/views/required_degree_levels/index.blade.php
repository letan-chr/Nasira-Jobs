@extends('layouts.app')
@section('title')
    {{ __('messages.required_degree_levels') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
                <livewire:degree-level-table/>
        </div>
        @include('required_degree_levels.add_modal')
        @include('required_degree_levels.edit_modal')
    </div>
    {{Form::hidden('requiredDegreeLevel',true,['id'=>'indexRequiredDegreeLevel'])}}
@endsection
