@extends('layouts.app')
@section('title')
    {{ __('messages.role.new_role') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('roles.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('layouts.errors')
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => 'roles.store', 'id' => 'createRoleForm']) }}
                    @include('roles.fields', ['role' => null, 'rolePermissions' => old('permissions', []), 'isSystemRole' => false])
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
