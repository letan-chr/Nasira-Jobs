@extends('front_web.layouts.app')
@section('title')
    {{ __('web.company_details.company_details') }}
@endsection
{{-- @section('page_css') --}}
{{--    <link href="{{asset('front_web/scss/company-details.css')}}" rel="stylesheet" type="text/css"> --}}
{{-- @endsection --}}
{{-- @dd($companyDetail) --}}
@section('content')
    <div class="company-details-page">
        <!-- start hero section -->
        <section class="hero-section position-relative bg-gradient py-40">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12">
                        <div class="d-flex align-items-md-center">
                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                <div class="hero-img">
                                    <img src="{{ !empty($companyDetail->company_url) ? $companyDetail->company_url : asset('assets/img/infyom-logo.png') }}"
                                        class="w-100 h-100 rounded-circle object-fit-cover" alt="company-details" />
                                </div>
                            </div>
                            <div class="">
                                <div class="hero-content">
                                    <h4 class="text-secondary lh-base mb-2">
                                        {{ html_entity_decode($companyDetail->user->full_name) }}</h4>
                                    <div class="hero-desc d-md-flex flex-wrap">
                                        <div class="desc d-flex mb-1 {{ getFrontSelectLanguage() == 'ar' ? 'ms-5' : 'me-5' }}">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                <img src="{{ asset('img_template/briefcase.svg') }}" class="w-100" />
                                            </div>
                                            <p class="text-gray mb-0">
                                                {{ !empty($companyDetail->industry->name) ? $companyDetail->industry->name : __('messages.n/a') }}
                                            </p>
                                        </div>
                                        <div class="desc d-flex mb-1 {{ getFrontSelectLanguage() == 'ar' ? 'ms-5' : 'me-5' }}">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                <img src="{{ asset('img_template/location.svg') }}" class="w-100" />
                                            </div>
                                            <p class="text-gray mb-0">
                                                {{ $companyDetail->user->city_name . ', ' . $companyDetail->user->country_name }}
                                            </p>
                                        </div>
                                        @isset($companyDetail->user->phone)
                                            <div class="desc d-flex mb-1 {{ getFrontSelectLanguage() == 'ar' ? 'ms-5' : 'me-5' }}">
                                                <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                    <img src="{{ asset('img_template/contact.svg') }}" class="w-100" />
                                                </div>
                                                <p class="text-gray mb-0">
                                                    {{ $companyDetail->user->phone }}
                                                </p>
                                            </div>
                                        @endisset
                                        <div class="desc d-flex mb-1 {{ getFrontSelectLanguage() == 'ar' ? 'ms-5' : 'me-5' }}">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                <img src="{{ asset('img_template/email.svg') }}" class="w-100" />
                                            </div>
                                            <a href="#"
                                                class="text-gray text-break">{{ $companyDetail->user->email }}</p></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @role('Candidate')
                            <div class="row align-items-lg-center mt-4">
                                <div class="hero-desc d-md-flex">
                                    <div class="desc d-flex me-4 mb-sm-0 mb-2 pe-2">
                                        <a href="javascript:void(0)" class="btn btn-outline-primary reportJobAbuse"
                                            data-favorite-user-id="{{ getLoggedInUserId() !== null ? getLoggedInUserId() : null }}"
                                            data-favorite-company_id="{{ $companyDetail->id }}" id="addToFavourite">
                                            <i class="favouriteIcon"></i>
                                            <span class="favouriteText"></span>
                                        </a>
                                    </div>
                                    <div class="desc d-flex me-4 pe-2">
                                        @if ($isReportedToCompany)
                                            <button type="button" class="btn btn-outline-primary reportToCompanyBtn me-4" disabled
                                                data-bs-toggle="modal" data-bs-target="#reportToCompanyModal">
                                                {{ __('messages.candidate.already_reported') }}
                                            </button>
                                        @else
                                            <button data-bs-toggle="modal" data-bs-target="#reportToCompanyModal"
                                                class="btn btn-outline-primary  reportToCompanyBtn {{ $isReportedToCompany ? 'disabled' : '' }}"
                                                {{ $isReportedToCompany ? 'style=pointer-events:none;' : '' }}>{{ __('messages.company.report_to_company') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endrole
                    </div>
                </div>
            </div>
        </section>
        <!-- end hero section -->

        <!-- start about-comapany section -->
        <section class="about-company-section pt-60 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-lg-0 mb-40">
                        <div class="aboout-company-left text-gray mb-5">
                            <h5 class="fs-18 text-secondary">@lang('web.web_company.about_company')</h5>
                            <p class="fs-16 mb-0">
                                {!! nl2br(e($companyDetail->details)) !!}
                            </p>
                        </div>
                        <div class="our-latest-jobs">
                            <h5 class="fs-18 text-secondary mb-40">{{ ($jobDetails->count() > 0 ) ? __('web.company_details.our_latest_jobs')  : __('web.home_menu.latest_job_not_available') }}</h5>
                            <div class="job-card">
                                @foreach ($jobDetails as $job)
                                    <div class="mb-40">
                                        <a href="{{ route('front.job.details', $job['job_id']) }}"
                                            class="card py-30 border-0">
                                            <div class="d-sm-flex position-relative">
                                                <div class="mb-sm-0 mb-3 {{ getFrontSelectLanguage() == 'ar' ? 'ms-sm-4' : 'me-sm-4' }}">
                                                    <img src="{{ $job->company->company_url }}" class="card-img"
                                                        alt="">
                                                </div>
                                                <div class="">
                                                    <div class="card-body p-0">
                                                        <h5 class="card-title text-secondary fs-18 mb-0">
                                                            {{ html_entity_decode(Str::limit($job['job_title'], 50)) }}
                                                        </h5>
                                                        <div class="">
                                                            <div class="card-desc d-flex flex-wrap mt-2">
                                                                <div class="desc d-flex {{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                                                    <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                                        <img src="{{ asset('img_template/briefcase.svg') }}"
                                                                            class="w-100" />
                                                                    </div>
                                                                    <p class="fs-14 text-gray mb-2">
                                                                        {{ $job->jobCategory->name }}
                                                                    </p>
                                                                </div>
                                                                <div class="desc d-flex {{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                                                    <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                                        <img src="{{ asset('img_template/location.svg') }}"
                                                                            class="w-100" />
                                                                    </div>
                                                                    <p class="fs-14 text-gray mb-2">
                                                                        {{ !empty($job->full_location) ? $job->full_location : 'Location Info. not available.' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="desc d-flex">
                                                            <p class="text text-primary fs-14 mb-0 {{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }}">
                                                                {{ !empty($job->jobsSkill[0]->name) ? $job->jobsSkill[0]->name : 'Skill' }}
                                                            </p>
                                                            <p class="fs-14 text text-primary mb-0">
                                                                {{ $job->jobsSkill->count() }}+</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            @if ($jobDetails->count() > 0)
                                <div class="text-center py-4">
                                    <a href="{{ route('front.search.jobs', ['company' => $companyDetail->id]) }}"
                                        class="btn btn-primary "> @lang('web.common.show_all')</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="about-company-right br-10 px-40 bg-light">
                            <div class="desc d-flex justify-content-between mb-3">
                                <p class="fs-14 text-secondary mb-0">@lang('web.web_company.ownership'):</p>
                                <p class="fs-14 text-gray text-end mb-0">{{!empty($companyDetail->ownerShipType->name)? $companyDetail->ownerShipType->name : __('messages.n/a')}}</p>
                            </div>
                            <div class="desc d-flex justify-content-between mb-3">
                                <p class="fs-14 text-secondary mb-0">@lang('web.web_company.company_size'):</p>
                                <p class="fs-14 text-gray text-end mb-0">{{!empty($companyDetail->companySize->size)? $companyDetail->companySize->size : __('messages.n/a')}}</p>
                            </div>
                            <div class="desc d-flex justify-content-between mb-3">
                                <p class="fs-14 text-secondary mb-0">@lang('web.web_jobs.founded_in'):</p>
                                <p class="fs-14 text-gray text-end mb-0">{{!empty($companyDetail->established_in)? $companyDetail->established_in : __('messages.n/a')}}</p>
                            </div>
                            <div class="desc d-flex justify-content-between mb-3">
                                <p class="fs-14 text-secondary mb-0">@lang('web.common.email'):</p>
                                <a href="#" class="fs-14 text-gray text-end">{{ $companyDetail->user->email }}</a>
                            </div>
                            <div class="desc d-flex justify-content-between">
                                <p class="fs-14 text-secondary mb-0">@lang('web.common.location'):</p>
                                <p class="fs-14 text-gray text-end mb-0">{{!empty($companyDetail->location)? $companyDetail->location : __('messages.n/a')}}
                                    @empty($companyDetail->location2)
                                        {{ $companyDetail->location2 }}
                                    @endempty
                                </p>
                            </div>
                        </div>
                        @if (isset($companyDetail->user->facebook_url) ||
                                isset($companyDetail->user->twitter_url) ||
                                isset($companyDetail->user->pinterest_url) ||
                                isset($companyDetail->user->google_plus_url) ||
                                isset($companyDetail->user->linkedin_url))
                            <div class="about-company-right company-details-social-media mt-5 br-10 px-40 bg-light">
                                <p class="fs-18 text-secondary">@lang('web.web_company.social_media')</p>
                                <div class="mt-3">
                                    @if (isset($companyDetail->user->facebook_url))
                                        <a href="{{ isset($companyDetail->user->facebook_url) ? addLinkHttpUrl($companyDetail->user->facebook_url) : 'javascript:void(0)' }}"
                                            class="ms-2" target="_blank">
                                            <i class="fa-brands fa-facebook-f fs-3 mx-2"></i></a>
                                    @endif
                                    @if (isset($companyDetail->user->linkedin_url))
                                        <a href="{{ isset($companyDetail->user->linkedin_url) ? addLinkHttpUrl($companyDetail->user->linkedin_url) : 'javascript:void(0)' }}"
                                            class="ms-2" target="_blank">
                                            <i class="fa-brands fa-linkedin-in fs-3 mx-2"></i></a>
                                    @endif
                                    @if (isset($companyDetail->user->twitter_url))
                                        <a href="{{ isset($companyDetail->user->twitter_url) ? addLinkHttpUrl($companyDetail->user->twitter_url) : 'javascript:void(0)' }}"
                                            class="ms-2" target="_blank">
                                            <i class="fa-brands fa-twitter fs-3 mx-2"></i></a>
                                    @endif
                                    @if (isset($companyDetail->user->google_plus_url))
                                        <a href="{{ isset($companyDetail->user->google_plus_url) ? addLinkHttpUrl($companyDetail->user->google_plus_url) : 'javascript:void(0)' }}"
                                            class="ms-2" target="_blank">
                                            <i class="fa-brands fa-google-plus-g fs-3 mx-2"></i></a>
                                    @endif
                                    @if (isset($companyDetail->user->pinterest_url))
                                        <a href="{{ isset($companyDetail->user->pinterest_url) ? addLinkHttpUrl($companyDetail->user->pinterest_url) : 'javascript:void(0)' }}"
                                            class="ms-2" target="_blank">
                                            <i class="fa-brands fa-pinterest-p fs-3 mx-2"></i></a>
                                    @endif
                                </div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <!-- end about-comapany section -->
        {{-- @role('Candidate') --}}
            @include('front_web.company.report_to_company_modal')
        {{-- @endrole --}}
        <!-- end about-comapany section -->
        {{ Form::hidden('isCompanyAddedToFavourite', $isCompanyAddedToFavourite, ['id' => 'isCompanyAddedToFavourite']) }}
        {{ Form::hidden('followText', __('web.company_details.follow'), ['id' => 'followText']) }}
        {{ Form::hidden('unfollowText', __('web.company_details.unfollow'), ['id' => 'unfollowText']) }}
    </div>
@endsection
{{-- @section('page_scripts') --}}
{{--    <script> --}}
{{-- let addCompanyFavouriteUrl = "{{ route('save.favourite.company') }}" --}}
{{-- let isCompanyAddedToFavourite = "{{ $isCompanyAddedToFavourite }}" --}}
{{-- let reportToCompanyUrl = "{{ route('report.to.company') }}" --}}
{{-- let followText = "{{ __('web.company_details.follow') }}" --}}
{{-- let unfollowText = "{{ __('web.company_details.unfollow') }}" --}}
{{--    </script> --}}
{{-- @endsection --}}
