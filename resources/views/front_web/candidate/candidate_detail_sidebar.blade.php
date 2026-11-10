{{-- <div class="job-desc-right br-10 px-40 bg-gray mb-40 mt-lg-0 mt-md-5 mt-4"> --}}
{{--    <div class="desc-box d-flex justify-content-between mb-2"> --}}
{{--        <div class="d-flex align-items-center mb-3"> --}}
{{--            <i class="fa-solid fa-calendar-days text-primary me-2 fs-18"></i> --}}
{{--            <p class="fs-14 text-secondary mb-0"> --}}
{{--                {{__('messages.candidate_profile.education')}}:</p> --}}
{{--        </div> --}}
{{--        <p class="fs-14 text-gray text-end"> --}}
{{--           {{!empty($candidateDetails->experience) ? $candidateDetails->experience.  ' '.__('messages.candidate_profile.years') : __('messages.common.n/a')}} </p> --}}
{{--    </div> --}}

{{--    @if ($candidateDetails->user->dob) --}}
{{--        <div class="desc-box d-flex justify-content-between mb-2"> --}}
{{--            <div class="d-flex align-items-center mb-3"> --}}
{{--                <i class="fa-solid fa-clock text-primary me-2 fs-18"></i> --}}
{{--                <p class="fs-14 text-secondary mb-0"> --}}
{{--                    <i class="icon icon-expiry"></i>{{__('messages.candidate_profile.age')}}:</p> --}}
{{--            </div> --}}
{{--            <p class="fs-14 text-gray text-end"> --}}
{{--                {{!empty($candidateDetails->user->dob) ?\Carbon\Carbon::parse($candidateDetails->user->dob)->age. ' '.__('messages.candidate_profile.years') : __('messages.common.n/a')}} --}}
{{--            </p> --}}
{{--        </div> --}}
{{--    @endif --}}
{{--    <div class="desc-box d-flex justify-content-between mb-2"> --}}
{{--        <div class="d-flex align-items-center mb-3"> --}}
{{--            <i class="fa-solid fa-location-dot text-primary me-2 fs-18"></i> --}}
{{--            <p class="fs-14 text-secondary mb-0">{{__('messages.candidate.current_salary')}}:</p> --}}
{{--        </div> --}}
{{--        <p class="fs-14 text-gray text-end"> --}}
{{--            {{ !empty($candidateDetails->current_salary) ? $candidateDetails->current_salary : __('messages.common.n/a')}} --}}
{{--        </p> --}}
{{--    </div> --}}
{{--    <div class="desc-box d-flex justify-content-between mb-2"> --}}
{{--        <div class="d-flex align-items-center mb-3"> --}}
{{--            <i class="fa-solid fa-briefcase text-primary me-2 fs-18"></i> --}}
{{--            <p class="fs-14 text-secondary mb-0"> <i class="icon icon-salary"></i>{{__('messages.candidate.expected_salary')}}:</p> --}}
{{--        </div> --}}
{{--        <p class="fs-14 text-gray text-end"> --}}
{{--            {{ !empty($candidateDetails->expected_salary) ? $candidateDetails->expected_salary : __('messages.common.n/a') }}</p> --}}
{{--    </div> --}}

