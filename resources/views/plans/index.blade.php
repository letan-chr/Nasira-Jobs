@extends('layouts.app')
@section('title')
    {{ __('messages.subscriptions_plans') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:subscription-table/>
        </div>
    </div>
    @include('plans.add_modal')
    @include('plans.edit_modal')
    {{Form::hidden('planCurrency',json_encode($currency),['id'=>'indexPlanCurrency'])}}
    {{Form::hidden('planCurrencySymbols',json_encode($currencyIcon),['id'=>'indexPlanCurrencySymbols'])}}
@endsection
@push('scripts')
    {{--    <script src="{{ asset('js/currency.js') }}"></script>--}}
    {{--    <script src="{{mix('assets/js/plans/plans.js')}}"></script>--}}
    {{--    <script src="{{ asset('assets/js/autonumeric/autoNumeric.min.js') }}"></script>--}}
@endpush
