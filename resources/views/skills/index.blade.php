@extends('layouts.app')
@section('title')
    {{ __('messages.skills') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:skill-table/>
        </div>
    </div>
    @include('skills.add_modal')
    @include('skills.edit_modal')
    @include('skills.show_modal')
    {{Form::hidden('skillsData',true,['id'=>'indexSkillsData'])}}
@endsection
{{--@push('scripts')--}}
{{--    <script src="{{mix('assets/js/skills/skills.js')}}"></script>--}}
{{--@endpush--}}
