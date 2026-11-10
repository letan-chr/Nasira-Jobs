@extends('layouts.auth')
@section('title')
@lang('web.login')
@endsection
@section('content')
    <!--begin::Main-->
    <div class="d-flex flex-column flex-column-fluid align-items-center justify-content-center p-0">
        <div class="col-12 text-center">
            <a href="{{ route('front.home') }}" class="image mb-7 mb-sm-10" >
                <img alt="Logo" src="{{ asset(getSettingValue('logo')) }}" class="img-fluid logo-fix-size">
            </a>
        </div>
        <div class="width-540">
            @if(\Illuminate\Support\Facades\Session::has('status'))
                <p class="alert alert-success">{{ \Illuminate\Support\Facades\Session::get('status') }}</p>
            @endif
            @include('flash::message')
            @include('layouts.errors')
        </div>
        <div class="bg-theme-white rounded-15 shadow-md width-540 px-5 px-sm-7 py-10 mx-auto">
            <h4 class="text-center mb-7 fs-3">@lang('web.login')</h4>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-sm-7 mb-4">
                    <label for="formInputEmail" class="form-label">
                        @lang('web.common.email'):<span class="required"></span>
                    </label>
                    <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="formInputEmail" aria-describedby="emailHelp" "
                           type="email" placeholder="@lang('web.login_menu.enter_email')" name="email" required autocomplete="off" autofocus>
                </div>
                <div class="mb-sm-7 mb-4 position-relative">
                    <div class="d-flex justify-content-between">
                        <label for="formInputPassword" class="form-label">@lang('web.common.password'):<span class="required"></span></label>
                        <a href="{{ route('password.request') }}" class="link-info fs-6 text-decoration-none">
                            @lang('web.login_menu.forget_password')
                        </a>
                    </div>
                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="formInputPassword"
                           placeholder="@lang('web.login_menu.enter_password')" name="password" required autocomplete="off" ">
                    <span class="position-absolute d-flex align-items-center top-0 mt-7 bottom-0 end-0 me-6 input-icon input-password-hide cursor-pointer text-gray-600 change-type">
                        <i class="fas fa-eye-slash"></i>
                    </span>
                </div>
                <div class="mb-sm-7 mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="formCheck" {{ (Cookie::get('remember') !== null) ? 'checked' : '' }}>
                    <label class="form-check-label" for="formCheck">{{ __('messages.remember_me') }}</label>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary" >{{ __('messages.common.login') }}</button>
                </div>

                {{-- <div class="d-grid mt-3">
                    <button type="button" class="btn btn-danger w-100 mb-5 admin-login"  >Admin Login</button>
                </div> --}}
            </form>
        </div>
    </div>
    <!--end::Main-->
@endsection
