@extends('layouts.app')
@section('title')
    {{ __('messages.state.states') }}
@endsection
@section('content')
    @include('flash::message')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:state-table/>
        </div>
    </div>
    @include('states.add_modal')
    @include('states.edit_modal')
    {{Form::hidden('stateData',true,['id'=>'indexStateData'])}}
@endsection
{{--@push('scripts')--}}
    {{--    <script src="{{mix('assets/js/states/states.js')}}"></script>--}}
{{--@endpush--}}
