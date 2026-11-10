@extends('layouts.app')
@section('title')
    {{ __('messages.transactions') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:transaction-table/>
        </div>
    </div>
@endsection
{{--@push('scripts')--}}
{{--    <script src="{{ asset('js/currency.js') }}"></script>--}}
{{--    <script src="{{mix('assets/js/transactions/transactions.js')}}"></script>--}}
{{--@endpush--}}
