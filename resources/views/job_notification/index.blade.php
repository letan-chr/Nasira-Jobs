@extends('layouts.app')
@section('title')
    {{ __('messages.job_notification.job_notifications') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="card">
        <div class="card-header border-0 pt-6 justify-content-end">
                <div class="ms-0 ms-md-2">
                    <div class="dropdown d-flex align-items-center me-4 me-md-5">
                        <button
                                class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0"
                                type="button" id="dropdownMenuButton1" data-bs-auto-close="outside"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='fas fa-filter'></i>
                        </button>
                        <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton1">
                            <div class="text-start border-bottom py-4 px-7">
                                <h3 class="text-gray-900 mb-0">{{ __('messages.common.filter_options') }}</h3>
                            </div>
                            <div class="p-5">

                                <div class="mb-5">
                                    <label class="form-label fs-6 fw-bold">{{ __('messages.employers').':' }}</label>
                                    {{ Form::select('employers', $companies,null, ['id' => 'filter_employers', 'data-control' =>'select2', 'class' => 'form-select status-selector select2-hidden-accessible data-allow-clear="true"','placeholder' => __('messages.flash.select_employer')]) }}
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-secondary"
                                            id="resetJobNotificationFilter"
                                            >{{__('messages.common.reset')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card-body p-7">
            {{ Form::open(['route' => 'job-notification.store','id' => 'createJobNotificationForm']) }}
            @include('job_notification.send_notification')
            {{ Form::close() }}
        </div>
        </div>
    </div>
    @include('job_notification.templates.templates')
    {{Form::hidden('getEmployerJobs',url('admin/employer-jobs'),['id'=>'indexGetEmployerJobs'])}}
    {{Form::hidden('jobDetails',url('admin/jobs'),['id'=>'indexJobDetails'])}}
    {{Form::hidden('jobNotification',url('admin/job-notifications'),['id'=>'indexJobNotification'])}}
@endsection
@push('scripts')
    <script>
        let getEmployerJobs = "{{ url('admin/employer-jobs') }}";
        let jobDetails = "{{ url('admin/jobs') }}";
        let jobNotification = "{{ url('admin/job-notifications') }}";
    </script>
    {{--    <script src="{{mix('assets/js/jobs/job_notification.js')}}"></script> --}}
@endpush