{{--        <div class="desc-box d-flex justify-content-between mb-2"> --}}
{{--            <div class="d-flex align-items-center mb-3"> --}}
{{--                <i class="fa-solid fa-briefcase text-primary me-2 fs-18"></i> --}}
{{--                <p class="fs-14 text-secondary mb-0"> <i class="icon icon-salary"></i><i class="icon icon-user-2"></i>{{__('messages.candidate.gender')}}:</p> --}}
{{--            </div> --}}
{{--            <p class="fs-14 text-gray text-end"> --}}
{{--                @if ($candidateDetails->user->gender == 0) --}}
{{--                    {{ __('messages.common.male')}} --}}
{{--                @elseif($candidateDetails->user->gender == 1) --}}
{{--                    {{ __('messages.common.female')}} --}}
{{--                @else --}}
{{--                    {{ __('messages.common.n/a')}} --}}
{{--                @endif --}}
{{--               </p> --}}
{{--        </div> --}}
{{--    @if (!empty($candidateDetails->user->facebook_url) || !empty($candidateDetails->user->twitter_url) || !empty($candidateDetails->user->google_plus_url) || !empty($candidateDetails->user->pinterest_url) || !empty($candidateDetails->user->linkedin_url)) --}}
{{--        <div class="sidebar-widget social-media-widget"> --}}
{{--            <h4 class="widget-title">{{__('messages.social_media')}}</h4> --}}
{{--            <div class="widget-content"> --}}
{{--                <div class="social-links"> --}}
{{--                    @if (!empty($candidateDetails->user->facebook_url)) --}}
{{--                        <a href="{{ (isset($candidateDetails->user->facebook_url)) ? addLinkHttpUrl($candidateDetails->user->facebook_url) : 'javascript:void(0)' }}" --}}
{{--                           target="_blank"><i class="fab fa-facebook-f me-2"></i></a> --}}
{{--                    @endif --}}
{{--                    @if (!empty($candidateDetails->user->twitter_url)) --}}
{{--                        <a href="{{ (isset($candidateDetails->user->twitter_url)) ? addLinkHttpUrl($candidateDetails->user->twitter_url) : 'javascript:void(0)' }}" --}}
{{--                           target="_blank"><i class="fab fa-twitter me-2"></i></a> --}}
{{--                    @endif --}}
{{--                    @if (!empty($candidateDetails->user->google_plus_url)) --}}
{{--                        <a href="{{ (isset($candidateDetails->user->google_plus_url)) ? addLinkHttpUrl($candidateDetails->user->google_plus_url) : 'javascript:void(0)' }}" --}}
{{--                           target="_blank"><i class="fab fa-google-plus-g me-2"></i></a> --}}
{{--                    @endif --}}
{{--                    @if (!empty($candidateDetails->user->pinterest_url)) --}}
{{--                        <a href="{{ (isset($candidateDetails->user->pinterest_url)) ? addLinkHttpUrl($candidateDetails->user->pinterest_url) : 'javascript:void(0)' }}" --}}
{{--                           target="_blank"><i class="fab fa-pinterest-p me-2"></i></a> --}}
{{--                    @endif --}}
{{--                    @if (!empty($candidateDetails->user->linkedin_url)) --}}
{{--                        <a href="{{ (isset($candidateDetails->user->linkedin_url)) ? addLinkHttpUrl($candidateDetails->user->linkedin_url) : 'javascript:void(0)' }}" --}}
{{--                           target="_blank"><i class="fab fa-linkedin-in me-2"></i></a> --}}
{{--                    @endif --}}
{{--                </div> --}}
{{--            </div> --}}
{{--        </div> --}}
{{--    @endif --}}
{{-- </div> --}}

{{-- <div class="job-desc-right br-10 px-40 bg-gray mb-40 mt-lg-0 mt-md-5 mt-4"> --}}

{{-- <div class="sidebar-widget"> --}}
{{--    <h4 class="widget-title">{{__('messages.professional_skills')}}</h4> --}}
{{--    <div class="widget-content"> --}}
{{--        <ul class="job-skills ps-0"> --}}
{{--            @if ($candidateDetails->user->candidateSkill->count()) --}}
{{--                @foreach ($candidateDetails->user->candidateSkill as $candidateSkill) --}}
{{--                    <li> --}}
{{--                        <a class="text-hover-primary text-gray cursor-default">{{ html_entity_decode($candidateSkill->name) }}</a> --}}
{{--                    </li> --}}
{{--                @endforeach --}}
{{--            @else --}}
{{--                <h4 class="text-center">{{ __('messages.skill.no_skill_available') }}</h4> --}}
{{--            @endif --}}
{{--        </ul> --}}
{{--    </div> --}}
{{-- </div> --}}
{{-- </div> --}}


