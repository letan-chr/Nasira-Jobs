@extends('front_web.layouts.app')
@section('title')
    {{ __('messages.candidate.candidate_details') }}
@endsection
{{-- @section('page_css') --}}
{{--    <link href="{{asset('front_web/scss/candidate-details.css')}}" rel="stylesheet" type="text/css"> --}}
{{-- @endsection --}}
{{-- @dd($candidateDetails) --}}
@section('content')
    {{-- <section class="hero-section position-relative bg-color py-40">
        <div class="container">
            <div class="row align-items-center justify-content-center ">
                <div class="col-12">
                    <div class="row align-items-lg-center mb-3">
                        <div class="col-lg-1 col-sm-2 col-3">
                            <div class="candidate-profile-img mt-md-0 mt-3">
                                <img
                                        src="{{ (!empty($candidateDetails->user->avatar)) ? $candidateDetails->user->avatar : asset('assets/img/infyom-logo.png') }}"
                                        alt="candidate profile">
                            </div>
                        </div>
                        <div class="col-sm-10 col-9">
                            <div class="hero-content ps-xl-0 ps-3">
                                <h4 class="text-secondary mb-0">
                                    {{ html_entity_decode($candidateDetails->user->full_name) }}
                                </h4>
                                <div class="hero-desc d-flex align-items-center flex-wrap">
                                    <div class="d-flex align-items-center me-4 pe-2">
                                        <i class="fa-solid fa-briefcase text-gray me-3 fs-18"></i>
                                        <p class="fs-14 text-gray mb-0">
                                            {{!empty($candidateDetails->functionalArea->name)? $candidateDetails->functionalArea->name : __('messages.common.n/a')}}</p>
                                    </div>

                                    @if (!empty($candidateDetails->user->country_name))
                                        <div class="desc d-flex align-items-center me-lg-4 me-2 pe-2">
                                            <i class="fa-solid fa-location-dot text-gray me-3 fs-18"></i>
                                            <p class="fs-14 text-gray mb-0">
                                                    <span>{{$candidateDetails->user->country_name}}
                                                        @if (!empty($candidateDetails->user->state_name))
                                                            ,{{$candidateDetails->user->state_name }}
                                                        @endif
                                                        @if (!empty($candidateDetails->user->city_name))
                                                            ,{{$candidateDetails->user->city_name}}
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                    <div class="desc d-flex align-items-center me-lg-4 me-2 pe-2">
                                        <i class="fa-solid fa-envelope text-gray me-3 fs-18"></i>
                                        <p class="fs-14 text-gray mb-0">
                                            {{$candidateDetails->user->email}}
                                        </p>
                                    </div>
                                    @if ($candidateDetails->user->dob)
                                        <div class="desc d-flex align-items-center me-lg-4 me-2 pe-2">
                                            <i class="fa-solid fa-location-dot text-gray me-3 fs-18"></i>
                                            <p class="fs-14 text-gray mb-0">
                                                {{ \Carbon\Carbon::parse($candidateDetails->user->dob)->translatedFormat('jS M, Y') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-wrap">
                            @auth
                                @role('Employer')
                                <ul class="post-tags mt-3 ps-0">
                                    @if ($isReportedToCandidate)
                                        <button class="btn btn-outline-danger reportToCompany reportToCandidate" disabled
                                        >{{ __('messages.candidate.already_reported') }}</button>
                                    @else
                                        <button type="button" class="btn btn-outline-danger reportToCompany reportToCandidate"
                                                data-bs-toggle="modal"
                                                data-bs-target="#reportToCandidateModal">
                                            {{ __('messages.candidate.reporte_to_candidate') }}
                                        </button>
                                    @endif
                                </ul>
                                @endrole
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-company-section py-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5">
                        <h5 class="fs-4 text-secondary mb-4">{{__('messages.candidate_profile.education')}}</h5>
                        <div class="job-description">
                            @forelse($candidateEducations as $candidateEducation)
                                <div class="job-description-block pb-3">
                                    <span class="name">{{ucfirst($candidateEducation->degreeLevel->name[0])}}</span>
                                    <div class="job-description-right">
                                        <h5 class="fs-18 text-gary mb-0">{{$candidateEducation->degreeLevel->name}}</h5>
                                        <span class="text-primary"> {{ucfirst($candidateEducation->institute)}}</span>
                                        <span class="badge bg-secondary">{{ $candidateEducation->year }}</span>
                                    </div>
                                </div>
                            @empty
                                <h4 class="text-center">{{ __('messages.candidate.education_not_found') }}</h4>
                            @endforelse
                        </div>
                    </div>
                    <div>
                        <h5 class="fs-4 text-secondary mb-4">{{__('messages.candidate_profile.work_experience')}}</h5>
                        <div class="job-description">
                            @forelse($candidateExperiences as $candidateExperience)
                                <div class="job-description-block pb-3">
                                    <span class="name">{{ucfirst($candidateExperience->experience_title[0])}}</span>
                                    <div class="job-description-right">
                                        <div class="info-box">
                                            <h5 class="fs-18 text-gary mb-0">{{$candidateExperience->experience_title}}</h5>
                                            <span class="text-primary">{{ucfirst($candidateExperience->company)}}</span>
                                            <span class="badge bg-secondary"> {{ \Carbon\Carbon::parse($candidateExperience->start_date)->format('Y') }} - {{($candidateExperience->currently_working) ? 'present' : \Carbon\Carbon::parse($candidateExperience->end_date)->format('Y') }}</span>
                                        </div>
                                    </div>
                                    @if (!empty($candidateExperience->description))
                                        <div class="mt-2">{!! Str::limit(nl2br(e($candidateExperience->description)),300,'...') !!}</div>
                                    @endif
                                </div>
                            @empty
                                <h4 class="text-center">{{ __('messages.candidate.experience_not_found') }}</h4>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('front_web.candidate.candidate_detail_sidebar')
                </div>
            </div>
        </div>
    </section> --}}

    <section class="hero-section position-relative bg-gradient pt-15 pb-40">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12">
                    <div class="d-flex align-items-md-center">
                        <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                            <div class="hero-img">
                                <img src="{{ !empty($candidateDetails->user->avatar) ? $candidateDetails->user->avatar : asset('assets/img/infyom-logo.png') }}"
                                    class="w-100 h-100 rounded-circle object-fit-cover" alt="company-details" />
                            </div>
                        </div>
                        <div class="">
                            <div class="hero-content">
                                <h4 class="text-secondary lh-base mb-2">
                                    {{ html_entity_decode($candidateDetails->user->full_name) }}</h4>
                                <div class="hero-desc d-md-flex">
                                    <div class="desc d-flex {{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                        <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                            <img src="{{ asset('img_template/briefcase.svg') }}" class="w-100" />
                                        </div>
                                        <p class="fs-14 text-gray mb-0">
                                            {{ !empty($candidateDetails->functionalArea->name) ? $candidateDetails->functionalArea->name : __('messages.n/a') }}
                                        </p>
                                    </div>
                                    @if (!empty($candidateDetails->user->country_name))
                                        <div class="desc d-flex {{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                <img src="{{ asset('img_template/location.svg') }}" class="w-100">
                                            </div>
                                            <p class="fs-14 text-gray mb-0">
                                                @if (!empty($candidateDetails->user->state_name))
                                                    ,{{ $candidateDetails->user->state_name }}
                                                @endif
                                                @if (!empty($candidateDetails->user->city_name))
                                                    ,{{ $candidateDetails->user->city_name }}
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                    <div class="desc d-flex {{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                        <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M20.9062 4.78125H1.09375C0.650389 4.78125 0.28125 5.15039 0.28125 5.59375V16.4062C0.28125 16.8496 0.650389 17.2188 1.09375 17.2188H20.9062C21.3496 17.2188 21.7188 16.8496 21.7188 16.4062V5.59375C21.7188 5.15039 21.3496 4.78125 20.9062 4.78125ZM1.5 5.59375L11 11.4688L20.5 5.59375V16.4062H1.5V5.59375ZM11 9.53125L1.96875 4.78125H20.0312L11 9.53125Z"
                                                    fill="#777a7c" />
                                            </svg>

                                        </div>
                                        <a href="#" class="fs-14 text-gray text-break">{{ $candidateDetails->user->email }}</a>
                                    </div>
                                    @if ($candidateDetails->user->dob)
                                        <div class="desc d-flex {{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.3125 1.75H4.6875C3.90381 1.75 3.25 2.40381 3.25 3.1875V18.8125C3.25 19.5962 3.90381 20.25 4.6875 20.25H17.3125C18.0962 20.25 18.75 19.5962 18.75 18.8125V3.1875C18.75 2.40381 18.0962 1.75 17.3125 1.75ZM17.125 18.8125C17.125 19.0089 16.9767 19.1616 16.7803 19.1616H5.21967C5.02331 19.1616 4.875 19.0089 4.875 18.8125V15.125H17.125V18.8125ZM17.125 13.4375H4.875V6.4375H17.125V13.4375ZM7.8125 9.75C7.59811 9.75 7.4375 9.91061 7.4375 10.125V11.0625C7.4375 11.2769 7.59811 11.4375 7.8125 11.4375H8.75C8.96439 11.4375 9.125 11.2769 9.125 11.0625V10.125C9.125 9.91061 8.96439 9.75 8.75 9.75H7.8125ZM11.3125 9.75C11.0981 9.75 10.9375 9.91061 10.9375 10.125V11.0625C10.9375 11.2769 11.0981 11.4375 11.3125 11.4375H12.25C12.4644 11.4375 12.625 11.2769 12.625 11.0625V10.125C12.625 9.91061 12.4644 9.75 12.25 9.75H11.3125ZM15.25 9.75C15.0356 9.75 14.875 9.91061 14.875 10.125V11.0625C14.875 11.2769 15.0356 11.4375 15.25 11.4375H16.1875C16.4019 11.4375 16.5625 11.2769 16.5625 11.0625V10.125C16.5625 9.91061 16.4019 9.75 16.1875 9.75H15.25Z" fill="#777A7C"/>
                                                </svg>

                                            </div>
                                            <p class="fs-14 text-gray mb-0">
                                                {{ \Carbon\Carbon::parse($candidateDetails->user->dob)->translatedFormat('jS M, Y') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="job-details-section py-60 mb-sm-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="Job Description mb-lg-5 mb-4">
                        <h5 class="fs-18 text-secondary mb-4">{{ __('messages.candidate_profile.education') }}</h5>
                        <div class="job-description">
                            @forelse($candidateEducations as $candidateEducation)
                                <div class="job-description-block pb-3">
                                    <div class="job-description-right">
                                        <h5 class="fs-18 text-gary mb-0">{{ $candidateEducation->degreeLevel->name }}</h5>
                                        <span class="text-gray"> {{ ucfirst($candidateEducation->institute) }}</span>
                                        <span class="badge bg-primary">{{ $candidateEducation->year }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12 text-center text-gray">
                                    {{ __('messages.candidate.education_not_found') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="key-responsibilities mb-lg-5 mb-4">
                        <h5 class="fs-18 text-secondary mb-4">{{ __('messages.candidate_profile.work_experience') }}</h5>
                        @forelse($candidateExperiences as $candidateExperience)
                            <div class="job-description-block pb-3">
                                <div class="job-description-right">
                                    <div class="info-box">
                                        <h5 class="fs-18 text-gary mb-3">{{ $candidateExperience->experience_title }}
                                        </h5>
                                        <span class="text-gray">{{ ucfirst($candidateExperience->company) }}</span>
                                        <span class="badge bg-primary">
                                            {{ \Carbon\Carbon::parse($candidateExperience->start_date)->format('Y') }}
                                            -
                                            {{ $candidateExperience->currently_working ? 'present' : \Carbon\Carbon::parse($candidateExperience->end_date)->format('Y') }}</span>
                                    </div>
                                </div>
                                @if (!empty($candidateExperience->description))
                                    <div class="mt-2">{!! Str::limit(nl2br(e($candidateExperience->description)), 300, '...') !!}</div>
                                @endif
                            </div>
                        @empty
                            <div class="col-md-12 text-center text-gray">
                                {{ __('messages.candidate.experience_not_found') }}
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('front_web.candidate.candidate_detail_sidebar')
                </div>
            </div>
        </div>
    </section>
    <!-- end hero section -->
    @role('Employer')
        @include('front_web.candidate.report_to_candidate_modal')
    @endrole
@endsection
{{-- @section('scripts') --}}
{{--    <script> --}}
{{--        let reportToCandidateUrl = "{{ route('report.to.candidate') }}" --}}
{{--    </script> --}}
{{-- @endsection --}}
