<div class="container-fluid">
    <div class="d-flex flex-column">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="row">
                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a href="{{ route('candidates.index') }}" class=" text-decoration-none">
                            <div
                                class="bg-primary shadow-md rounded-10  px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                                <div
                                    class="bg-cyan-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-users fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white">
                                        {{ numberFormatShort($dashboardData['totalCandidates']) }}</h2>
                                    <h3 class="mb-0 fs-4 fw-light">{{ __('messages.admin_dashboard.total_candidates') }}
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a href="{{ route('company.index') }}" class=" text-decoration-none">
                            <div
                                class="bg-success shadow-md rounded-10  px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                                <div
                                    class="bg-green-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-user-shield fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white">
                                        {{ numberFormatShort($dashboardData['totalEmployers']) }}</h2>
                                    <h3 class="mb-0 fs-4 fw-light">{{ __('messages.admin_dashboard.total_employers') }}
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a href="{{ route('admin.jobs.index') }}" class=" text-decoration-none">
                            <div
                                class="bg-info shadow-md rounded-10  px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                                <div
                                    class="bg-blue-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-list-alt fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white">
                                        {{ numberFormatShort($dashboardData['totalActiveJobs']) }}</h2>
                                    <h3 class="mb-0 fs-4 fw-light">
                                        {{ __('messages.admin_dashboard.total_active_jobs') }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a href="{{ route('admin.jobs.index') }}" class=" text-decoration-none">
                            <div
                                class="bg-warning shadow-md rounded-10  px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                                <div
                                    class="bg-yellow-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-brands fa-foursquare fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white">
                                        {{ numberFormatShort($dashboardData['featuredJobs']) }}</h2>
                                    <h3 class="mb-0 fs-4 fw-light">{{ __('messages.admin_dashboard.featured_jobs') }}
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a href="{{ route('company.index') }}" class=" text-decoration-none">
                            <div
                                class="bg-secondary shadow-md rounded-10  px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                                <div
                                    class="bg-gray-600 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-user-tag fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white">
                                        {{ numberFormatShort($dashboardData['featuredEmployers']) }}</h2>
                                    <h3 class="mb-0 fs-4 fw-light">
                                        {{ __('messages.admin_dashboard.featured_employers') }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <div
                            class="bg-danger shadow-md rounded-10  px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                            <div
                                class="bg-red-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-money-check fs-1-xl text-white"></i>
                            </div>
                            <div class="text-end text-white">
                                <h2 class="fs-1-xxl fw-bolder text-white">
                                    {{ numberFormatShort($dashboardData['featuredJobsIncomes']) }}</h2>
                                <h3 class="mb-0 fs-4 fw-light">
                                    {{ __('messages.admin_dashboard.featured_jobs_incomes') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <div
                            class="bg-dark shadow-md rounded-10  px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                            <div
                                class="bg-gray-700 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-money-check-alt fs-1-xl text-light"></i>
                            </div>
                            <div class="text-end text-white">
                                <h2 class="fs-1-xxl fw-bolder text-light">
                                    {{ numberFormatShort($dashboardData['featuredCompanysIncomes']) }}</h2>
                                <h3 class="mb-0 fs-4 fw-light text-light">
                                    {{ __('messages.admin_dashboard.featured_employers_incomes') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-4 col-sm-6 widget">
                        <a href="{{ route('admin.transactions.index') }}" class=" text-decoration-none">
                            <div
                                class="bg-primary shadow-md rounded-10  px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                                <div
                                    class="bg-cyan-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-money-bill fs-1-xl text-white"></i>
                                </div>
                                <div class="text-end text-white">
                                    <h2 class="fs-1-xxl fw-bolder text-white">
                                        {{ numberFormatShort($dashboardData['subscriptionIncomes']) }}</h2>
                                    <h3 class="mb-0 fs-4 fw-light">
                                        {{ __('messages.admin_dashboard.subscription_incomes') }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
