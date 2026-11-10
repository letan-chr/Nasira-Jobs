@extends('candidate.layouts.app')
@section('title')
    {{ __('messages.profile') }}
@endsection
@section('content')
    @include('flash::message')
    @include('layouts.errors')
    <div class="mb-5 mb-xl-3">
        <div class="py-0">
            @include('candidate.profile.profile_menu')
        </div>
    </div>
    <div>
        <div class="py-0">
                @yield('section')
            </div>
        </div>
@endsection
