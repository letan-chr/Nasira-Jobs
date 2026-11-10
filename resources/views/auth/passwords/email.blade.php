@extends('layouts.auth')
@section('title')
    @lang('web.reset_password.forgot_password')
@endsection
@section('content')
<div class="d-flex flex-column flex-column-fluid align-items-center justify-content-center p-0">
    <div class="col-12 text-center">
        <a href="{{ route('front.home') }}" class="image mb-7 mb-sm-10" >
            <img alt="Logo" src="{{ asset(getSettingValue('logo')) }}" class="img-fluid logo-fix-size">
        </a>
    </div>
    <div class="width-540">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    </div>
    <div class="bg-theme-white rounded-15 shadow-md width-540 px-5 px-sm-7 py-10 mx-auto">
        <div class="text-center">
            <h1 class="text-center mb-7">@lang('web.reset_password.reset_password')</h1>
            <div class="mb-4">
                @lang('web.reset_password.email_to_reset_your_password')
            </div>
        </div>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-sm-7 mb-4">
                <label for="formInputEmail" class="form-label">
                    @lang('web.common.email'):<span class="required"></span>
                </label>
                <input class="form-control" type="email"
                       placeholder="@lang('web.reset_password.your_email')" name="email" autocomplete="off" value="{{ old('email') }}" required/>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">@lang('web.reset_password.email_password_reset_link')</button>
                <a href="{{ route('front.home') }}" class="btn btn-secondary {{ checkLanguageSession() == 'ar' ? 'me-3' : 'ms-3' }}" >@lang('web.reset_password.cancel')</a>
            </div>
        </form>
    </div>
</div>

@endsection
