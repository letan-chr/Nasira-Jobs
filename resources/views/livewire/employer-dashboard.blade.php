<div class="content flex-column-fluid">
    <div class="container-fluid container-xxl">
        <div class="row">
            <div class="col-xl-4 col-sm-6 widget">
                <a href="{{ route('job.index') }}" class=" text-decoration-none">
                    <div
                        class="bg-success shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                        <div
                            class="bg-green-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-briefcase text-white fs-1-xl fa-4x"></i>
                        </div>
                        <div class="text-end text-white">
                            <h2 class="fs-1-xxl fw-bolder text-white {{ checkLanguageSession() == 'ar' ? 'text-start' : 'text-end' }}">
                                {{ isset($data['totalJobs']) ? numberFormatShort($data['totalJobs']) : '0' }}
                            </h2>
                            <h3 class="mb-0 fs-4 fw-light">{{ __('messages.employer_menu.total_jobs') }}</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-sm-6 widget">
                <a href="{{ route('job.index') }}" class=" text-decoration-none">
                    <div
                        class="bg-primary shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                        <div
                            class="bg-cyan-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                            <i class="far fa-clock text-white fs-1-xl fa-4x"></i>
                        </div>
                        <div class="text-end text-white">
                            <h2 class="fs-1-xxl fw-bolder text-white {{ checkLanguageSession() == 'ar' ? 'text-start' : 'text-end' }}">
                                {{ isset($data['jobCount']) ? numberFormatShort($data['jobCount']) : '0' }}
                            </h2>
                            <h3 class="mb-0 fs-4 fw-light">{{ __('messages.employer_menu.live_jobs') }}</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-sm-6 widget">
                <a href="{{ route('job.index') }}" class=" text-decoration-none">
                    <div
                        class="bg-warning shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                        <div
                            class="bg-yellow-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-pause-circle text-white fs-1-xl fa-4x"></i>
                        </div>
                        <div class="text-end text-white">
                            <h2 class="fs-1-xxl fw-bolder text-white {{ checkLanguageSession() == 'ar' ? 'text-start' : 'text-end' }}">
                                {{ isset($data['pausedJobCount']) ? numberFormatShort($data['pausedJobCount']) : '0' }}</h2>
                            <h3 class="mb-0 fs-4 fw-light">{{ __('messages.employer_menu.paused_jobs') }}</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-sm-6 widget">
                <div
                    class="bg-danger shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                    <div
                        class="bg-red-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-window-close text-white fs-1-xl fa-4x"></i>
                    </div>
                    <div class="text-end text-white">
                        <h2 class="fs-1-xxl fw-bolder text-white {{ checkLanguageSession() == 'ar' ? 'text-start' : 'text-end' }}">
                            {{ isset($data['closedJobCount']) ? numberFormatShort($data['closedJobCount']) : '0' }}</h2>
                        <h3 class="mb-0 fs-4 fw-light">{{ __('messages.employer_menu.closed_jobs') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6 widget">
                <a href="{{ route('followers.index') }}" class=" text-decoration-none">
                    <div
                        class="bg-info shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                        <div
                            class="bg-blue-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                            <i class="far fa-user text-white fs-1-xl fa-4x"></i>
                        </div>
                        <div class="text-end text-white">
                            <h2 class="fs-1-xxl fw-bolder text-white {{ checkLanguageSession() == 'ar' ? 'text-start' : 'text-end' }}">
                                {{ isset($data['followersCount']) ? numberFormatShort($data['followersCount']) : '0' }}</h2>
                            <h3 class="mb-0 fs-4 fw-light">{{ __('messages.employer_menu.followers') }}</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-sm-6 widget">
                <div
                    class="bg-dark shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                    <div
                        class="bg-gray-700 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                        <i
                            class="fas fa-file fa-4x fs-1-xl {{ getLoggedInUser()->theme_mode ? 'text-muted' : 'text-white' }}"></i>
                    </div>
                    <div class="text-end {{ getLoggedInUser()->theme_mode ? 'text-muted' : 'text-white' }}">
                        <h2 class="fs-1-xxl fw-bolder text-light {{ checkLanguageSession() == 'ar' ? 'text-start' : 'text-end' }}">
                            {{ isset($data['jobApplicationsCount']) ? numberFormatShort($data['jobApplicationsCount']) : '0' }}</h2>
                        <h3 class="mb-0 fs-4 fw-light text-light">
                            {{ __('messages.employer_menu.total_job_applications') }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
