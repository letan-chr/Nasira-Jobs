{{-- <div class="col-4 px-xl-3 mb-20 ">
    <div class="card last-jobs-card border-left-color">
        <div class="position-absolute top-0 end-0 mt-3">
            @if ($company->activeFeatured)
                <div class="col-md-1 col-sm-1 col-8 justify-content-end bookmark-icon position-relative pe-0 float-end d-flex">
                    <i class="text-primary fa-solid fa-bookmark"></i>
                </div>
            @else
                <div class="col-md-1 col-sm-1 col-8 bookmark-icon justify-content-end position-relative pe-0 float-end d-flex text-gray">
                    <i class="fa-regular fa-bookmark"></i>
                </div>
            @endif
        </div>
        <div class="row d-flex flex-xl-column align-items-center">
            <div class="col-3">
                <img src="{{ $company->company_url }}" class="card-img img-border" alt="">
            </div>
            <div class="col-9 px-3">
                <div class="card-body p-0">
                    <a href="{{ route('front.company.details', $company->unique_id) }}"
                       class="text-secondary primary-link-hover">
                        <h5 class="card-title   fs-20 mb-0">
                            {{ $company->user->first_name }}</h5>
                    </a>
                    <div class="d-flex">
                        @if (!empty($company->location) || !empty($company->location2))
                            <div class="desc location-text d-flex">
                                <i class="fa-solid fa-location-dot  me-1 mt-1 fs-18"></i>
                                <span class="">
                                 {{ $company->user->city_name.', '.$company->user->country_name }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @php
            $open_jobs = $company->jobs->where('status', App\Models\Job::STATUS_OPEN)->count()
        @endphp
            @if ($open_jobs <= 0)
                <div class="card-desc mt-3">
                    <div class="desc d-flex mt-2">
                        <p class="jobs-position bg-gray fs-14 mb-0 me-3 text-secondary">
                            {{ __('web.no_positions') }}
                        </p>
                    </div>
                </div>
            @else
                <div class="card-desc mt-3">
                    <div class="desc  d-flex mt-2">
                        <a href="{{ route('front.company.details', $company->unique_id) }}"
                           class="jobs-position  fs-14 mb-0 me-3">
                            {{ $open_jobs }} {{__('web.open_positions')}}
                        </a>
                    </div>
                </div>
            @endif

    </div>
</div> --}}

{{-- <div class="col-lg-4 col-md-6 px-xl-3 mb-40">
    <div class="card py-30">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="me-4">
                    <img src="{{ $company->company_url }}" class="card-img" alt="..." />
                </div>
                <div class="">
                    <a href="{{ route('front.company.details', $company->unique_id) }}"
                        class="text-secondary primary-link-hover" >
                        <div class="card-body p-0">
                            <h5 class="card-title fs-18 mb-0">{{ $company->user->first_name }}</h5>
                        </div>
                    </a>
                </div>
            </div>
            <div class="icon position-relative pe-0">
                <i class="text-primary fa-solid fa-bookmark"></i>
            </div>
        </div>
        <div class="card-desc d-flex flex-column justify-content-between h-100 mt-4">
            <div class="desc">
                <div class="d-flex mb-1">
                    @if (!empty($company->location) || !empty($company->location2))
                        <div class="desc location-text d-flex">
                            <div class="me-3 w-20">
                                <i class="fa-solid fa-location-dot  me-1 mt-1 fs-18"></i>
                            </div>
                            <p class="fs-14 text-gray mb-0">
                                {{ $company->user->city_name . ', ' . $company->user->country_name }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="desc d-flex">
                @php
                    $open_jobs = $company->jobs->where('status', App\Models\Job::STATUS_OPEN)->count();
                @endphp
                @if ($open_jobs <= 0)
                    <p class="jobs-position text text-primary fs-14 mb-0 me-3">
                        {{ __('web.no_positions') }}
                    </p>
                @else
                    <a href="{{ route('front.company.details', $company->unique_id) }}"
                        class="jobs-position text text-primary fs-14 mb-0 me-3">
                        {{ $open_jobs }} {{ __('web.open_positions') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div> --}}

{{-- @dd($company) --}}

<div class="col-lg-4 col-md-6 px-xl-3 mb-40">
    <div class="card py-30">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                    <img src="{{ $company->company_url }}" class="card-img" alt="..." />
                </div>
                <div class="">
                    <div class="card-body p-0">
                        <a href="{{ route('front.company.details', $company->unique_id) }}"
                            class="text-secondary primary-link-hover">
                            <h5 class="card-title fs-18 mb-0">
                                {{ $company->user->first_name }}</h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-desc d-flex flex-column justify-content-between h-100 mt-4">
            <div class="desc">
                @if (!empty($company->location) || !empty($company->location2))
                    <div class="d-flex mb-2">
                        <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                            <img src="{{ asset('img_template/briefcase.svg') }}" class="w-100" />
                        </div>

                        <p class="fs-14 text-gray mb-0">
                            {{ $company->industry->name }}
                        </p>
                    </div>
                @endif
                @if (!empty($company->industry->name))
                    <div class="d-flex mb-2">
                        <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} w-20">
                            <img src=" {{ asset('img_template/location.svg') }} " class="w-100" />
                        </div>
                        <p class="fs-14 text-gray mb-0">
                            {{ $company->user->city_name . ', ' . $company->user->country_name }}
                        </p>
                    </div>
                @endif
            </div>

            @php
                $open_jobs = $company->jobs->where('status', App\Models\Job::STATUS_OPEN)->count();
            @endphp
            <div class="desc d-flex">
                @if ($open_jobs <= 0)
                <p class="text text-primary fs-14 mb-0 me-3">
                    {{ __('web.no_positions') }}
                </p>
            @else
                <a href="{{ route('front.company.details', $company->unique_id) }}"
                    class="text text-primary fs-14 mb-0 me-3">
                    {{  __('web.home_menu.opened_jobs') }} {{'-'}} {{ $open_jobs }}
                </a>
            @endif
            </div>
        </div>
    </div>
</div>
