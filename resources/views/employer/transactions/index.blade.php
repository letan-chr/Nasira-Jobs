@extends('employer.layouts.app')
@section('title')
    {{ __('messages.transactions') }}
@endsection
@section('content')
        <div class="d-flex flex-column ">
            @include('flash::message')
            <livewire:employer-transaction-table/>
        </div>
@endsection
