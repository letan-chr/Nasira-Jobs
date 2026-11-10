@extends('layouts.auth')
@section('title')
    Login
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
            <h1 class="text-center mb-7">Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-sm-7 mb-4">
                    <label for="formInputEmail" class="form-label">
                        Email:<span class="required"></span>
                    </label>
                    <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" id="formInputEmail" aria-describedby="emailHelp" "
                           type="email" placeholder="Enter Email" name="email" required autocomplete="off" autofocus>
                </div>
                <div class="mb-sm-7 mb-4 position-relative">
                    <div class="d-flex justify-content-between">
                        <label for="formInputPassword" class="form-label">Password:<span class="required"></span></label>
                        <a href="{{ route('password.request') }}" class="link-info fs-6 text-decoration-none">
                            Forgot Password ?
                        </a>
                    </div>
                    <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="formInputPassword"
                           placeholder="Enter Password" name="password" required autocomplete="off" ">
                </div>
                <div class="mb-sm-7 mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="formCheck" {{ (Cookie::get('remember') !== null) ? 'checked' : '' }}>
                    <label class="form-check-label" for="formCheck">{{ __('messages.remember_me') }}</label>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary" >Login</button>
                </div>

                {{-- <div class="d-grid mt-3">
                    <button type="button" class="btn btn-danger w-100 mb-5 admin-login"  >Admin Login</button>
                </div> --}}
            </form>
        </div>
    </div>
    <!--end::Main-->
@endsection
