@extends('layouts.app')
@section('title')
    {{ __('messages.candidate.edit_admin') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('admin.index') }}"
                   class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
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
                    {{ Form::model($user, ['route' => ['admin.update', $user->id], 'method' => 'put', 'id' => 'editAdminForm', 'files' => 'true']) }}

                    @include('admins.edit_fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let isEdit = true;
        var phoneNo = "{{ old('region_code').old('phone') }}";
    </script>
    {{--    <script src="{{mix('assets/js/custom/input_price_format.js')}}"></script>--}}
    {{--    <script src="{{mix('assets/js/candidate/create-edit.js')}}"></script>--}}
    {{--    <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script>--}}
@endpush
