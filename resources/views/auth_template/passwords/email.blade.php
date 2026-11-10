@extends('layouts.auth')
@section('title')
    Forgot Password
@endsection
@section('content')
<div class="d-flex flex-column flex-column-fluid align-items-center justify-content-center p-0">
    <div class="col-12 text-center">
        <a href="{{ route('front.home') }}" class="image mb-7 mb-sm-10" >
            <img alt="Logo" src="{{ asset(getSettingValue('logo')) }}" class="img-fluid logo-fix-size">
        </a>
    </div>
    <div class="width-540">
        @include('flash::message')
        @include('front_web.layouts.errors')
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    </div>
    <div class="bg-theme-white rounded-15 shadow-md width-540 px-5 px-sm-7 py-10 mx-auto">
        <div class="text-center">
            <h1 class="text-center mb-7">Reset Password ?</h1>
            <div class="mb-4">
                Enter your email to reset your password.
            </div>
        </div>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-sm-7 mb-4">
                <label for="formInputEmail" class="form-label">
                    Email:<span class="required"></span>
                </label>
                <input class="form-control" type="email"
                       placeholder="Your Email" name="email" autocomplete="off" value="{{ old('email') }}" required/>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">{{ __('Email Password Reset Link') }}</button>
                <a href="{{ route('admin.login') }}" class="btn btn-secondary ms-3">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
