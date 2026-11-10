@extends('layouts.app')
@section('title')
    {{ __('messages.ownership_types') }}
@endsection
@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column ">
        @include('flash::message')
        <livewire:ownership-type-table/>
    </div>
</div>
@include('ownership_types.add_modal')
@include('ownership_types.edit_modal')
@include('ownership_types.show_modal')
{{Form::hidden('ownershipTypeData',true,['id'=>'indexOwnershipTypeData'])}}
@endsection
{{--@push('scripts')--}}
    {{--    <script src="{{mix('assets/js/ownership_types/ownership_types.js')}}"></script>--}}
{{--@endpush--}}
