@extends('layouts.auth')
@section('title')
    Register
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>Register</h4></div>

        <div class="card-body pt-1">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger p-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name</label><span class="text-danger">*</span>
                            <input id="firstName" type="text"
                                   class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                   name="first_name"
                                   tabindex="1" placeholder="{{ __('messages.user.first_name')}}" value="{{ old('first_name') }}"
                                   autofocus>
                            <div class="invalid-feedback">
                                {{ $errors->first('first_name') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input id="lastName" type="text"
                                   class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                   name="last_name"
                                   tabindex="1" placeholder="{{ __('messages.user.last_name')}}" value="{{ old('last_name') }}"
                                   autofocus>
                            <div class="invalid-feedback">
                                {{ $errors->first('last_name') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label><span class="text-danger">*</span>
                            <input id="email" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   placeholder="{{ __('messages.email_address')}}" name="email" tabindex="1"
                                   value="{{ old('email') }}"
                                   required autofocus>
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input id="phone" type="text"
                                   class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                   placeholder="{{ __('messages.phone_number')}}" name="phone" tabindex="1" value="{{ old('phone') }}"
                                   autofocus>
                            <div class="invalid-feedback">
                                {{ $errors->first('phone') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="control-label">Password</label><span
                                    class="text-danger">*</span>
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}"
                                   placeholder="{{ __('messages.account_password')}}" name="password" tabindex="2" required>
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation" class="control-label">Confirm Password</label>
                            <input id="password_confirmation" type="password" placeholder="{{ __('messages.confirm_account_password') }}"
                                   class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                   name="password_confirmation" tabindex="2">
                            <div class="invalid-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                {{ __('messages.common.register') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        {{ __('messages.already_have_an_account') }}? <a href="{{ route('login') }}">{{ __('messages.sign_in') }}</a>
    </div>
@endsection
