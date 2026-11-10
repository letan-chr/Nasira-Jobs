<div class="container-fluid">
    <div class="d-flex flex-column">
        <div class="row">
            <!-- recent registered candidates starts -->
            <div class="col-xxl-6 col-12 mb-7">
                <div class="d-flex justify-content-between pb-0">
                    <h3 class="mb-0 mt-2">{{ __('messages.admin_dashboard.recent_candidates') }}</h3>
                    <div class="">
                        <a href="{{ route('candidates.index') }}"
                            class="btn btn-info">{{ __('messages.common.view_more') }} <i
                                class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="pt-7">
                    <div class="table-responsive ">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr class="">
                                    <th scope="col">{{ __('messages.common.name') }}</th>
                                    <th scope="col">{{ __('messages.common.created_date') }}</th>
                                    <th scope="col">{{ __('messages.candidate.immediate_available') }}</th>
                                    <th scope="col">{{ __('messages.candidate.is_verified') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registerCandidatesData as $registeredCandidates)
                                    <tr>
                                        <td>
                                            <a href="{{ route('candidates.show', $registeredCandidates->id) }}"
                                                class="text-decoration-none">
                                                {{ $registeredCandidates->user->full_name }}</a>
                                        </td>
                                        <td>{{ $registeredCandidates->created_at->diffForhumans() }}</td>
                                        <td>
                                            <i
                                                class="pl-5 {{ $registeredCandidates->immediate_available ? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger' }}"></i>
                                        </td>
                                        <td>
                                            <i
                                                class="pl-4 {{ $registeredCandidates->user->is_verified ? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger' }}"></i>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            {{ __('messages.employer_menu.no_data_available') }}
                                            .
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- recent registered candidates ends -->

            <!-- recent registered employers starts -->
            <div class="col-xxl-6 col-12 mb-7">
                <div class="d-flex justify-content-between pb-0">
                    <h3 class="mb-0 mt-2">{{ __('messages.admin_dashboard.recent_employers') }}</h3>
                    <div>
                        <a href="{{ route('company.index') }}"
                            class="btn btn-info">{{ __('messages.common.view_more') }} <i
                                class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="pt-7">
                    <div class="table-responsive ">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr class="">
                                    <th scope="col">{{ __('messages.common.name') }}</th>
                                    <th scope="col">{{ __('messages.common.created_date') }}</th>
                                    <th scope="col">{{ __('messages.company.website') }}</th>
                                    <th scope="col">{{ __('messages.company.location') }}</th>
                                    <th scope="col">{{ __('messages.company.is_featured') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registerEmployersData as $registeredEmployers)
                                    <tr>
                                        <td>
                                            <a class="text-decoration-none"
                                                href="{{ route('company.show', $registeredEmployers->id) }}">{{ $registeredEmployers->user->full_name }}</a>
                                        </td>
                                        <td>{{ $registeredEmployers->created_at->diffForhumans() }}</td>
                                        <td>
                                            @if ($registeredEmployers->website !== null)
                                                <a href="{{ !str_contains($registeredEmployers->website, 'https://')
                                                    ? 'https://' . $registeredEmployers->website
                                                    : $registeredEmployers->website }}"
                                                    class="text-decoration-none"
                                                    target="_blank">{{ Str::limit($registeredEmployers->website, 25, '...') }}</a>
                                            @else
                                            {{__('messages.n/a')}}
                                            @endif
                                        </td>
                                        <td>
                                            {{ $registeredEmployers->location != '' ? $registeredEmployers->location : __('messages.n/a') }}
                                        </td>
                                        <td>
                                            <i
                                                class="pl-4 {{ $registeredEmployers->activeFeatured ? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger' }}"></i>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            {{ __('messages.employer_menu.no_data_available') }}
                                            .
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- recent registered employers ends -->

            <!-- recent jobs starts -->
            <div class="col-12">
                <div class="d-flex justify-content-between pb-0">
                    <h3 class="mb-0 mt-2">{{ __('messages.admin_dashboard.recent_jobs') }}</h3>
                    <div>
                        <a href="{{ route('admin.jobs.index') }}"
                            class="btn btn-info">{{ __('messages.common.view_more') }} <i
                                class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
                <div class="pt-7">
                    <div class="table-responsive ">
                        <table class="table table-striped">
                            <thead>
                                <tr class="">
                                    <th scope="col">{{ __('messages.job.job_title') }}</th>
                                    <th scope="col">{{ __('messages.company.employer_name') }}</th>
                                    <th scope="col">{{ __('messages.common.created_date') }}</th>
                                    <th scope="col">{{ __('messages.job_category.job_category') }}</th>
                                    <th scope="col">{{ __('messages.job.job_type') }}</th>
                                    <th scope="col">{{ __('messages.job.job_shift') }}</th>
                                    <th scope="col">{{ __('messages.job.is_featured') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentJobsData as $recentJobs)
                                    <tr>
                                        <td>
                                            <a class="text-decoration-none"
                                                href="{{ route('admin.jobs.show', $recentJobs->id) }}">{{ $recentJobs->job_title }}</a>
                                        </td>
                                        <td>
                                            <a class="text-decoration-none"
                                                href="{{ route('company.show', $recentJobs->company_id) }}">{{ $recentJobs->company->user->full_name }}</a>
                                        </td>
                                        <td>{{ $recentJobs->created_at->diffForhumans() }}</td>
                                        <td>{{ $recentJobs->jobCategory->name }}</td>
                                        <td>{{ Str::limit($recentJobs->jobType->name, 50, '...') }}</td>
                                        <td>{{ !empty($recentJobs->jobShift) ? $recentJobs->jobShift->shift : __('messages.n/a') }}
                                        </td>
                                        <td>
                                            <i
                                                class="pl-4 {{ $recentJobs->activeFeatured ? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger' }}"></i>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            {{ __('messages.employer_menu.no_data_available') }}
                                            .
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- recent jobs ends -->
        </div>
    </div>
</div>
