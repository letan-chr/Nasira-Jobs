@extends('layouts.app')
@section('title')
    {{ __('messages.languages') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:language-table/>
        </div>
    </div>
    @include('languages.add_modal')
    @include('languages.edit_modal')
    {{Form::hidden('setLanguageData',true,['id'=>'indexSetLanguageData'])}}
@endsection
{{--@push('scripts')--}}
{{--    <script src="{{mix('assets/js/languages/languages.js')}}"></script>--}}
{{--@endpush--}}