{{-- <div class="col-12">
    <div class="col-12 mb-40">
        <div class="job-card card py-30">
            <div class="row d-flex justify-content-lg-between">
                <div class="col-5 mt-3">
                    <i class="fa-solid fa-calendar-days text-primary fs-4"></i>
                    <p class="details-page-card-text mb-0" >
                        {{__('messages.candidate_profile.education')}}</p>
                    <p class="text-secondary fs-14">
                        {{!empty($candidateDetails->experience) ? $candidateDetails->experience.  ' '.__('messages.candidate_profile.years') : __('messages.common.n/a')}}
                    </p>
                </div>
                @if ($candidateDetails->user->dob)
                    <div class="col-5 mt-3">
                        <i class="fa-solid fa-cake-candles text-primary fs-4"></i>
                        <p class="details-page-card-text mb-0" >
                            {{__('messages.candidate_profile.age')}}</p>
                        <p class="text-secondary fs-14">
                            {{!empty($candidateDetails->user->dob) ?\Carbon\Carbon::parse($candidateDetails->user->dob)->age. ' '.__('messages.candidate_profile.years') : __('messages.common.n/a')}}
                        </p>
                    </div>
                @endif
                <div class="col-5 mt-3">
                    <i class="fa-solid fa-wallet text-primary fs-4"></i>
                    <p class="details-page-card-text mb-0" >
                        {{__('messages.candidate.current_salary')}}</p>
                    <p class="text-secondary fs-14">
                        {{ !empty($candidateDetails->current_salary) ? $candidateDetails->current_salary : __('messages.common.n/a')}}
                    </p>
                </div>
                <div class="col-5 mt-3">
                    <i class="fa-solid fa-wallet text-primary fs-4"></i>
                    <p class="details-page-card-text mb-0" >
                        {{__('messages.candidate.expected_salary')}}</p>
                    <p class="text-secondary fs-14">
                        {{ !empty($candidateDetails->expected_salary) ? $candidateDetails->expected_salary : __('messages.common.n/a') }}
                    </p>
                </div>
                <div class="col-5 mt-3">
                    <i class="fa-solid fa-venus text-primary fs-4"></i>
                    <p class="details-page-card-text mb-0" >
                        {{__('messages.candidate.gender')}}</p>
                    <p class="text-secondary fs-14">
                        @if ($candidateDetails->user->gender == 0)
                            {{ __('messages.common.male')}}
                        @elseif($candidateDetails->user->gender == 1)
                            {{ __('messages.common.female')}}
                        @else
                            {{ __('messages.common.n/a')}}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@if (!empty($candidateDetails->user->facebook_url) || !empty($candidateDetails->user->twitter_url) || !empty($candidateDetails->user->google_plus_url) || !empty($candidateDetails->user->pinterest_url) || !empty($candidateDetails->user->linkedin_url))
<div class="col-12">
    <div class="col-12 mb-40">
        <div class="job-card card py-30">
            <div class="row d-flex justify-content-lg-between">
                <p class="fs-18 text-secondary">@lang('web.web_company.social_media')</p>
                <div class="mt-3">
                    @if (!empty($candidateDetails->user->facebook_url))
                        <a href="{{ (isset($candidateDetails->user->facebook_url)) ? addLinkHttpUrl($candidateDetails->user->facebook_url) : 'javascript:void(0)' }}" target="_blank"><i class="fab fa-facebook-f mx-2 fs-3"></i></a>
                    @endif
                    @if (!empty($candidateDetails->user->twitter_url))
                        <a href="{{ (isset($candidateDetails->user->twitter_url)) ? addLinkHttpUrl($candidateDetails->user->twitter_url) : 'javascript:void(0)' }}"
                           target="_blank"><i class="fab fa-twitter mx-2 fs-3"></i></a>
                    @endif
                    @if (!empty($candidateDetails->user->google_plus_url))
                        <a href="{{ (isset($candidateDetails->user->google_plus_url)) ? addLinkHttpUrl($candidateDetails->user->google_plus_url) : 'javascript:void(0)' }}"
                           target="_blank"><i class="fab fa-google-plus-g mx-2 fs-3"></i></a>
                    @endif
                    @if (!empty($candidateDetails->user->pinterest_url))
                        <a href="{{ (isset($candidateDetails->user->pinterest_url)) ? addLinkHttpUrl($candidateDetails->user->pinterest_url) : 'javascript:void(0)' }}"
                           target="_blank"><i class="fab fa-pinterest-p mx-2 fs-3"></i></a>
                    @endif
                    @if (!empty($candidateDetails->user->linkedin_url))
                        <a href="{{ (isset($candidateDetails->user->linkedin_url)) ? addLinkHttpUrl($candidateDetails->user->linkedin_url) : 'javascript:void(0)' }}"
                           target="_blank"><i class="fab fa-linkedin-in mx-2 fs-3"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="col-12">
    <div class="col-12 mb-40">

        <div class="job-card card py-30">
            <p class="fs-18 text-secondary">{{__('messages.professional_skills')}}</p>
            <div class="row d-flex justify-content-lg-between">
                @if ($candidateDetails->user->candidateSkill->count())
                    @foreach ($candidateDetails->user->candidateSkill as $candidateSkill)
                        <li>
                            <a class="text-hover-primary text-gray cursor-default">{{ html_entity_decode($candidateSkill->name) }}</a>
                        </li>
                    @endforeach
                @else
                    <h4 class="text-center">{{ __('messages.skill.no_skill_available') }}</h4>
                @endif
            </div>
        </div>
    </div>
</div> --}}

