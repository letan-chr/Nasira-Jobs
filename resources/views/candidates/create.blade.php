@extends('layouts.app')
@section('title')
    {{ __('messages.candidate.new_candidate') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('candidates.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
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
                    {{ Form::open(['route' => 'candidates.store', 'id' => 'createCandidatesForm']) }}
                    @include('candidates.fields')
                    {{ Form::close() }}
                </div>
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
        {{Form::hidden('companyStateUrl', route('states-list'), ['id' => 'companyStateUrl'])}}
        {{Form::hidden('companyCityUrl', route('cities-list'), ['id' => 'companyCityUrl'])}}
        {{Form::hidden('employerPanel',false,['class'=>'employerPanel'])}}
        {{Form::hidden('isEdit', false, ['id' => 'isEdit','class'=>'isEdit'])}}
        {{Form::hidden('createCompaniesForm', true, ['id' => 'createCompaniesForm'])}}
    </div>
@endsection
@push('scripts')
    <script>
        let isEdit = false;
        var phoneNo = "{{ old('region_code').old('phone') }}";
    </script>
    {{--    <script src="{{mix('assets/js/custom/input_price_format.js')}}"></script>--}}
    {{--    <script src="{{mix('assets/js/candidate/create-edit.js')}}"></script>--}}
    {{--    <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script>--}}
@endpush
