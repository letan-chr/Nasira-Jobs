@extends('employer.layouts.app')
@section('title')
    {{ __('messages.employer_dashboard.dashboard') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">
@endpush
@section('content')
    <livewire:employer-dashboard lazy/>

    <div class="card card-xl-stretch mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                                    <span
                                            class="card-label fs-3 mb-1">{{ __('messages.job_applications') }}</span>
            </h3>
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="row justify-content-end">
                    <div class="col-lg-4 col-md-4 col-xl-3 col-sm-4 mt-3 mt-md-0 ">
                        <div class="card-header-action w-100">
                            {{  Form::select('jobs', $jobStatus, null, ['id' => 'jobStatus', 'class' => 'form-control status-filter', 'placeholder' => __('messages.flash.select_job')]) }}
                        </div>
                    </div>
                    <div class="col-lg-4  col-md-4 col-xl-3 col-sm-4 mt-3 mt-md-0">
                        <div class="card-header-action w-100">
                            {{  Form::select('gender', getTranslatedData($gender), null, ['id' => 'gender', 'class' => 'form-control status-filter', 'placeholder' => __('messages.company.select_gender')]) }}
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-xl-4 col-sm-4 mt-0">
                        <div id="timeRange" class="time_range time_range_width w-30 border rounded-2 p-3">
                            <i class="far fa-calendar-alt"
                               aria-hidden="true"></i>&nbsp;&nbsp;<span></span> <b
                                    class="caret"></b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="jobContainer" class="card-body">
            <canvas id="employerDashboardChart" width="400" height="400"></canvas>
        </div>
    </div>

    <livewire:employer-dashboard-table lazy/>
@endsection
