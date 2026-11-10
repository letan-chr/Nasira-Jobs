<div class="content flex-column-fluid">
    <div class="container-fluid container-xxl">
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <div class="d-flex flex-wrap flex-sm-nowrap mb-3">
                    <div class="me-7 mb-4">
                        <div class="">
                            <img height="150" width="150" src="{{ getCompanyLogo() }}" alt="image"
                                style="object-fit: cover">
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column">
                                <div class="align-items-center mb-2">
                                    <a
                                        class="text-gray-900 text-hover-primary fs-2 me-1 text-decoration-none">{{ html_entity_decode($user->full_name) }}</a>
                                </div>
                                <div class=" flex-wrap fs-6 mb-4 pe-2">
                                    <a
                                        class="d-flex align-items-center text-gray-600 text-hover-primary {{ checkLanguageSession() == 'ar' ? 'ms-5' : 'me-5' }} mb-2 text-decoration-none">
                                        <i class="fa fa-phone"></i>&nbsp;
                                        {{ !empty($user->phone) ? $user->phone : __('messages.candidate_dashboard.no_not_available') }}
                                    </a>
                                    <a
                                        class="d-flex align-items-center text-gray-600 text-hover-primary {{ checkLanguageSession() == 'ar' ? 'ms-5' : 'me-5' }} mb-2 text-decoration-none">
                                        <i class="fa-solid fa-location-dot fs-3 {{ checkLanguageSession() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        {{ !empty($candidate->city_name) ? $candidate->city_name . ', ' . $candidate->state_name . ', ' . $candidate->country_name : (!empty($candidate->country_id) ? $candidate->country_name : __('messages.candidate_dashboard.location_information')) }}
                                    </a>
                                    <a
                                        class="d-flex align-items-center text-gray-600 text-hover-primary {{ checkLanguageSession() == 'ar' ? 'ms-5' : 'me-5' }} mb-2 text-decoration-none">
                                        <i class="fa-solid fa-envelope  {{ checkLanguageSession() == 'ar' ? 'ms-2' : 'me-2' }}"></i>
                                        {{ $user->email }}</a>
                                </div>
                            </div>
                            <div class="d-flex my-4">
                                <a href="{{ route('candidate.profile') }}" class="btn btn-sm btn-primary me-2">
                                    {{ __('messages.user.edit_profile') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-5 g-xl-8">
            <div class="col-xxl-4 col-xl-4 col-sm-6 widget">
                <div
                    class="bg-success shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                    <div
                        class="bg-green-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-eye text-white fs-1-xl"></i>
                    </div>
                    <div class="text-end text-white">
                        <h2 class="fs-1-xxl text-white {{ checkLanguageSession() == 'ar' ? 'text-start' : 'text-end' }}">{{ numberFormatShort($user->profile_views) }}</h2>
                        <h3 class="mb-0 fs-4 fw-light fs-1-xl">{{ __('messages.candidate_dashboard.profile_views') }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-sm-6 widget">
                <a href="{{ route('favourite.companies') }}" class=" text-decoration-none">
                    <div
                        class="bg-dark shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                        <div
                            class="bg-gray-700 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                            <i
                                class="fas fa-users  fs-1-xl {{ getLoggedInUser()->theme_mode ? 'text-muted' : 'text-white' }}"></i>
                        </div>
                        <div class="text-end text-light">
                            <h2 class="fs-1-xxl text-light {{ checkLanguageSession() == 'ar' ? 'text-start' : 'text-end' }}">{{ numberFormatShort($followings) }}</h2>
                            <h3 class="mb-0 fs-4 fw-light fs-1-xl">{{ __('messages.candidate_dashboard.followings') }}
                            </h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xxl-4 col-xl-4 col-sm-6 widget">
                <div
                    class="bg-warning shadow-md rounded-10 p-xxl-10 px-5 py-10 d-flex align-items-center justify-content-between my-sm-3 my-2">
                    <div
                        class="bg-yellow-300 widget-icon rounded-10 me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-briefcase fs-1-xl text-white"></i>
                    </div>
                    <div class="text-end text-white">
                        <h2 class="fs-1-xxl text-white {{ checkLanguageSession() == 'ar' ? 'text-start' : 'text-end' }}">{{ numberFormatShort($resumes) }}</h2>
                        <h3 class="mb-0 fs-4 fw-light">{{ __('messages.apply_job.resume') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