<div class="job-desc-right br-10 px-40 bg-light mb-40">
    <div class="pb-2">
        <div class="desc-box d-flex justify-content-between mb-4">
            <div class="desc d-flex">
                <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-2' : 'me-2' }} w-20">
                    <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5 12C4.71667 12 4.479 11.904 4.287 11.712C4.09567 11.5207 4 11.2833 4 11C4 10.7167 4.09567 10.479 4.287 10.287C4.479 10.0957 4.71667 10 5 10C5.28333 10 5.521 10.0957 5.713 10.287C5.90433 10.479 6 10.7167 6 11C6 11.2833 5.90433 11.5207 5.713 11.712C5.521 11.904 5.28333 12 5 12ZM9 12C8.71667 12 8.47933 11.904 8.288 11.712C8.096 11.5207 8 11.2833 8 11C8 10.7167 8.096 10.479 8.288 10.287C8.47933 10.0957 8.71667 10 9 10C9.28333 10 9.521 10.0957 9.713 10.287C9.90433 10.479 10 10.7167 10 11C10 11.2833 9.90433 11.5207 9.713 11.712C9.521 11.904 9.28333 12 9 12ZM13 12C12.7167 12 12.4793 11.904 12.288 11.712C12.096 11.5207 12 11.2833 12 11C12 10.7167 12.096 10.479 12.288 10.287C12.4793 10.0957 12.7167 10 13 10C13.2833 10 13.5207 10.0957 13.712 10.287C13.904 10.479 14 10.7167 14 11C14 11.2833 13.904 11.5207 13.712 11.712C13.5207 11.904 13.2833 12 13 12ZM2 20C1.45 20 0.979 19.8043 0.587 19.413C0.195667 19.021 0 18.55 0 18V4C0 3.45 0.195667 2.97933 0.587 2.588C0.979 2.196 1.45 2 2 2H3V0H5V2H13V0H15V2H16C16.55 2 17.021 2.196 17.413 2.588C17.8043 2.97933 18 3.45 18 4V18C18 18.55 17.8043 19.021 17.413 19.413C17.021 19.8043 16.55 20 16 20H2ZM2 18H16V8H2V18Z"
                            fill="#1967D2" />
                    </svg>
                </div>

                <p class="fs-14 text-secondary mb-0">{{ __('messages.candidate_profile.education') }}:</p>
            </div>
            <p class="fs-14 text-gray text-end mb-0">
                {{ !empty($candidateDetails->experience) ? $candidateDetails->experience . ' ' . __('messages.candidate_profile.years') : __('messages.n/a') }}
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
                <p class="fs-14 text-secondary mb-0">{{ __('messages.candidate.current_salary') }}:</p>
            </div>
            <p class="fs-14 text-gray text-end mb-0">
                {{ !empty($candidateDetails->current_salary) ? $candidateDetails->current_salary : __('messages.n/a') }}
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
                <p class="fs-14 text-secondary mb-0">{{ __('messages.candidate.expected_salary') }}:</p>
            </div>
            <p class="fs-14 text-gray text-end mb-0">
                {{ !empty($candidateDetails->expected_salary) ? $candidateDetails->expected_salary : __('messages.n/a') }}
            </p>
        </div>
        <div class="desc-box d-flex justify-content-between mb-4">
            <div class="desc d-flex">
                <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-2' : 'me-2' }} d-flex w-20">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" style="color: rgb(25, 103, 210)"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="5" r="3" />
                        <line x1="12" y1="12" x2="12" y2="19" />
                        <line x1="12" y1="19" x2="9" y2="22" />
                        <line x1="12" y1="19" x2="15" y2="22" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" style="color: rgb(25, 103, 210)"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="5" r="3" />
                        <line x1="12" y1="12" x2="12" y2="19" />
                        <line x1="12" y1="19" x2="9" y2="22" />
                        <line x1="12" y1="19" x2="15" y2="22" />
                        <circle cx="12" cy="5" r="1" />
                    </svg>
                </div>
                <p class="fs-14 text-secondary mb-0">{{ __('messages.candidate.gender') }}:</p>
            </div>
            <p class="fs-14 text-gray text-end mb-0">
                @if ($candidateDetails->user->gender == 0)
                    {{ __('messages.common.male') }}
                @elseif($candidateDetails->user->gender == 1)
                    {{ __('messages.common.female') }}
                @else
                    {{ __('messages.common.n/a') }}
                @endif
            </p>
        </div>
    </div>
    <div class="desc-box">
        <h5 class="fs-18 text-secondary mb-4">{{ __('messages.professional_skills') }}</h5>
        <div class="d-flex flex-wrap gap-3">
            @if ($candidateDetails->user->candidateSkill->count())
                    <ul>
                        @foreach ($candidateDetails->user->candidateSkill as $candidateSkill)
                            <li class="fs-14 text-gray py-2">
                                {{ html_entity_decode($candidateSkill->name) }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="fs-14 text-gray bg-white py-2 br-gray px-3">
                        {{ __('messages.skill.no_skill_available') }}</p>
                @endif
        </div>
    </div>
</div>
