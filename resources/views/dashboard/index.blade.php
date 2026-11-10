@extends('layouts.app')
@section('title')
    {{ __('messages.dashboard') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <livewire:admin-dashboard lazy />
                <div class="col-xxl-6 mb-7 col-12">
                    <div class="card">
                        <div class="card-header pb-0 px-10">
                            <h3 class="mb-0 p-2">{{ __('messages.admin_dashboard.post_statistics') }}</h3>
                        </div>
                        <div class="card-body pt-7" id="postStatisticsChartContainer">
                            <canvas id="postStatisticsChart" width="515" height="400"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 mb-7 col-12">
                    <div class="card">
                        <div class="card-header pb-0 px-10">
                            <h3 class="mb-0">{{ __('messages.admin_dashboard.weekly_users') }}</h3>
                            <div id="timeRange" class="time_range time_range_width w-30 border rounded-2 p-2">
                                <i class="far fa-calendar-alt" aria-hidden="true"></i>&nbsp;&nbsp<span></span> <b
                                    class="caret"></b>
                            </div>
                        </div>
                        <div class="card-body pt-7" id="weeklyUserBarChartContainer">
                            <canvas id="weeklyUserBarChart" width="515" height="400"></canvas>
                        </div>
                    </div>
                </div>
                <livewire:admin-dashboard-table lazy />
            </div>
        </div>
    </div>
@endsection
