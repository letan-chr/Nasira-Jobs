@extends('layouts.app')
@section('title')
    {{ __('messages.candidate.edit_candidate') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/inttel/css/intlTelInput.css') }}">
@endpush
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('candidates.index') }}"
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
                    {{ Form::model($user, ['route' => ['candidates.update', $candidate->id], 'method' => 'put', 'id' => 'editCandidatesForm']) }}

                    @include('candidates.edit_fields')

                    {{ Form::close() }}
                </div>
            </div>
            @include('candidates.modals.marital_status')
            @include('candidates.modals.skills')
            @include('candidates.modals.languages')
            @include('candidates.modals.countries')
            @include('candidates.modals.states')
            @include('candidates.modals.cities')
            @include('candidates.modals.career_levels')
            @include('candidates.modals.industries')
            @include('candidates.modals.functional_areas')
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        let isEdit = true;
        var phoneNo = "{{ old('region_code').old('phone') }}";
        let countryId = '{{$candidate->user->country_id}}';
        let stateId = '{{$candidate->user->state_id}}';
        let cityId = '{{$candidate->user->city_id}}';
    </script>
    {{--    <script src="{{mix('assets/js/custom/input_price_format.js')}}"></script>--}}
    {{--    <script src="{{mix('assets/js/candidate/create-edit.js')}}"></script>--}}
    {{--    <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script>--}}
@endpush
