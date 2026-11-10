@extends('layouts.app')
@section('title')
    {{ __('messages.company.edit_employer') }}
@endsection
@push('css')
{{--    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>--}}
{{--    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>--}}
{{--    <link rel="stylesheet" href="{{ asset('assets/css/inttel/css/intlTelInput.css') }}">--}}
@endpush
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('company.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
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
                    {{ Form::model($user, ['route' => ['company.update', $company->id], 'method' => 'put', 'files' => 'true', 'id' => 'editCompanyForm']) }}

                    @include('companies.edit_fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
        @include('companies.modals.industries')
        @include('companies.modals.ownership_types')
        @include('companies.modals.countries')
        @include('companies.modals.states')
        @include('companies.modals.cities')
        @include('companies.modals.company_sizes')
        {{ Form::hidden('country-id', $company->user->country_id, ['id' => 'countryId']) }}
        {{ Form::hidden('state-id', $company->user->state_id, ['id' => 'stateId']) }}
        {{ Form::hidden('city-id', $company->user->city_id, ['id' => 'cityId']) }}
        {{Form::hidden('employerDetail', $company->details, ['id' => 'employerDetail'])}}
        {{Form::hidden('employerPanel',false,['class'=>'employerPanel'])}}
        {{Form::hidden('isEdit', true, ['class' => 'isEdit'])}}
        {{Form::hidden('editCompaniesForm', true, ['id' => 'editCompaniesForm'])}}
    </div>
@endsection
<script>
    var phoneNo = "{{ old('region_code').old('phone') }}";
    let countryId = '{{$company->user->country_id}}';
    let stateId = '{{$company->user->state_id}}';
    let cityId = '{{$company->user->city_id}}';
</script>
