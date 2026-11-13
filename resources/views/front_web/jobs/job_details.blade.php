@extends('front_web.layouts.app')
@section('title')
    {{ html_entity_decode(Str::limit($job->job_title, 60, '...')) }}
@endsection
{{-- @section('page_css') --}}
{{--    <link href="{{asset('front_web/scss/job-details.css')}}" rel="stylesheet" type="text/css"> --}}
{{-- @endsection --}}
@section('content')
    <div class="job-details-page">
        <!-- start hero section -->
        <section class="hero-section position-relative bg-gradient pt-15 pb-40">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12">
                        <div class="d-flex align-items-md-center">
                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                <div class="hero-img">
                                    <img src="{{ $job->company->company_url }}"
                                        class="w-100 h-100 rounded-circle object-fit-cover" alt="company-details" />
                                </div>
                            </div>
                            <div class="">
                                <div class="hero-content">
                                    <h1 class="text-secondary lh-base mb-2 fs-4">
                                        {{ html_entity_decode(Str::limit($job->job_title, 80, '...')) }}
                                        @role('Candidate')
                                            @if (!$isJobApplicationRejected)
                                                <button class="btn p-0 ms-5"
                                                    data-favorite-user-id="{{ getLoggedInUserId() !== null ? getLoggedInUserId() : null }}"
                                                    data-favorite-job-id="{{ $job->id }}" id="addToFavourite">
                                                    <span id="favorite">
                                                        <i
                                                            class=" {{ $isJobAddedToFavourite ? 'fa-solid fa-bookmark featured' : 'fa-regular fa-bookmark' }}  text-primary fs-18"></i>
                                                    </span>
                                                </button>
                                            @endif
                                        @endrole
                                    </h1>
                                    <div class="hero-desc d-md-flex">
                                        <div class="desc d-flex {{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                <img src="{{ asset('img_template/briefcase.svg') }}" class="w-100" />
                                            </div>
                                            <p class="fs-14 text-gray mb-0">
                                                {{ html_entity_decode($job->jobCategory->name) }}
                                            </p>
                                        </div>
                                        <div class="desc d-flex {{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                <img src="{{ asset('img_template/clock.svg') }}" class="w-100" />
                                            </div>
                                            <p class="fs-14 text-gray mb-0">{{ $job->created_at->diffForHumans() }}</p>
                                        </div>
                                        @if ($job->hide_salary == '0')
                                            <div class="desc d-flex {{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                                <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                    <img src="{{ asset('img_template/money.svg') }}" class="w-100" />
                                                </div>
                                                <a href="#"
                                                    class="fs-14 text-gray">{{ $job->currency->currency_icon }}
                                                    {{ numberFormatShort($job->salary_from) . ' - ' . numberFormatShort($job->salary_to) }}</a>
                                            </div>
                                        @endif
                                    </div>
                                    @if (count($job->jobsTag) > 0)
                                        {{-- <div class="hero-desc d-md-flex flex-wrap">
                                            @foreach ($job->jobsTag->pluck('name') as $value)
                                                <div class="desc d-flex {{ $loop->last ? '' : 'me-2 pe-2' }}">
                                                    <span class="tag-badge"
                                                        style="background: rgba(25,103,210,.15);color: #1967d2!important;font-size: 12px!important;line-height: 15px;padding: 5px 20px;border-radius: 50px;margin-top: 10px;">
                                                        {{ $value }}</span>
                                                </div>
                                            @endforeach
                                        </div> --}}
                                        <div class="hero-desc d-flex flex-wrap">
                                            @foreach ($job->jobsTag->pluck('name') as $value)
                                            <div class="desc d-flex {{ $loop->last ? '' : 'me-2 pe-2' }}">
                                                <span class="tag-badge"
                                                    style="background: rgba(25,103,210,.15);color: #1967d2!important;font-size: 12px!important;line-height: 15px;padding: 5px 20px;border-radius: 50px;margin-top: 10px;">
                                                    {{ $value }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-3 mt-sm-5 mt-4 flex-wrap">
                    {{-- <button class="btn btn-light">Register to Apply</button>
                    <button class="btn btn-primary">Apply for Job</button> --}}
                    <div class="row align-items-lg-center">
                        @auth
                            @role('Candidate')
                                <div class="hero-desc d-flex flex-wrap">
                                    <div class="desc me-2 pe-2 mb-sm-0 mb-2">
                                        <button type="button" class="btn btn-primary  emailJobToFriend" data-bs-toggle="modal"
                                            data-bs-target="#emailJobToFriendModal">
                                            {{ __('web.job_details.email_to_friend') }}
                                        </button>
                                    </div>
                                    <div class="desc me-2 pe-2 mb-sm-0 mb-2">
                                        @if ($isJobReportedAsAbuse)
                                            <button type="button" class="btn btn-primary  reportJobAbuse" disabled
                                                data-bs-toggle="modal" data-bs-target="#reportJobAbuseModal">
                                                {{ __('messages.candidate.already_reported') }}
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-primary  reportJobAbuse" data-bs-toggle="modal"
                                                data-bs-target="#reportJobAbuseModal">
                                                {{ __('web.job_details.report_abuse') }}
                                            </button>
                                        @endif
                                    </div>
                                    <div class="desc me-2 pe-2 mb-sm-0 mb-2">
                                        @php
                                            $jobOpen = $isActive && !$job->is_suspended && (empty($job->job_expiry_date) || \Carbon\Carbon::today()->lte($job->job_expiry_date));
                                            $externalApply = !empty($job->apply_url);
                                        @endphp
                                        @if ($jobOpen && $externalApply)
                                            <a class="btn btn-dark" href="{{ $job->apply_url }}" target="_blank" rel="noopener noreferrer">
                                                {{ __('web.job_details.apply_for_job') }}
                                            </a>
                                        @elseif (!$isApplied && !$isJobApplicationRejected && !$isJobApplicationCompleted && !$isJobApplicationShortlisted)
                                            @if ($jobOpen)
                                                <button class="btn {{ $isJobDrafted ? 'btn-primary ' : 'btn-dark' }} "
                                                    onclick="window.location='{{ route('show.apply-job-form', $job->job_id) }}'">
                                                    {{ $isJobDrafted ? __('web.job_details.edit_draft') : __('web.job_details.apply_for_job') }}
                                                </button>
                                            @endif
                                        @else
                                            <button
                                                class="btn btn-primary  ml-2">{{ __('web.job_details.already_applied') }}</button>
                                        @endif
                                    </div>
                                </div>
                            @endrole
                        @else
                            @php
                                $jobOpenGuest = $isActive && !$job->is_suspended && (empty($job->job_expiry_date) || \Carbon\Carbon::today()->lte($job->job_expiry_date));
                            @endphp
                            @if ($jobOpenGuest)
                                <div class="hero-desc d-flex flex-wrap">
                                    @if (!empty($job->apply_url))
                                        <div class="desc d-flex me-4 pe-2">
                                            <a class="btn btn-dark mb-3" href="{{ $job->apply_url }}" target="_blank" rel="noopener noreferrer">
                                                {{ __('web.job_details.apply_for_job') }}
                                            </a>
                                        </div>
                                    @else
                                        <div class="desc d-flex me-4 pe-2">
                                            <button class="btn btn-primary  mb-3"
                                                onclick="window.location='{{ route('candidate.register') }}'">{{ __('web.job_details.register_to_apply') }}
                                            </button>
                                        </div>
                                        <div class="desc d-flex me-4 pe-2">
                                            <button class="btn btn-primary  mb-3"
                                                onclick="window.location='{{ route('front.candidate.login') }}'">
                                                {{ __('web.job_details.apply_for_job') }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </section>
        <!-- end hero section -->

        <!-- start job-details section -->
        <section class="job-details-section py-60 mb-sm-4">
            <div class="container">
                <div class="job-card">
                    <div class="row">
                        @if ($job->is_suspended || !$isActive)
                            <div class="col-md-12 col-sm-12">
                                <div class="alert alert-warning text-warning bg-transparent" role="alert">
                                    {{ __('web.job_details.job_is') }}
                                    @php
                                        $status = \App\Models\Job::STATUS[$job->status];
                                    @endphp
                                    <strong> {{ getTranslatedData($status)[0] }}.</strong>
                                </div>
                            </div>
                        @endif
                        @if (Session::has('warning'))
                            <div class="col-md-12 col-sm-12">
                                <div class="alert alert-warning" role="alert">
                                    {{ Session::get('warning') }}
                                    <a href="{{ route('candidate.profile', ['section' => 'resume']) }}"
                                        class="alert-link ml-2 ">{{ __('web.job_details.click_here') }}</a>
                                    {{ __('web.job_details.to_upload_resume') }}
                                    .
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-8">
                            <div class="Job Description mb-lg-5 mb-4">
                                <h5 class="fs-18 text-secondary mb-4">@lang('web.web_jobs.job_description')</h5>
                                @if ($job->description)
                                    <p class="job-description">
                                        {!! nl2br(e($job->description)) !!}
                                    </p>
                                @else
                                    <p class="fs-16 text-gray mb-5 pb-lg-4">{{ __('messages.n/a') }}</p>
                                @endif
                            </div>
                            @if ($job->roles && $job->roles->count())
                                <div class="job-roles mb-lg-5 mb-4">
                                    <h5 class="fs-18 text-secondary mb-4">Open Positions</h5>
                                    @foreach ($job->roles as $i => $role)
                                        <div class="mb-4 p-3 border rounded">
                                            <h6 class="fw-bold text-secondary mb-2">✅ Position {{ $i + 1 }}: {{ $role->title }}</h6>
                                            @if ($role->requirements)
                                                <div class="text-gray">
                                                    <strong>Qualifications &amp; Requirements:</strong>
                                                    <div class="mt-1">{!! nl2br(e($role->requirements)) !!}</div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="key-responsibilities mb-lg-5 mb-4">
                                <h5 class="fs-18 text-secondary mb-4">@lang('web.web_jobs.key_responsibilities')</h5>
                                @if ($job->key_responsibilities)
                                    <div class="key-responsibilities">
                                        {!! nl2br(e($job->key_responsibilities)) !!}
                                    </div>
                                @else
                                    <p class="fs-16 text-gray mb-5 pb-lg-4">{{ __('messages.n/a') }}</p>
                                @endif

                            </div>
                            <div class="skill-experience mb-lg-5 mb-4">
                                <h5 class="fs-18 text-secondary mb-4">@lang('web.web_jobs.Skill_Experience')</h5>
                                @if (!empty($skills))
                                <ul>
                                    @foreach ($skills as $id => $skill)
                                    <li>{{ $skill }}</li>
                                    @endforeach
                                </ul>
                                @else
                                    <p class="fs-16 text-gray mb-5 pb-lg-4">{{ __('messages.n/a') }}</p>
                                @endif
                            </div>
                            <div class="share-this-job mb-lg-0 mb-40">
                                <h5 class="fs-18 text-secondary mb-4">@lang('web.apply_for_job.share_this_job'):</h5>
                                <div class="icon-box d-flex">
                                    <a href="{{ $url['facebook'] }}" target="_blank" class="facebook d-flex"
                                        title="@lang('web.web_jobs.facebook')">
                                    <div class="social-icon me-sm-4 me-3 d-flex align-items-center justify-content-center">
                                            <div class="icon d-flex">
                                                <i class="fa-brands fa-facebook-f text-white"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="https://www.linkedin.com/shareArticle/?url={{ rawurlencode(URL::to('/job-details/' . $job->job_id)) }}"
                                        title="@lang('web.web_jobs.linkedin')" target="_blank" class="linkedin d-flex">
                                    <div class="social-icon me-sm-4 me-3 d-flex align-items-center justify-content-center">
                                            <div class="icon d-flex">
                                                <i class="fa-brands fa-linkedin-in text-white"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="{{ $url['twitter'] }}" target="_blank" class="twitter d-flex"
                                        title="@lang('web.web_jobs.twitter')">
                                    <div class="social-icon me-sm-4 me-3 d-flex align-items-center justify-content-center">
                                            <div class="icon d-flex">
                                                <i class="fa-brands fa-twitter text-white"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="{{ $url['gmail'] }}" target="_blank" class="google d-flex"
                                        title="@lang('web.web_jobs.google')">
                                    <div class="social-icon me-sm-4 me-3 d-flex align-items-center justify-content-center">
                                            <div class="icon d-flex">
                                                <i class="fa-brands fa-google-plus-g text-white"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="{{ $url['pinterest'] }}" target="_blank" class="pinterest d-flex"
                                        title="@lang('web.web_jobs.pinterest')">
                                    <div class="social-icon me-sm-4 me-3 d-flex align-items-center justify-content-center">
                                            <div class="icon d-flex">
                                                <i class="fa-brands fa-pinterest-p text-white"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="job-desc-right br-10 px-40 bg-light mb-40">
                                <div class="pb-2">
                                    <h5 class="fs-18 text-dark mb-4">@lang('web.web_jobs.job_overview')</h5>
                                    <div class="desc-box d-flex justify-content-between mb-4">
                                        <div class="desc d-flex">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-2' : 'me-2' }} w-20">
                                                <svg width="18" height="20" viewBox="0 0 18 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5 12C4.71667 12 4.479 11.904 4.287 11.712C4.09567 11.5207 4 11.2833 4 11C4 10.7167 4.09567 10.479 4.287 10.287C4.479 10.0957 4.71667 10 5 10C5.28333 10 5.521 10.0957 5.713 10.287C5.90433 10.479 6 10.7167 6 11C6 11.2833 5.90433 11.5207 5.713 11.712C5.521 11.904 5.28333 12 5 12ZM9 12C8.71667 12 8.47933 11.904 8.288 11.712C8.096 11.5207 8 11.2833 8 11C8 10.7167 8.096 10.479 8.288 10.287C8.47933 10.0957 8.71667 10 9 10C9.28333 10 9.521 10.0957 9.713 10.287C9.90433 10.479 10 10.7167 10 11C10 11.2833 9.90433 11.5207 9.713 11.712C9.521 11.904 9.28333 12 9 12ZM13 12C12.7167 12 12.4793 11.904 12.288 11.712C12.096 11.5207 12 11.2833 12 11C12 10.7167 12.096 10.479 12.288 10.287C12.4793 10.0957 12.7167 10 13 10C13.2833 10 13.5207 10.0957 13.712 10.287C13.904 10.479 14 10.7167 14 11C14 11.2833 13.904 11.5207 13.712 11.712C13.5207 11.904 13.2833 12 13 12ZM2 20C1.45 20 0.979 19.8043 0.587 19.413C0.195667 19.021 0 18.55 0 18V4C0 3.45 0.195667 2.97933 0.587 2.588C0.979 2.196 1.45 2 2 2H3V0H5V2H13V0H15V2H16C16.55 2 17.021 2.196 17.413 2.588C17.8043 2.97933 18 3.45 18 4V18C18 18.55 17.8043 19.021 17.413 19.413C17.021 19.8043 16.55 20 16 20H2ZM2 18H16V8H2V18Z"
                                                        fill="#1967D2" />
                                                </svg>
                                            </div>

                                            <p class="fs-14 text-secondary mb-0">@lang('web.job_details.date_posted'):</p>
                                        </div>
                                        <p class="fs-14 text-gray text-end mb-0">
                                            {{ \Carbon\Carbon::parse($job->created_at)->translatedFormat('jS M, Y') }}</p>
                                    </div>
                                    <div class="desc-box d-flex justify-content-between mb-4">
                                        <div class="desc d-flex">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-2' : 'me-2' }} w-20">
                                                <svg width="20" height="19" viewBox="0 0 20 19" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M19.9996 5.60686C19.9996 9.51758 19.9996 13.4283 19.9996 17.339C19.4996 18.6604 18.9906 18.9997 17.571 18.9997C16.1156 18.9997 14.6692 18.9997 13.2139 18.9997C9.52636 18.9997 5.83886 18.9997 2.15136 18.9997C0.821002 18.9997 -0.000426277 18.1783 -0.000426277 16.839C-0.000426277 13.2676 -0.00935485 9.70508 -0.000426277 6.13365C-0.000426277 4.83008 0.83886 4.00865 2.15136 4.00865C3.27636 4.00865 4.40136 4.00865 5.52636 4.00865C5.67815 4.00865 5.83886 4.00865 6.01743 4.00865C6.01743 3.32115 6.01743 2.69615 6.01743 2.08008C6.02636 0.847935 6.82993 0.0265067 8.07993 0.00864955C9.35672 -0.000279018 10.6246 -0.000279018 11.9014 0.00864955C13.1692 0.0175781 13.9728 0.839007 13.9817 2.09794C13.9817 2.71401 13.9817 3.33901 13.9817 3.99972C15.0621 3.99972 16.0889 3.99972 17.1246 3.99972C17.5085 3.99972 17.9014 3.97294 18.2764 4.02651C19.196 4.16044 19.7049 4.77651 19.9996 5.60686ZM4.99957 13.0801C4.99957 12.4015 4.99957 11.7765 4.99957 11.1336C3.98172 11.1336 3.0085 11.1336 2.0085 11.1336C2.0085 13.089 2.0085 15.0176 2.0085 16.964C7.34779 16.964 12.6692 16.964 17.9817 16.964C17.9817 14.9908 17.9817 13.0622 17.9817 11.1336C16.9728 11.1336 15.9996 11.1336 14.9817 11.1336C14.9817 11.7854 14.9817 12.4194 14.9817 13.0622C14.3031 13.0622 13.6781 13.0622 12.9996 13.0622C12.9996 12.4015 12.9996 11.7765 12.9996 11.1336C10.9728 11.1336 8.99957 11.1336 6.97279 11.1336C6.97279 11.7944 6.97279 12.4194 6.97279 13.0711C6.31207 13.0801 5.696 13.0801 4.99957 13.0801ZM18.0174 9.07115C18.0174 8.16936 17.9906 7.33008 18.0264 6.49079C18.0442 6.07115 17.9014 5.98186 17.4996 5.98186C12.4996 5.99079 7.49957 5.98186 2.49065 5.98186C2.40136 5.98186 2.29422 5.95508 2.23172 5.99079C2.1335 6.04436 1.99065 6.13365 1.99065 6.21401C1.97279 7.16044 1.98172 8.09794 1.98172 9.06222C7.34779 9.07115 12.6603 9.07115 18.0174 9.07115ZM8.01743 3.97294C9.36565 3.97294 10.6692 3.97294 11.9728 3.97294C11.9728 3.30329 11.9728 2.66044 11.9728 2.01758C10.6335 2.01758 9.32993 2.01758 8.01743 2.01758C8.01743 2.68722 8.01743 3.31222 8.01743 3.97294Z"
                                                        fill="#1967D2" />
                                                </svg>
                                            </div>
                                            <p class="fs-14 text-secondary mb-0">@lang('web.web_jobs.expiration_date'):</p>
                                        </div>
                                        <p class="fs-14 text-gray text-end mb-0">
                                            {{ \Carbon\Carbon::parse($job->job_expiry_date)->translatedFormat('jS M, Y') }}
                                        </p>
                                    </div>
                                    <div class="desc-box d-flex justify-content-between mb-4">
                                        <div class="desc d-flex">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-2' : 'me-2' }} w-20">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1043_494)">
                                                        <path
                                                            d="M10.4689 0C10.8699 0.0782473 11.2762 0.130412 11.6668 0.245175C14.0053 0.912885 15.7241 2.99426 15.9741 5.39384C16.0626 6.27543 15.8803 7.09964 15.5731 7.90819C14.9845 9.45749 14.1564 10.8868 13.2814 12.29C12.3022 13.855 11.2397 15.3678 10.1199 16.8388C10.0835 16.8858 10.047 16.9275 9.99493 16.9901C9.69805 16.5936 9.40639 16.2128 9.12514 15.8216C7.69805 13.8498 6.32305 11.8414 5.22409 9.66615C4.85951 8.94105 4.5418 8.18988 4.27097 7.42827C3.77097 6.02504 3.96889 4.64789 4.63555 3.34898C5.63555 1.40323 7.24493 0.29734 9.42722 0.0312989C9.46368 0.0260824 9.50014 0.010433 9.53659 0C9.84389 0 10.1564 0 10.4689 0ZM8.00534 5.98331C8.00014 7.08399 8.88555 7.98644 9.98451 8.00209C11.0783 8.01252 11.9897 7.11007 11.9949 6.01461C12.0001 4.91393 11.1199 4.01669 10.0158 4.00104C8.92722 3.98018 8.01055 4.88785 8.00534 5.98331Z"
                                                            fill="#1967D2" />
                                                        <path
                                                            d="M0 14.6845C0.0885417 14.3923 0.151042 14.0898 0.270833 13.8133C0.588542 13.083 1.14583 12.5457 1.77604 12.0814C2.36458 11.6432 3.00521 11.3042 3.68229 11.0068C4.01042 11.6067 4.33854 12.2014 4.66667 12.7961C4.34375 12.9526 3.99479 13.0882 3.68229 13.2812C3.25521 13.542 2.82292 13.8081 2.45833 14.1419C1.82812 14.7158 1.84896 15.2687 2.45833 15.8634C3.04167 16.432 3.76042 16.7815 4.51042 17.0736C5.94792 17.6266 7.45312 17.8822 8.98438 17.9708C10.7344 18.07 12.4688 17.9343 14.1719 17.4961C15.1979 17.2301 16.1875 16.8806 17.0573 16.2546C17.3385 16.0512 17.5885 15.7956 17.8073 15.5243C18.0781 15.1905 18.0781 14.794 17.8021 14.4654C17.5729 14.1889 17.3073 13.9176 17.0052 13.7298C16.474 13.4064 15.9062 13.1508 15.349 12.8639C15.6562 12.311 15.9792 11.7163 16.3229 11.0955C17.974 11.8623 19.5781 12.6605 20 14.6897C20 14.9088 20 15.1331 20 15.3522C19.9688 15.4878 19.9375 15.6286 19.901 15.7643C19.6562 16.6719 19.0677 17.324 18.3281 17.8613C17.2969 18.6125 16.1302 19.0611 14.9062 19.3689C12.1979 20.0574 9.45833 20.1826 6.69792 19.7549C5.25521 19.5306 3.86458 19.1341 2.57812 18.4299C1.75 17.9761 1.00521 17.4127 0.484375 16.5989C0.229167 16.2025 0.09375 15.7695 0 15.3157C0 15.0966 0 14.8879 0 14.6845Z"
                                                            fill="#1967D2" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1043_494">
                                                            <rect width="20" height="20" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <p class="fs-14 text-secondary mb-0">@lang('web.common.location'):</p>
                                        </div>
                                        <p class="fs-14 text-gray text-end mb-0">
                                            @if (!empty($job->city_id))
                                                {{ $job->city_name }} ,
                                            @endif
                                            @if (!empty($job->state_id))
                                                {{ $job->state_name }},
                                            @endif
                                            @if (!empty($job->country_id))
                                                {{ $job->country_name }}
                                            @endif
                                            @if (empty($job->country_id))
                                                {{ __('web.job_details.location_information_not_available') }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="desc-box d-flex justify-content-between mb-4">
                                        <div class="desc d-flex">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-2' : 'me-2' }} w-20">
                                                <svg width="20" height="19" viewBox="0 0 20 19" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M19.9996 5.60686C19.9996 9.51758 19.9996 13.4283 19.9996 17.339C19.4996 18.6604 18.9906 18.9997 17.571 18.9997C16.1156 18.9997 14.6692 18.9997 13.2139 18.9997C9.52636 18.9997 5.83886 18.9997 2.15136 18.9997C0.821002 18.9997 -0.000426277 18.1783 -0.000426277 16.839C-0.000426277 13.2676 -0.00935485 9.70508 -0.000426277 6.13365C-0.000426277 4.83008 0.83886 4.00865 2.15136 4.00865C3.27636 4.00865 4.40136 4.00865 5.52636 4.00865C5.67815 4.00865 5.83886 4.00865 6.01743 4.00865C6.01743 3.32115 6.01743 2.69615 6.01743 2.08008C6.02636 0.847935 6.82993 0.0265067 8.07993 0.00864955C9.35672 -0.000279018 10.6246 -0.000279018 11.9014 0.00864955C13.1692 0.0175781 13.9728 0.839007 13.9817 2.09794C13.9817 2.71401 13.9817 3.33901 13.9817 3.99972C15.0621 3.99972 16.0889 3.99972 17.1246 3.99972C17.5085 3.99972 17.9014 3.97294 18.2764 4.02651C19.196 4.16044 19.7049 4.77651 19.9996 5.60686ZM4.99957 13.0801C4.99957 12.4015 4.99957 11.7765 4.99957 11.1336C3.98172 11.1336 3.0085 11.1336 2.0085 11.1336C2.0085 13.089 2.0085 15.0176 2.0085 16.964C7.34779 16.964 12.6692 16.964 17.9817 16.964C17.9817 14.9908 17.9817 13.0622 17.9817 11.1336C16.9728 11.1336 15.9996 11.1336 14.9817 11.1336C14.9817 11.7854 14.9817 12.4194 14.9817 13.0622C14.3031 13.0622 13.6781 13.0622 12.9996 13.0622C12.9996 12.4015 12.9996 11.7765 12.9996 11.1336C10.9728 11.1336 8.99957 11.1336 6.97279 11.1336C6.97279 11.7944 6.97279 12.4194 6.97279 13.0711C6.31207 13.0801 5.696 13.0801 4.99957 13.0801ZM18.0174 9.07115C18.0174 8.16936 17.9906 7.33008 18.0264 6.49079C18.0442 6.07115 17.9014 5.98186 17.4996 5.98186C12.4996 5.99079 7.49957 5.98186 2.49065 5.98186C2.40136 5.98186 2.29422 5.95508 2.23172 5.99079C2.1335 6.04436 1.99065 6.13365 1.99065 6.21401C1.97279 7.16044 1.98172 8.09794 1.98172 9.06222C7.34779 9.07115 12.6603 9.07115 18.0174 9.07115ZM8.01743 3.97294C9.36565 3.97294 10.6692 3.97294 11.9728 3.97294C11.9728 3.30329 11.9728 2.66044 11.9728 2.01758C10.6335 2.01758 9.32993 2.01758 8.01743 2.01758C8.01743 2.68722 8.01743 3.31222 8.01743 3.97294Z"
                                                        fill="#1967D2" />
                                                </svg>
                                            </div>
                                            <p class="fs-14 text-secondary mb-0">@lang('messages.job.job_type'):</p>
                                        </div>
                                        <p class="fs-14 text-gray text-end mb-0">
                                            {{ $job->jobType ? html_entity_decode($job->jobType->name) : __('messages.n/a') }}
                                        </p>
                                    </div>
                                    @if ($job->jobShift)
                                        <div class="desc-box d-flex justify-content-between mb-4">
                                            <div class="desc d-flex">
                                                <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-2' : 'me-2' }} w-20">
                                                    <svg width="22" height="22" viewBox="0 0 22 22"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="11" cy="11" r="10" stroke="#1967D2"
                                                            stroke-width="2" fill="white" />
                                                        <line x1="11" y1="11" x2="11"
                                                            y2="7" stroke="#1967D2" stroke-width="1.5" />
                                                        <line x1="11" y1="11" x2="15"
                                                            y2="11" stroke="#1967D2" stroke-width="1.5" />
                                                        <circle cx="11" cy="11" r="1.5" fill="#1967D2" />
                                                    </svg>
                                                </div>
                                                <p class="fs-14 text-secondary mb-0">@lang('messages.job.job_shift'):</p>
                                            </div>
                                            <p class="fs-14 text-gray text-end mb-0">
                                                {{ html_entity_decode($job->jobShift->shift) }}</p>
                                        </div>
                                    @endif
                                    <div class="desc-box d-flex justify-content-between mb-4">
                                        <div class="desc d-flex">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-2' : 'me-2' }} w-20">
                                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M15.9973 17.0017C15.7258 16.7299 15.4875 16.4859 15.2437 16.2418C11.4088 19.5308 5.83385 18.6878 2.95216 15.1159C0.125896 11.6051 0.397439 6.58016 3.57838 3.49086C6.81473 0.351651 11.8355 0.163077 15.2049 3.01943C18.7405 6.01444 19.4387 11.4609 16.2412 15.238C16.4905 15.4875 16.7344 15.7371 17.0059 16.0089C17.1278 15.8758 17.2664 15.7149 17.4215 15.5652C17.7042 15.2879 18.0865 15.2823 18.3692 15.5596C19.073 16.2529 19.7823 16.9407 20.4584 17.6672C21.007 18.2551 21.1567 18.9706 20.8352 19.7249C20.5083 20.4959 19.9042 20.934 19.0619 20.995C18.5465 21.0338 18.0644 20.8564 17.6931 20.5014C16.956 19.797 16.2412 19.076 15.5318 18.3494C15.2824 18.0943 15.2935 17.7116 15.5374 17.4454C15.6815 17.2901 15.8477 17.1459 15.9973 17.0017ZM16.956 9.64727C16.956 5.59846 13.6754 2.32059 9.63546 2.32059C5.59556 2.32614 2.32041 5.60955 2.32595 9.65282C2.33149 13.6905 5.59001 16.9573 9.63546 16.9684C13.6643 16.985 16.9616 13.6905 16.956 9.64727ZM16.9782 17.9168C17.4991 18.4437 18.0201 18.9706 18.5465 19.492C18.6906 19.6362 18.8679 19.7027 19.0785 19.6584C19.3501 19.5974 19.5329 19.431 19.6271 19.1703C19.7214 18.9096 19.6271 18.6933 19.4443 18.5103C19.0176 18.0832 18.5908 17.6561 18.1697 17.2291C18.0865 17.1403 18.009 17.0461 17.9369 16.9629C17.5933 17.3012 17.2885 17.6007 16.9782 17.9168Z"
                                                        fill="#1967D2" stroke="#1967D2" stroke-width="0.4" />
                                                    <path
                                                        d="M11.9632 7.64459C11.6529 7.64459 11.337 7.64459 11.0211 7.64459C10.5833 7.63905 10.2896 7.36728 10.2952 6.96794C10.3007 6.5797 10.5944 6.31348 11.0267 6.31348C11.869 6.31348 12.7114 6.31348 13.5592 6.31348C14.0303 6.31348 14.3018 6.57415 14.3074 7.04004C14.3129 7.89972 14.3129 8.75385 14.3074 9.61353C14.3074 9.95186 14.1356 10.1959 13.8585 10.2902C13.5925 10.3789 13.2877 10.3124 13.1381 10.0794C13.0494 9.94631 12.9995 9.76328 12.9884 9.60244C12.9663 9.2863 12.9829 8.97016 12.9829 8.65402C12.9552 8.63183 12.9219 8.60965 12.8942 8.58746C12.861 8.65402 12.8388 8.73721 12.7889 8.78713C11.9355 9.64681 11.0821 10.5009 10.2231 11.3551C9.83522 11.7433 9.48609 11.7378 9.09817 11.3495C8.85988 11.111 8.62158 10.8725 8.37775 10.6285C8.36667 10.6174 8.35558 10.6119 8.30571 10.5786C8.16162 10.7339 8.01754 10.9003 7.86791 11.0611C7.29158 11.6379 6.72078 12.2203 6.1389 12.7916C5.79532 13.1299 5.30765 13.0522 5.0749 12.6307C4.92527 12.3534 4.9696 12.0816 5.22452 11.8265C5.88398 11.1665 6.54345 10.5065 7.20291 9.84648C7.41904 9.63017 7.62962 9.41386 7.85129 9.2031C8.15054 8.9147 8.53292 8.92024 8.83217 9.20865C9.10925 9.48042 9.3808 9.75219 9.64126 10.0073C10.3894 9.2142 11.1708 8.43771 11.9632 7.64459Z"
                                                        fill="#1967D2" stroke="#1967D2" stroke-width="0.4" />
                                                </svg>
                                            </div>
                                            <p class="fs-14 text-secondary mb-0">@lang('messages.job.functional_area'):</p>
                                        </div>
                                        <p class="fs-14 text-gray text-end mb-0">
                                            {{ html_entity_decode($job->functionalArea->name) }}
                                        </p>
                                    </div>
                                    <div class="desc-box d-flex justify-content-between mb-4">
                                        <div class="desc d-flex">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-2' : 'me-2' }} w-20">
                                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12.2471 21C11.9919 20.875 11.716 20.7865 11.4921 20.6198C11.164 20.375 11.0026 20.0104 11.0026 19.599C10.9922 18.3073 10.9922 17.0104 11.0026 15.7135C11.0078 14.9531 11.6743 14.3437 12.4866 14.3281C12.8146 14.3229 13.1479 14.3281 13.502 14.3281C13.502 14.1198 13.502 13.9271 13.502 13.7292C13.5124 12.8802 14.1372 12.25 14.9859 12.2448C15.6628 12.2396 16.3398 12.2396 17.0167 12.2448C17.8654 12.25 18.4954 12.875 18.5007 13.724C18.5007 13.9167 18.5007 14.1094 18.5007 14.3229C18.7506 14.3229 18.9849 14.3229 19.2192 14.3229C20.2762 14.3229 20.6511 14.5833 21 15.5625C21 16.9583 21 18.349 21 19.7448C20.8959 19.974 20.823 20.2188 20.6876 20.4219C20.4741 20.7552 20.1252 20.901 19.7503 20.9948C17.2458 21 14.7464 21 12.2471 21ZM19.7347 16.7917C19.6462 16.8281 19.5785 16.8594 19.5108 16.8906C18.4746 17.3854 17.4332 17.875 16.4022 18.375C16.1263 18.5104 15.8815 18.5156 15.6056 18.375C14.7516 17.9531 13.8873 17.5469 13.0229 17.1406C12.773 17.0208 12.523 16.9062 12.2523 16.776C12.2523 17.6771 12.2523 18.5469 12.2523 19.4219C12.2523 19.6875 12.3096 19.7448 12.5699 19.7448C14.861 19.7448 17.1468 19.7448 19.4379 19.7448C19.6878 19.7448 19.7503 19.6875 19.7503 19.4375C19.7503 18.6094 19.7503 17.7865 19.7503 16.9583C19.7451 16.9167 19.7399 16.8646 19.7347 16.7917ZM19.3181 15.599C17.0844 15.599 14.9078 15.599 12.6793 15.599C12.7626 15.6406 12.7886 15.6562 12.8146 15.6667C13.83 16.151 14.8401 16.6354 15.8607 17.1146C15.9388 17.151 16.0638 17.1458 16.1419 17.1094C17.1 16.6615 18.0581 16.2031 19.0109 15.75C19.0995 15.7031 19.1828 15.6615 19.3181 15.599ZM17.2458 14.3177C17.2458 14.1042 17.251 13.9062 17.2458 13.7083C17.2406 13.5781 17.1625 13.5052 17.0323 13.5C16.345 13.4948 15.6524 13.4948 14.9651 13.5C14.8349 13.5 14.7568 13.5781 14.7516 13.7083C14.7464 13.9062 14.7516 14.1094 14.7516 14.3177C15.5795 14.3177 16.397 14.3177 17.2458 14.3177Z"
                                                        fill="#1967D2" />
                                                    <path
                                                        d="M1 14.5573C1.05207 14.3229 1.09373 14.0885 1.15621 13.8594C1.63004 12.2031 3.1661 11.0156 4.88961 11.0052C7.25879 10.9948 9.62796 11 11.9971 11C12.3825 11 12.6584 11.2656 12.6636 11.6146C12.6688 11.974 12.3825 12.2448 11.9919 12.2448C9.68003 12.2448 7.37334 12.2448 5.06144 12.2448C3.41604 12.2448 2.24967 13.4167 2.24967 15.0625C2.24967 15.7188 2.24967 16.375 2.24967 17.0365C2.24967 17.099 2.24967 17.1615 2.24967 17.2448C2.3434 17.2448 2.4215 17.2448 2.4944 17.2448C4.54595 17.2448 6.59229 17.2448 8.64384 17.2448C9.04478 17.2448 9.32075 17.5 9.32596 17.8646C9.33116 18.2031 9.07602 18.474 8.73757 18.4948C8.65426 18.5 8.57094 18.4948 8.48243 18.4948C6.25905 18.4948 4.03046 18.4896 1.80708 18.5C1.42177 18.5 1.15621 18.3802 1 18.026C1 16.875 1 15.7135 1 14.5573Z"
                                                        fill="#1967D2" />
                                                    <path
                                                        d="M8.88857 1C9.24785 1.08854 9.61755 1.14583 9.96121 1.27083C11.7576 1.94271 12.8146 3.67188 12.6376 5.64062C12.4762 7.41146 11.0338 8.94792 9.21661 9.27083C6.55584 9.75 4.11898 7.53125 4.34809 4.84375C4.51471 2.84375 5.99349 1.30729 7.99818 1.03646C8.03463 1.03125 8.07108 1.01562 8.10752 1.00521C8.36787 1 8.62822 1 8.88857 1ZM8.49805 8.07812C10.107 8.07812 11.4192 6.76562 11.414 5.16146C11.4087 3.5625 10.1018 2.25521 8.50325 2.25C6.89951 2.24479 5.58214 3.55208 5.58214 5.16146C5.57693 6.76562 6.88909 8.07812 8.49805 8.07812Z"
                                                        fill="#1967D2" />
                                                    <path
                                                        d="M12.2471 21C11.9919 20.875 11.716 20.7865 11.4921 20.6198C11.164 20.375 11.0026 20.0104 11.0026 19.599C10.9922 18.3073 10.9922 17.0104 11.0026 15.7135C11.0078 14.9531 11.6743 14.3437 12.4866 14.3281C12.8146 14.3229 13.1479 14.3281 13.502 14.3281C13.502 14.1198 13.502 13.9271 13.502 13.7292C13.5124 12.8802 14.1372 12.25 14.9859 12.2448C15.6628 12.2396 16.3398 12.2396 17.0167 12.2448C17.8654 12.25 18.4954 12.875 18.5007 13.724C18.5007 13.9167 18.5007 14.1094 18.5007 14.3229C18.7506 14.3229 18.9849 14.3229 19.2192 14.3229C20.2762 14.3229 20.6511 14.5833 21 15.5625C21 16.9583 21 18.349 21 19.7448C20.8959 19.974 20.823 20.2188 20.6876 20.4219C20.4741 20.7552 20.1252 20.901 19.7503 20.9948C17.2458 21 14.7464 21 12.2471 21ZM19.7347 16.7917C19.6462 16.8281 19.5785 16.8594 19.5108 16.8906C18.4746 17.3854 17.4332 17.875 16.4022 18.375C16.1263 18.5104 15.8815 18.5156 15.6056 18.375C14.7516 17.9531 13.8873 17.5469 13.0229 17.1406C12.773 17.0208 12.523 16.9062 12.2523 16.776C12.2523 17.6771 12.2523 18.5469 12.2523 19.4219C12.2523 19.6875 12.3096 19.7448 12.5699 19.7448C14.861 19.7448 17.1468 19.7448 19.4379 19.7448C19.6878 19.7448 19.7503 19.6875 19.7503 19.4375C19.7503 18.6094 19.7503 17.7865 19.7503 16.9583C19.7451 16.9167 19.7399 16.8646 19.7347 16.7917ZM19.3181 15.599C17.0844 15.599 14.9078 15.599 12.6793 15.599C12.7626 15.6406 12.7886 15.6562 12.8146 15.6667C13.83 16.151 14.8401 16.6354 15.8607 17.1146C15.9388 17.151 16.0638 17.1458 16.1419 17.1094C17.1 16.6615 18.0581 16.2031 19.0109 15.75C19.0995 15.7031 19.1828 15.6615 19.3181 15.599ZM17.2458 14.3177C17.2458 14.1042 17.251 13.9062 17.2458 13.7083C17.2406 13.5781 17.1625 13.5052 17.0323 13.5C16.345 13.4948 15.6524 13.4948 14.9651 13.5C14.8349 13.5 14.7568 13.5781 14.7516 13.7083C14.7464 13.9062 14.7516 14.1094 14.7516 14.3177C15.5795 14.3177 16.397 14.3177 17.2458 14.3177Z"
                                                        stroke="#1967D2" stroke-width="0.3" />
                                                    <path
                                                        d="M1 14.5573C1.05207 14.3229 1.09373 14.0885 1.15621 13.8594C1.63004 12.2031 3.1661 11.0156 4.88961 11.0052C7.25879 10.9948 9.62796 11 11.9971 11C12.3825 11 12.6584 11.2656 12.6636 11.6146C12.6688 11.974 12.3825 12.2448 11.9919 12.2448C9.68003 12.2448 7.37334 12.2448 5.06144 12.2448C3.41604 12.2448 2.24967 13.4167 2.24967 15.0625C2.24967 15.7188 2.24967 16.375 2.24967 17.0365C2.24967 17.099 2.24967 17.1615 2.24967 17.2448C2.3434 17.2448 2.4215 17.2448 2.4944 17.2448C4.54595 17.2448 6.59229 17.2448 8.64384 17.2448C9.04478 17.2448 9.32075 17.5 9.32596 17.8646C9.33116 18.2031 9.07602 18.474 8.73757 18.4948C8.65426 18.5 8.57094 18.4948 8.48243 18.4948C6.25905 18.4948 4.03046 18.4896 1.80708 18.5C1.42177 18.5 1.15621 18.3802 1 18.026C1 16.875 1 15.7135 1 14.5573Z"
                                                        stroke="#1967D2" stroke-width="0.3" />
                                                    <path
                                                        d="M8.88857 1C9.24785 1.08854 9.61755 1.14583 9.96121 1.27083C11.7576 1.94271 12.8146 3.67188 12.6376 5.64062C12.4762 7.41146 11.0338 8.94792 9.21661 9.27083C6.55584 9.75 4.11898 7.53125 4.34809 4.84375C4.51471 2.84375 5.99349 1.30729 7.99818 1.03646C8.03463 1.03125 8.07108 1.01562 8.10752 1.00521C8.36787 1 8.62822 1 8.88857 1ZM8.49805 8.07812C10.107 8.07812 11.4192 6.76562 11.414 5.16146C11.4087 3.5625 10.1018 2.25521 8.50325 2.25C6.89951 2.24479 5.58214 3.55208 5.58214 5.16146C5.57693 6.76562 6.88909 8.07812 8.49805 8.07812Z"
                                                        stroke="#1967D2" stroke-width="0.3" />
                                                </svg>
                                            </div>
                                            <p class="fs-14 text-secondary mb-0">@lang('messages.positions'):</p>
                                        </div>
                                        <p class="fs-14 text-gray text-end mb-0">
                                            {{ isset($job->position) ? $job->position : '0' }}</p>
                                    </div>
                                    <div class="desc-box d-flex justify-content-between mb-4">
                                        <div class="desc d-flex">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-2' : 'me-2' }} w-20">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.3178 2.86173C5.33445 2.47506 5.32335 2.12408 5.37331 1.78499C5.51763 0.785589 6.32807 0.0181889 7.26617 0.01224C9.09243 0.000342363 10.9187 -0.00560648 12.7449 0.01224C13.783 0.0241377 14.6323 0.958106 14.6656 2.07649C14.6711 2.32634 14.6656 2.58214 14.6656 2.86173C14.7544 2.86173 14.8265 2.86173 14.8987 2.86173C15.8923 2.86173 16.8859 2.86173 17.874 2.86173C19.1452 2.86173 19.9945 3.76596 19.9945 5.12229C19.9945 6.12765 20 7.133 19.9945 8.13241C19.9889 9.07232 19.5837 9.75049 18.7899 10.1431C18.6622 10.2086 18.6622 10.2918 18.6622 10.4049C18.6622 12.3977 18.6678 14.3906 18.6622 16.3834C18.6622 18.1324 17.5742 19.5661 15.9756 19.923C15.748 19.9765 15.5093 19.9944 15.2706 19.9944C11.7513 20.0003 8.23204 20.0003 4.71275 19.9944C2.80323 19.9944 1.33778 18.4179 1.33223 16.3775C1.33223 14.3906 1.33223 12.4037 1.33223 10.4227C1.33223 10.268 1.29337 10.1967 1.16015 10.1253C0.416326 9.73264 0.0166589 9.08422 6.1579e-06 8.19189C-0.0166466 7.13895 -0.00554477 6.08006 6.1579e-06 5.02116C0.00555709 3.7957 0.877053 2.86768 2.02054 2.86173C3.04192 2.85579 4.06329 2.86173 5.07911 2.86173C5.16792 2.86173 5.24008 2.86173 5.3178 2.86173ZM17.3245 10.619C15.7591 11.0771 14.2159 11.5292 12.6672 11.9813C12.6672 12.487 12.6672 12.9807 12.6672 13.4685C12.6672 14.0158 12.4063 14.2895 11.8956 14.2895C10.6411 14.2895 9.38108 14.2895 8.12657 14.2895C7.58813 14.2895 7.33279 14.0218 7.33279 13.4447C7.33279 12.9569 7.33279 12.4691 7.33279 11.9754C5.77297 11.5173 4.22981 11.0711 2.67 10.6131C2.67 10.7083 2.67 10.7737 2.67 10.8391C2.67 12.6833 2.67 14.5274 2.67 16.3716C2.67 17.6387 3.5415 18.5667 4.72385 18.5726C8.24314 18.5726 11.7624 18.5726 15.2762 18.5726C15.4704 18.5726 15.6647 18.5488 15.8535 18.4953C16.7361 18.2395 17.33 17.4185 17.33 16.4251C17.3356 14.5512 17.33 12.6773 17.33 10.8034C17.33 10.7439 17.3245 10.6904 17.3245 10.619ZM12.6672 10.4822C12.7283 10.4703 12.7727 10.4584 12.8227 10.4465C14.5934 9.92896 16.3641 9.41141 18.1349 8.88791C18.5013 8.78083 18.6678 8.53098 18.6678 8.11456C18.6678 7.10326 18.6678 6.09195 18.6678 5.08065C18.6678 4.56905 18.4013 4.28351 17.9184 4.28351C12.645 4.28351 7.37164 4.28351 2.09826 4.28351C1.60422 4.28351 1.34333 4.56905 1.34333 5.0985C1.34333 6.07411 1.34333 7.04377 1.34333 8.01938C1.34333 8.57262 1.49321 8.78083 1.98724 8.9236C3.06967 9.23889 4.1521 9.55418 5.23453 9.86947C5.9284 10.0717 6.62227 10.274 7.33834 10.4822C7.33834 10.0896 7.33834 9.72075 7.33834 9.35192C7.33834 8.85222 7.60478 8.56667 8.07661 8.56667C9.35887 8.56667 10.6467 8.56667 11.929 8.56667C12.4063 8.56667 12.6672 8.85222 12.6728 9.36976C12.6672 9.74454 12.6672 10.1074 12.6672 10.4822ZM13.3333 2.84984C13.3333 2.62973 13.3333 2.42152 13.3333 2.21926C13.3278 1.72551 13.0613 1.43401 12.5895 1.43401C11.7569 1.43401 10.9242 1.43401 10.0916 1.43401C9.18124 1.43401 8.27644 1.43401 7.36609 1.43401C7.00528 1.43401 6.71108 1.68386 6.67777 2.04079C6.65557 2.30254 6.67222 2.57024 6.67222 2.84984C8.8926 2.84984 11.0963 2.84984 13.3333 2.84984ZM11.3184 12.8498C11.3184 11.8921 11.3184 10.9522 11.3184 10.0241C10.4247 10.0241 9.55316 10.0241 8.67611 10.0241C8.67611 10.976 8.67611 11.9099 8.67611 12.8498C9.55871 12.8498 10.4302 12.8498 11.3184 12.8498Z"
                                                        fill="#1967D2" />
                                                </svg>
                                            </div>
                                            <p class="fs-14 text-secondary mb-0">@lang('messages.job_experience.job_experience'):</p>
                                        </div>
                                        <p class="fs-14 text-gray text-end mb-0">
                                            {{ isset($job->experience) ? $job->experience . ' ' . __('messages.candidate_profile.year') : 'No experience' }}
                                        </p>
                                    </div>
                                    <div class="desc-box d-flex justify-content-between mb-4">
                                        <div class="desc d-flex">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-2' : 'me-2' }} w-20">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1043_525)">
                                                        <path
                                                            d="M19.9938 19.9997C13.3292 19.9997 6.6708 19.9997 0.00619963 19.9997C0.00619963 19.9386 0 19.8836 0 19.8225C0 14.0742 0 8.32586 0 2.58365C0 2.51646 0.00619963 2.44926 0.00619963 2.40039C0.936144 2.40039 1.84129 2.40039 2.74643 2.40039C2.77743 2.40039 2.80843 2.41261 2.85803 2.42483C2.85803 2.66918 2.85183 2.90742 2.85803 3.14566C2.87663 3.91536 3.23621 4.5079 3.88717 4.91108C5.25108 5.75409 7.06138 4.79502 7.13577 3.20064C7.14817 2.94407 7.13577 2.68139 7.13577 2.41872C9.05146 2.41872 10.9485 2.41872 12.858 2.41872C12.858 2.68139 12.8456 2.93796 12.858 3.18842C12.92 4.53845 14.2095 5.4853 15.5301 5.15543C16.4414 4.92941 17.1048 4.10473 17.1358 3.18231C17.142 2.93185 17.1358 2.68139 17.1358 2.42483C18.0967 2.42483 19.0329 2.42483 19.9814 2.42483C19.9814 2.52257 19.9814 2.60809 19.9814 2.6875C19.9876 8.38084 19.9938 14.0803 19.9938 19.7736C20 19.8408 19.9938 19.9202 19.9938 19.9997ZM1.43831 18.5824C7.16057 18.5824 12.858 18.5824 18.5617 18.5824C18.5617 14.8317 18.5617 11.0931 18.5617 7.34847C12.8456 7.34847 7.14197 7.34847 1.43831 7.34847C1.43831 11.0992 1.43831 14.8378 1.43831 18.5824Z"
                                                            fill="#1967D2" />
                                                        <path
                                                            d="M16.3548 2.1318C16.3548 2.45556 16.3982 2.78543 16.3486 3.10309C16.2432 3.76283 15.6294 4.2332 14.9475 4.21488C14.2531 4.19655 13.6579 3.70785 13.6021 3.02368C13.5525 2.41891 13.5525 1.80193 13.6021 1.19105C13.6641 0.494659 14.3089 -0.0245836 15.0095 -0.000148705C15.7348 0.0242862 16.3238 0.561855 16.3734 1.27047C16.392 1.55758 16.3796 1.84469 16.3796 2.1318C16.3734 2.1318 16.3672 2.1318 16.3548 2.1318Z"
                                                            fill="#1967D2" />
                                                        <path
                                                            d="M3.53369 2.10148C3.57089 1.71663 3.56469 1.31956 3.65768 0.94693C3.81267 0.342166 4.46364 -0.0549023 5.0836 0.00618505C5.75936 0.0733811 6.31112 0.56208 6.34832 1.19739C6.38552 1.80826 6.38552 2.41914 6.34832 3.03001C6.30493 3.71419 5.65396 4.23343 4.94101 4.2151C4.22805 4.19678 3.62049 3.64699 3.58329 2.96281C3.56469 2.6757 3.58329 2.38859 3.58329 2.10148C3.56469 2.10759 3.55229 2.10759 3.53369 2.10148Z"
                                                            fill="#1967D2" />
                                                        <path
                                                            d="M6.13165 13.4451C6.13165 13.0541 6.13165 12.6876 6.13165 12.2844C6.30524 12.2844 6.48503 12.3028 6.65861 12.2783C6.9562 12.2417 7.25998 12.2111 7.54516 12.1134C7.87994 12.0034 8.04113 11.7102 8.01633 11.417C7.98534 11.1177 7.78075 10.8916 7.42737 10.8122C6.826 10.6656 6.26184 10.8306 5.72247 11.0688C5.66047 11.0932 5.60468 11.1299 5.52408 11.1665C5.41249 10.7756 5.3009 10.4029 5.1831 9.98144C5.47449 9.87148 5.75347 9.73709 6.05105 9.65768C6.78881 9.4622 7.53276 9.395 8.28292 9.6027C8.90908 9.77374 9.41745 10.1036 9.62204 10.7572C9.87002 11.5697 9.46705 12.37 8.64869 12.7182C8.5805 12.7487 8.5061 12.7792 8.46271 12.7976C8.74169 12.9442 9.05167 13.0541 9.29966 13.2435C10.087 13.8605 10.149 15.0273 9.45465 15.7786C9.00827 16.2551 8.43791 16.4872 7.79935 16.585C6.857 16.7255 5.94566 16.6277 5.07771 16.2185C5.04671 16.2062 5.02191 16.1879 4.97852 16.1635C5.08391 15.7664 5.1955 15.3632 5.2947 15.0028C5.72867 15.1189 6.14405 15.2594 6.56562 15.3388C6.9314 15.4121 7.30338 15.3877 7.65675 15.2411C7.99773 15.1006 8.20852 14.8562 8.22092 14.4897C8.23332 14.1293 8.06593 13.8544 7.74355 13.6772C7.43357 13.5062 7.09879 13.4634 6.75161 13.4573C6.53462 13.439 6.33623 13.4451 6.13165 13.4451Z"
                                                            fill="#1967D2" />
                                                        <path
                                                            d="M11.7357 11.6615C11.6427 11.24 11.5559 10.8551 11.4629 10.452C11.8039 10.2931 12.1572 10.1649 12.4796 9.98159C13.0376 9.67005 13.6204 9.53566 14.2589 9.60285C14.3891 9.61507 14.5193 9.60285 14.6619 9.60285C14.6619 11.912 14.6619 14.2027 14.6619 16.5118C14.1473 16.5118 13.6266 16.5118 13.0934 16.5118C13.0934 14.6975 13.0934 12.8832 13.0934 11.0323C12.6346 11.2461 12.2006 11.4477 11.7357 11.6615Z"
                                                            fill="#1967D2" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1043_525">
                                                            <rect width="20" height="20" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <p class="fs-14 text-secondary mb-0">@lang('messages.job.salary_period'):</p>
                                        </div>
                                        <p class="fs-14 text-gray text-end mb-0">
                                            {{ $job->salaryPeriod->period }}
                                        </p>
                                    </div>
                                    <div class="desc-box d-flex justify-content-between mb-4">
                                        <div class="desc d-flex">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-2' : 'me-2' }} w-20">
                                                <svg width="20" height="18" viewBox="0 0 20 18" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1043_535)">
                                                        <path
                                                            d="M16.9547 15.2014C16.9547 15.11 16.9547 15.0358 16.9547 14.9558C16.9547 12.209 16.9547 9.45645 16.9606 6.70962C16.9606 6.49262 16.9007 6.4298 16.6729 6.43551C16.0734 6.45264 15.4738 6.44122 14.8623 6.44122C14.9283 6.19566 14.9822 5.97295 15.0482 5.74452C15.6597 5.74452 16.2772 5.72168 16.8887 5.75023C17.3084 5.76736 17.6561 6.15569 17.6921 6.55544C17.6981 6.6411 17.6981 6.72676 17.6981 6.81242C17.6981 9.49072 17.6921 12.169 17.7041 14.8416C17.7041 15.2585 17.5782 15.5954 17.1945 15.8181C17.2064 15.8353 17.2124 15.8581 17.2184 15.8581C17.6081 15.8181 17.9259 16.0009 18.2496 16.1608C18.8312 16.4406 19.4067 16.7204 20.0122 17.0117C19.8443 17.2858 19.7065 17.5542 19.5266 17.794C19.4487 17.8911 19.2868 17.9368 19.1549 17.9882C19.1069 18.011 19.035 17.9939 18.975 17.9939C12.9978 17.9939 7.0146 17.9939 1.03739 17.9996C0.713646 17.9996 0.497819 17.9082 0.359929 17.6227C0.264006 17.4228 0.138106 17.2344 0.012207 17.0231C0.0721591 16.9888 0.126116 16.9545 0.180073 16.926C0.743622 16.6462 1.30717 16.3606 1.87672 16.0979C2.15249 15.9723 2.45225 15.8981 2.72803 15.801C2.74002 15.8067 2.69806 15.7782 2.66209 15.7496C2.35034 15.5269 2.26041 15.2242 2.26041 14.8644C2.2664 12.4774 2.26041 10.096 2.26041 7.70899C2.26041 7.36635 2.25441 7.02371 2.26041 6.68107C2.2664 6.11 2.66808 5.7331 3.2676 5.72739C3.7712 5.72168 4.2688 5.72739 4.7724 5.72168C4.90429 5.72168 4.95225 5.75594 4.97624 5.88158C5.00621 6.05861 5.08415 6.23564 5.1441 6.4298C4.43667 6.4298 3.74122 6.4298 3.02779 6.4298C3.02779 9.35366 3.02779 12.2604 3.02779 15.19C7.6501 15.2014 12.2844 15.2014 16.9547 15.2014ZM18.3755 17.0916C18.0698 16.8518 17.77 16.749 17.3923 16.749C12.5542 16.7604 7.71005 16.7604 2.87192 16.749C2.5242 16.749 2.29038 16.9089 1.98463 17.0916C7.47624 17.0916 12.9079 17.0916 18.3755 17.0916Z"
                                                            fill="#1967D2" />
                                                        <path
                                                            d="M11.3069 10.1997C11.7685 10.274 12.2121 10.3482 12.6558 10.4167C13.3812 10.5252 13.8668 10.9021 14.0946 11.576C14.1426 11.7188 14.1966 11.8615 14.2385 12.0043C14.4663 12.7067 14.0047 13.3177 13.2373 13.3234C11.9484 13.3292 10.6594 13.3292 9.37041 13.3292C8.50111 13.3292 7.6318 13.3292 6.7625 13.3292C5.92317 13.3292 5.46154 12.7238 5.71933 11.9586C5.73732 11.9129 5.7553 11.8615 5.7673 11.8158C5.98912 10.9193 6.60063 10.4681 7.54188 10.3825C7.85363 10.3539 8.16538 10.2968 8.47113 10.2397C8.53708 10.2283 8.633 10.1597 8.633 10.1141C8.633 9.96558 8.80087 9.77142 8.59703 9.66292C7.35602 9.0119 6.82245 7.89832 6.43876 6.68195C6.3908 6.53919 6.33084 6.43639 6.19296 6.35073C5.72533 6.05949 5.61142 5.37421 5.95914 4.96875C6.04307 4.87167 6.02509 4.80314 5.99511 4.70035C5.8812 4.28347 5.74331 3.86089 5.68336 3.4383C5.64739 3.19845 5.69535 2.91292 5.79727 2.69591C6.52869 1.14832 7.82965 0.291724 9.56226 0.057587C10.7313 -0.102311 11.2349 0.0632977 12.4879 0.805683C12.5359 0.69147 12.5838 0.582968 12.6198 0.474465C12.6558 0.360252 12.6798 0.246039 12.7157 0.0975616C12.9136 0.394516 12.9436 0.69147 12.8896 0.999846C12.8416 1.27396 12.8836 1.31964 13.1774 1.33677C13.5311 1.35962 13.8428 1.46241 14.0886 1.77078C13.8968 1.76507 13.7349 1.75365 13.5491 1.74794C13.8129 2.34185 13.9088 2.94718 13.9388 3.55822C13.9507 3.83804 13.8788 4.11787 13.8368 4.39769C13.8069 4.60327 13.7649 4.7803 13.9687 4.95162C14.3404 5.28284 14.2325 6.11089 13.7949 6.37929C13.669 6.45924 13.627 6.55632 13.5731 6.67624C13.3692 7.17878 13.1654 7.68703 12.9256 8.17243C12.6198 8.7949 12.1282 9.25746 11.5047 9.58868C11.3009 9.69718 11.2169 9.81139 11.2889 10.0227C11.3069 10.0741 11.3009 10.1255 11.3069 10.1997ZM7.33804 3.22129C6.96634 3.26127 6.82845 3.46685 6.77449 3.95226C6.72053 4.43766 6.73252 4.93449 6.71454 5.42561C6.70854 5.61406 6.66658 5.80822 6.70854 5.98525C6.79248 6.36787 6.89439 6.75048 7.03828 7.11596C7.36202 7.9383 7.77569 8.71495 8.61502 9.18322C8.93276 9.36025 9.25051 9.52586 9.58025 9.68576C9.85602 9.8171 10.1438 9.81139 10.4256 9.69718C11.4987 9.25746 12.38 8.61786 12.8057 7.53284C13.0635 6.8704 13.4472 6.23081 13.2793 5.48271C13.2193 5.21431 13.1354 4.9402 13.0095 4.70035C12.8896 4.47764 12.8356 4.27205 12.8836 4.02649C12.9436 3.74667 12.8356 3.60962 12.5359 3.60962C12.2721 3.60962 11.9963 3.64959 11.7385 3.71241C11.109 3.87802 10.4855 3.89515 9.85602 3.72383C9.54427 3.64388 9.23852 3.5468 8.92677 3.48398C8.28528 3.35264 7.86562 3.63246 7.73372 4.2435C7.72173 4.28919 7.70375 4.33487 7.68576 4.39769C7.28408 4.08931 7.21813 3.68957 7.33804 3.22129ZM10.8572 10.0056C10.5515 10.0684 10.2577 10.1769 9.96993 10.1712C9.67617 10.1655 9.3884 10.0398 9.05866 9.95987C9.08864 10.6794 9.43636 11.3133 9.6402 11.9872C9.71214 11.6445 9.7661 11.3076 9.80207 10.9707C9.80806 10.8964 9.7661 10.7936 9.70614 10.7365C9.57425 10.6052 9.42437 10.491 9.28048 10.371C9.29847 10.3539 9.31046 10.3425 9.32845 10.3254C9.75411 10.3254 10.1798 10.3254 10.6594 10.3254C10.4855 10.4853 10.3416 10.6109 10.2157 10.7479C10.1678 10.7993 10.1258 10.8793 10.1318 10.9478C10.1678 11.2847 10.2217 11.6274 10.2637 11.9643C10.4975 11.3818 10.6954 10.7936 10.8812 10.2054C10.9052 10.1255 10.8632 10.0455 10.8572 10.0056Z"
                                                            fill="#1967D2" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_1043_535">
                                                            <rect width="20" height="18" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </div>
                                            <p class="fs-14 text-secondary mb-0">@lang('messages.job.is_freelance'):</p>
                                        </div>
                                        <p class="fs-14 text-gray text-end mb-0">
                                            {{ $job->is_freelance == 1 ? __('messages.common.yes') : __('messages.common.no') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="desc-box">
                                    <h5 class="fs-18 text-secondary mb-4">@lang('web.job_details.job_skills')</h5>
                                    <div class="d-flex flex-wrap gap-3">
                                        @if ($job->jobsSkill->isNotEmpty())
                                        <ul>
                                            @foreach ($job->jobsSkill->pluck('name') as $key => $value)
                                                <li
                                                    class="fs-14 text-gray py-2 {{ $loop->last ? '' : 'me-4' }} ">
                                                    {{ html_entity_decode($value) }}</li>
                                            @endforeach
                                        </ul>
                                        @else
                                            <p class="fs-14 text-gray bg-white py-2 br-gray px-3">
                                                {{ __('messages.common.n/a') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="company-overview br-10 px-40 bg-light">
                                <h5 class="fs-18 text-secondary mb-4">@lang('web.job_details.company_overview')</h5>
                                <div class="company-profile d-flex align-items-center mb-4">
                                    <div class="profile">
                                        <img src="{{ $job->company->company_url }}" class="w-100 h-100 object-fit-cover"
                                            alt="company-details" />
                                    </div>
                                    <div class="desc {{ getFrontSelectLanguage() == 'ar' ? 'me-4' : 'ms-4' }}">
                                        <p class="fs-18 text-secondary mb-0">
                                            {{ html_entity_decode($job->company->user->first_name) }}</p>
                                        <a hred="{{ route('front.company.details', $job->company->unique_id) }}"
                                            class="fs-14 text-primary">@lang('web.web_jobs.view_company_profile')</a>
                                    </div>
                                </div>
                                <div class="desc-box d-flex justify-content-between mb-4">
                                    <p class="fs-14 text-secondary mb-0">@lang('web.web_jobs.founded_in'):</p>
                                    <p class="fs-14 text-gray text-end mb-0">{{ $job->company->established_in }}</p>
                                </div>
                                @if ($job->company->user->phone)
                                    <div class="desc-box d-flex justify-content-between mb-2">
                                        <p class="fs-14 text-secondary mb-0">@lang('web.web_jobs.phone'):</p>
                                        <p class="fs-14 text-gray text-end mb-0">{{ $job->company->user->phone }}</p>
                                    </div>
                                @endif
                                <div class="desc-box d-flex justify-content-between mb-4">
                                    <p class="fs-14 text-secondary mb-0">@lang('web.common.location'):</p>
                                    @if (!empty($job->company->location))
                                        <p class="fs-14 text-gray text-end mb-0">{{ $job->company->location }}</p>
                                    @else
                                        <p class="fs-14 text-gray text-end mb-0">
                                            {{ __('web.job_details.location_information_not_available') }}
                                        </p>
                                    @endif
                                </div>
                                <a href="{{ route('front.company.details', $job->company->unique_id) }}"
                                    class="jobs-position col-12 btn btn-light">
                                    {{ __('web.companies_menu.opened_jobs') }} : {{ $jobsCount ? $jobsCount : 0 }}
                                </a>
                                @if ($job->company->website)
                                    <div class="card-desc mt-3">
                                        <div class="desc  d-flex mt-2">
                                            <a href="{{ $job->company->website }}"
                                                class="jobs-position fs-14 text-primary"
                                                target="_blank">{{ $job->company->website }}</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @if (count($getRelatedJobs) > 0)
                            <div class="row job-details-related-jobs our-latest-jobs">
                                <h5 class="fs-18 text-secondary mt-5 mb-4 pb-2">
                                    @lang('web.job_details.related_jobs')
                                </h5>
                                @foreach ($getRelatedJobs as $relatedJob)
                                    @if ($relatedJob->status != \App\Models\Job::STATUS_DRAFT)
                                        <div class="col-lg-4 col-md-6 px-xl-3 mb-40">
                                            <div class="card py-30">
                                                @if (Str::length($relatedJob['job_title']) < 35)
                                                    <a href="{{ route('front.job.details', $relatedJob['job_id']) }}"
                                                        class="text-secondary primary-link-hover">
                                                        <h5 class="card-title fs-20 mb-2">
                                                            {{ html_entity_decode($relatedJob['job_title']) }}
                                                        </h5>
                                                    </a>
                                                @else
                                                    <a href="{{ route('front.job.details', $relatedJob['job_id']) }}"
                                                        data-toggle="tooltip" data-placement="bottom" class="hover-color"
                                                        title="{{ html_entity_decode($relatedJob['job_title']) }}">
                                                        <h5 class="card-title fs-20 mb-2">
                                                            {{ Str::limit(html_entity_decode($relatedJob['job_title']), 30, '...') }}
                                                        </h5>
                                                    </a>
                                                @endif
                                                <div class="mt-2 d-flex flex-wrap align-items-center">
                                                    @if (isset($relatedJob->jobShift->shift))
                                                        <span class="text text-primary fs-12 mb-0 me-3 related-jobs">
                                                            {{ $relatedJob->jobShift->shift }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-4">
                                                            <img src="{{ $relatedJob->company->company_url }}"
                                                                class="card-img" alt="..." />
                                                        </div>
                                                        <div class="">
                                                            <div class="card-body p-0">
                                                                <a
                                                                    href="{{ route('front.company.details', $relatedJob->company->unique_id) }}">
                                                                    <p class="card-title fs-18 mb-0 text-primary">
                                                                        {{ $relatedJob->company->user->first_name }}</p>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="icon position-relative pe-0">
                                                        <i class="text-primary fa-solid fa-bookmark"></i>
                                                    </div>
                                                </div>
                                                <div
                                                    class="card-desc d-flex flex-column justify-content-between h-100 mt-4">
                                                    <div class="desc">
                                                        <div class="d-flex mb-1">
                                                            <div class="me-3 w-20">
                                                                <img src="{{ asset('img_template/briefcase.svg') }}"
                                                                    class="w-100" />
                                                            </div>
                                                            <p class="fs-14 text-gray mb-0">
                                                                {{ !empty($job->jobCategory->name) ? $job->jobCategory->name : '' }}
                                                            </p>
                                                        </div>
                                                        <div class="d-flex mb-2">
                                                            <div class="me-3 w-20">
                                                                <img src=" {{ asset('img_template/location.svg') }} "
                                                                    class="w-100" />
                                                            </div>

                                                            <p class="fs-14 text-gray mb-0">
                                                                {{ !empty($job->full_location) ? $job->full_location : 'Location Info. not available.' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @if ($getRelatedJobs->count() > 0)
                                    <div class="row justify-content-center">
                                        <div class="col-8 text-center">
                                            <a href="{{ route('front.search.jobs', ['categories' => $relatedJob->jobCategory->id]) }}"
                                                class="btn btn-primary  mb-40 mt-lg-4">
                                                @lang('web.common.show_all')</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- end job-details section -->
    </div>
    @role('Candidate')
        @include('front_web.jobs.email_to_friend')
        @include('front_web.jobs.report_job_modal')
    @endrole
    {{ Form::hidden('isJobAddedToFavourite', $isJobAddedToFavourite, ['id' => 'isJobAddedToFavourite']) }}
    {{ Form::hidden('removeFromFavorite', __('web.job_details.remove_from_favorite'), ['id' => 'removeFromFavorite']) }}
    {{ Form::hidden('addToFavorites', __('web.job_details.add_to_favorite'), ['id' => 'addToFavorites']) }}
@endsection
{{-- @section('page_scripts') --}}
{{--    <script> --}}
{{-- let addJobFavouriteUrl = "{{ route('save.favourite.job') }}"; --}}
{{-- let reportAbuseUrl = "{{ route('report.job.abuse') }}"; --}}
{{-- let emailJobToFriend = "{{ route('email.job') }}"; --}}
{{--        let isJobAddedToFavourite = "{{ $isJobAddedToFavourite }}"; --}}
{{-- let removeFromFavorite = "{{ __('web.job_details.remove_from_favorite') }}"; --}}
{{-- let addToFavorites = "{{ __('web.job_details.add_to_favorite') }}"; --}}
{{--    </script> --}}
{{-- @endsection --}}
