@extends('layouts.app')
@section('title')
    {{ __('messages.job.edit_job') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
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
                    {{ Form::model($job, ['route' => ['admin.job.update', $job->id], 'method' => 'put', 'id' => 'editJobForm']) }}

                    @include('jobs.edit_fields')

                    {{ Form::close() }}
                </div>
            </div>
        </div>
        @include('jobs.modals.job_type')
        @include('jobs.modals.job_category')
        @include('jobs.modals.skills')
        @include('jobs.modals.salary_periods')
        @include('jobs.modals.countries')
        @include('jobs.modals.states')
        @include('jobs.modals.cities')
        @include('jobs.modals.career_levels')
        @include('jobs.modals.job_shifts')
        @include('jobs.modals.job_tags')
        @include('jobs.modals.required_degree_levels')
        @include('jobs.modals.functional_areas')
        {{Form::hidden('employerPanel',false,['class'=>'jobEmployeePanel'])}}
        {{Form::hidden('default-document-image-url', asset('front_web/images/job-categories.png'), ['id' => 'defaultDocumentImageUrl']) }}
        {{Form::hidden('isEdit',true,['class'=>'isEdit'])}}
    </div>
@endsection
{{--@push('scripts')--}}
    {{--    <script src="{{ asset('assets/js/autonumeric/autoNumeric.min.js') }}"></script>--}}
{{--@endpush--}}
