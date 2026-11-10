@extends('layouts.auth')
@section('title')
    @lang('web.new_password.reset_password')
@endsection
@section('content')
    <div class="d-flex flex-column flex-column-fluid align-items-center justify-content-center p-4">
        <div class="col-12 text-center">
            <a href="{{ route('front.home') }}" class="image mb-7 mb-sm-10" >
                <img alt="Logo" src="{{ asset(getSettingValue('logo')) }}" class="img-fluid logo-fix-size">
            </a>
        </div>
        <div class="width-540">
            @include('flash::message')
            @include('layouts.errors')
        </div>
        <div class="bg-white rounded-15 shadow-md width-540 px-5 px-sm-7 py-10 mx-auto">
            <h1 class="text-center mb-7">@lang('web.new_password.new_password')</h1>
            <form method="POST" action="{{ url('/password/reset') }}" id="">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <!--Email-->
                <div class="mb-sm-7 mb-4">
                    <label for="email" class="form-label">
                        @lang('web.common.email')<span class="required"></span>
                    </label>
                    <input id="email" class="form-control form-control-solid {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email"
                           value="{{ old('email') }}"
                           required autofocus name="email" autocomplete="off"
                           placeholder="@lang('web.common.email')"/>
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                </div>

                {{--Password--}}
                <div class="mb-sm-7 mb-4">
                    <label class="form-label"
                           for="password">@lang('web.common.password')</label>
                    <div class="mb-3 position-relative">
                        <input id="password" class="form-control form-control-solid {{ $errors->has('password') ? ' is-invalid': '' }}"
                               type="password"
                               name="password"
                               required autocomplete="off"
                               placeholder="@lang('web.common.password')"/>
                    </div>
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="fv-row mb-5">
                    <label class="form-label "
                           for="password_confirmation">@lang('web.common.confirm_password')</label>
                    <input class="form-control  form-control-solid {{ $errors->has('password_confirmation') ? ' is-invalid': '' }}" type="password" id="password_confirmation" name="password_confirmation" placeholder="@lang('web.common.confirm_password')" autocomplete="off"/>
                    <div class="invalid-feedback">
                        {{ $errors->first('password_confirmation') }}
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">@lang('web.new_password.set_new_password')</span>
                        {{--                        <span class="indicator-progress">{{__('messages.common.please_wait')}}--}}
                        {{--									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>--}}
                    </button>
                </div>
            </form>
        </div>
@endsection
