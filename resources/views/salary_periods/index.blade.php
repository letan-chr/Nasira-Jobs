@extends('layouts.app')
@section('title')
    {{ __('messages.salary_periods') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:salary-period-table/>
        </div>
    </div>
    @include('salary_periods.add_modal')
    @include('salary_periods.edit_modal')
    @include('salary_periods.show_modal')
    {{Form::hidden('salaryPeriodData',true,['id'=>'indexSalaryPeriodData'])}}
@endsection
{{--@push('scripts')--}}
    {{--    <script src="{{mix('assets/js/salary_periods/salary_periods.js')}}"></script>--}}
{{--@endpush--}}
