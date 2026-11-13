@extends('employer.layouts.app')
@section('title')
    {{ __('messages.job.edit_job') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/summernote.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <div class="d-flex flex-column">
        @include('layouts.errors')
        <div class="card">
            <div class="card-body">
                {{ Form::model($job, ['route' => ['job.update', $job->id], 'method' => 'put', 'id' => 'editJobForm']) }}
                @include('employer.jobs.edit_fields')
                {{ Form::close() }}
            </div>
            {{Form::hidden('employerPanel',true,['class'=>'jobEmployeePanel'])}}
            {{Form::hidden('isEdit',true,['class'=>'isEdit'])}}
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/nasira-simple-job.js') }}?v=1"></script>
    <script src="{{ asset('js/nasira-job-roles.js') }}?v=1"></script>
@endpush
