@extends('front_web.layouts.app')
@section('title')
    {{ __('web.home') }}
@endsection
@section('page_css')
@endsection
@section('content')
    <div class="home-page">
        <!-- start Nasira hero section -->
        <section class="nasira-hero">
            <div class="nasira-hero-media" aria-hidden="true">
                <div class="nasira-hero-city"></div>
            </div>

            <div class="container nasira-hero-inner">
                <div class="nasira-hero-copy">
                    <p class="nasira-hero-brand">Nasira</p>
                    <h1 class="nasira-hero-title">Find work that fits your life</h1>
                    <p class="nasira-hero-sub">Search trusted jobs across Ethiopia and apply with confidence.</p>

                    <form class="nasira-search" action="{{ route('front.search.jobs') }}" id="searchForm" method="get">
                        <div class="nasira-search-field-wrap">
                            <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                            <input type="text" name="keywords" id="search-keywords"
                                placeholder="Job title, skill or company" autocomplete="off" />
                            <div id="jobsSearchResults" class="position-absolute w100 job-search"
                                style="display: none; left: 0; top: 100%; z-index: 20;">
                                <ul class="job-search-dropdown nav submenu"></ul>
                            </div>
                        </div>
                        <div class="nasira-search-field-wrap autocomplete-wrapper">
                            <i class="fa-solid fa-location-dot" aria-hidden="true"></i>
                            <input type="text" name="location" id="search-location" placeholder="Location" />
                        </div>
                        <button type="submit">
                            Search <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>

                <img src="{{ asset('front_web/images/nasira-person.png') }}" alt="" class="nasira-hero-person" />
            </div>
        </section>
        <!-- end Nasira hero section -->

        {{-- Partner / companies logo section (temporarily hidden)
        @if (count($branding) > 0)
            <section class="comapnies-logo-section my-5">
                <div class="container">
                    <div class="slick-slider" id="brandSlider">
                        @foreach ($branding as $brand)
                            <div class="slide d-flex justify-content-center align-items-center m-4">
                                <img src="{{ $brand->branding_slider_url }}" alt="Branding Slider" class="img-fluid" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        --}}

        {{-- Image slider (temporarily hidden for cleaner home flow)
        @if (count($imageSliders) > 0 && $imageSliderActive->value)
            <section class="{{ $slider->value == 0 ? 'container' : ' ' }} slider-test-section position-relative mb-80">
                ...
            </section>
        @endif
        --}}

        <!-- start-popular-job-categories-section -->
        @if (count($jobCategories) > 0)
            <section class="nasira-categories-section">
                <div class="container">
                    <div class="nasira-section-head">
                        <p class="nasira-section-kicker">Explore by field</p>
                        <h2>@lang('web.home_menu.popular_categories')</h2>
                        <p class="nasira-section-lead">Browse open roles by industry and find the path that matches your skills.</p>
                    </div>

                    <div class="nasira-cat-grid">
                        @foreach ($jobCategories as $jobCategory)
                            <a href="{{ route('front.search.jobs', ['categories' => $jobCategory->id]) }}"
                                class="nasira-cat-item">
                                <span class="nasira-cat-icon">
                                    <img src="{{ $jobCategory->image_url }}" alt="" />
                                </span>
                                <span class="nasira-cat-body">
                                    <strong>{{ html_entity_decode($jobCategory->name) }}</strong>
                                    <small>
                                        @if ($jobCategory->jobs_count <= 0)
                                            No open positions
                                        @else
                                            {{ $jobCategory->jobs_count }} open {{ $jobCategory->jobs_count == 1 ? 'position' : 'positions' }}
                                        @endif
                                    </small>
                                </span>
                                <i class="fa-solid fa-arrow-right nasira-cat-go" aria-hidden="true"></i>
                            </a>
                        @endforeach
                    </div>

                    <div class="nasira-section-actions">
                        <a href="{{ route('front.categories') }}" class="nasira-section-btn">
                            @lang('web.common.browse_all') <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </section>
        @endif
        <!-- end-popular-job-categories-section -->

        <!-- start latest-job-section -->
        @if (count($latestJobs) > 0)
            <section class="nasira-jobs-section">
                <div class="container">
                    <div class="nasira-section-head">
                        <p class="nasira-section-kicker">Fresh opportunities</p>
                        <h2>@lang('web.home_menu.latest_jobs')</h2>
                        <p class="nasira-section-lead">New roles from employers hiring now — apply with a strong CV and move faster.</p>
                    </div>

                    <div class="nasira-job-grid">
                        @php
                            $showCountryFilter = \Illuminate\Support\Facades\Auth::check()
                                && isset(auth()->user()->country_name)
                                && isset($latestJobsEnable)
                                && $latestJobsEnable->value;
                            $rendered = 0;
                        @endphp

                        @if ($showCountryFilter && in_array(auth()->user()->country_name, array_column($latestJobs->toArray(), 'country_name')))
                            @foreach ($latestJobs as $job)
                                @if ($job->country_name == auth()->user()->country_name)
                                    @include('front_web.common.nasira_job_card')
                                    @php $rendered++; @endphp
                                @endif
                            @endforeach
                        @else
                            @foreach ($latestJobs as $job)
                                @include('front_web.common.nasira_job_card')
                                @php $rendered++; @endphp
                            @endforeach
                        @endif
                    </div>

                    <div class="nasira-section-actions">
                        <a href="{{ route('front.search.jobs') }}" class="nasira-section-btn">
                            @lang('web.common.browse_all') <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </section>
        @endif
        <!-- end latest-job-section -->

        <!-- start featured-job-section -->
        @if (count($featuredJobs))
            <section class="featured-job-section py-100">
                <div class="container">
                    <div class="overflow-hidden pb-60">
                        <div class="section-heading text-center">
                            <h2 class="text-secondary mb-0 d-inline-block">@lang('web.home_menu.featured_jobs')</h2>
                        </div>
                    </div>
                    <div class="job-card">
                        <div class="row">
                            @foreach ($featuredJobs as $job)
                                @include('front_web.common.job_card')
                            @endforeach
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 text-center">
                                <a class="btn btn-primary  fs-14 mt-3"
                                    href="{{ route('front.search.jobs', ['is_featured' => true]) }}">
                                    @lang('web.common.browse_all')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- end featured-job-section -->

        <!-- start featured-company-section -->
        @if (count($featuredCompanies))
            <section class="featured-job-section py-80">
                <div class="container">
                    <div class="overflow-hidden pb-60">
                        <div class="section-heading text-center">
                            <h2 class="text-secondary mb-0 d-inline-block">@lang('web.home_menu.featured_companies')</h2>
                        </div>
                    </div>
                    <div class="job-card">
                        <div class="row">

                            @foreach ($featuredCompanies->take(8) as $company)
                                @include('front_web.common.company_card')
                            @endforeach
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 text-center">
                                <a class="btn btn-primary  fs-14 mt-3"
                                    href="{{ route('front.company.lists', ['is_featured' => true]) }}">
                                    @lang('web.common.browse_all')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- end featured-company-section -->

        <!-- start notice-section -->
        @if (count($notices) > 0)
            <section
                class="notice-section {{ count($latestJobs) > 0 ? (count($featuredJobs) > 0 ? 'mt-40' : 'mt-100 mb-100') : 'mb-100' }}">
                <div class="container">
                    <div class="notice-content bg-gradient">
                        <div class="overflow-hidden mx-3">
                            <div class="section-heading text-center py-60">
                                <h2 class="text-secondary mb-0 d-inline-block">@lang('web.home_menu.notices')</h2>
                            </div>
                        </div>
                        <div class="autoscroller">
                            <div class="marquee">
                                <div class="row justify-content-center">
                                    @foreach ($notices as $key => $notice)
                                        <div class="col-xl-10 col-11 position-relative mb-4">
                                            <div class="notice-desc bg-white py-20 px-md-5 px-4">
                                                <p class="text-secondary">
                                                    {!! nl2br(strip_tags($notice->description)) !!}
                                                </p>
                                                <p class="fs-14 text-gray mb-md-0 mb-5">
                                                    {{ html_entity_decode($notice->title) }}
                                                    | {{ $notice->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                            <span href="#"
                                                class="btn-primary  position-absolute">{{ \Carbon\Carbon::parse($notice->created_at)->translatedFormat('jS M, Y') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- end notice-section -->

        <!-- start testimonial-section -->
        @if (count($testimonials) > 0)
            <section
                class="testimonial-section overflow-hidden  {{ count($notices) > 0 ? 'mb-100' : 'mt-80 mb-100' }}  {{ count($latestJobs) > 0 ? 'mt-80 mb-100' : '' }}">
                <div class="container-fluid p-sm-0">
                    <div class="overflow-hidden pb-60">
                        <div class="section-heading text-center">
                            <h2 class="text-secondary mb-0 d-inline-block">@lang('web.home_menu.testimonials')</h2>
                        </div>
                    </div>
                    <div class="">
                        <div class="testimonial-slider">
                            @foreach ($testimonials as $testimonial)
                                <div>
                                    <div class="testimonial-card bg-light">
                                        <div class="desc">
                                            <p> {!! !empty(nl2br($testimonial->description)) ? nl2br($testimonial->description) : __('messages.n/a') !!} </p>
                                        </div>
                                        <div class="">
                                            <div class="d-flex justify-content-between align-items-end">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="testimonial-profile {{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }}">
                                                        <img src="{{ isset($testimonial->customer_image_url) ? $testimonial->customer_image_url : asset('assets/img/infyom-logo.png') }}"
                                                            class="w-100 h-100 object-fit-cover" alt="profile">
                                                    </div>
                                                    <div class="profile-desc">
                                                        <h6 class="fs-18 mb-1">
                                                            {{ html_entity_decode($testimonial->customer_name) }} </h6>
                                                    </div>
                                                </div>
                                                <div class="text-end comma-img"> <img
                                                        src="{{ asset('img_template/comma.png') }}" class="w-100"
                                                        alt="comma"> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- end testimonial-section -->

        <!-- start blog-section -->
        @if (count($recentBlog) > 0)
            <section class="recent-blog-section pt-100 pb-60 bg-light">
                <div class="container">
                    <div class="overflow-hidden pb-60">
                        <div class="section-heading text-center">
                            <h2 class="text-secondary mb-0 d-inline-block">@lang('messages.recent_blog')</h2>
                        </div>
                    </div>
                    <div class="blog-card">
                        <div class="row">
                            @foreach ($recentBlog as $post)
                                <div class="col-lg-4 col-md-6 mb-40 px-xl-3">
                                    <div class="card">
                                        <div class="card-img-top position-relative">
                                            <img src="{{ empty($post->blog_image_url) ? asset('front_web/images/blog-1.png') : $post->blog_image_url }}"
                                                class="card-img-top" alt="Employee Motivation" />
                                            <div class="overlay position-absolute">
                                                <a href="{{ route('front.posts.details', $post->id) }}"
                                                    class="btn text-white fs-16"> {{ __('web.post_menu.read_more') }} </a>
                                            </div>
                                        </div>
                                        <div class="card-body px-20">
                                            <a href="{{ route('front.posts.details', $post->id) }}"
                                                class="text-secondary primary-link-hover">
                                                <h5 class="card-title fs-18 text-secondary">
                                                    {{ html_entity_decode($post->title) }}
                                                </h5>
                                            </a>
                                            <p class="card-text fs-14 text-gray">
                                                {!! !empty($post->description) ? Str::limit(strip_tags($post->description), 100, '...') : __('messages.n/a') !!}
                                            </p>
                                            <span class="fs-14 text-gray">
                                                @if ($post->comments_count == 0 || $post->comments_count == 1)
                                                    {{ \Carbon\Carbon::parse($post->created_at)->translatedFormat('M jS Y') }}
                                                    | {{ $post->comments_count . ' ' . __('messages.post.comment') }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($post->created_at)->translatedFormat('M jS Y') }}
                                                    | {{ $post->comments_count . ' ' . __('messages.post.comment') }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- end blog-section -->

        <!-- start-about-section -->
        <section class="about-section py-60 bg-primary">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-sm-3 col-6 text-center mb-sm-0 mb-4">
                        <div class="about-desc">
                            <h3 class="text-white count">
                                {{ $dataCounts['candidates'] }}
                            </h3>
                            <p class="text-white fs-18 mb-0">@lang('messages.front_home.candidates')</p>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6 text-center mb-sm-0 mb-4">
                        <div class="about-desc">
                            <h3 class="text-white count">
                                {{ $dataCounts['jobs'] }}
                            </h3>
                            <p class="text-white fs-18 mb-0">@lang('messages.front_home.jobs')</p>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6 text-center">
                        <div class="about-desc">
                            <h3 class="text-white count">
                                {{ $dataCounts['resumes'] }}
                            </h3>
                            <p class="text-white fs-18 mb-0">@lang('messages.front_home.resumes')</p>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6 text-center">
                        <div class="about-desc">
                            <h3 class="text-white count">
                                {{ $dataCounts['companies'] }}
                            </h3>
                            <p class="text-white fs-18 mb-0">@lang('messages.front_home.companies')</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end-about-section -->

        <!-- start pricing-packages-section -->
        {{-- @if (count($plans) > 0)
            <section class="pricing-packages-section pt-100 pb-60">
                <div class="container">
                    <div class="overflow-hidden pb-60">
                        <div class="section-heading text-center">
                            <h2 class="text-secondary mb-0 d-inline-block">
                                @lang('web.web_home.pricing_packages')
                            </h2>
                        </div>
                    </div>
                    <section class="slider-test-section pricing-plans position-relative">
                        <div id="carouselExampleControlsabout" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($plansArray as $key => $plans)
                                @php
                                    $isshoebtn = 0;
                                    if ($key >= 1) { $isshoebtn = 1; }
                                @endphp
                                    <div class="carousel-item position-relative {{ $key == 0 ? 'active' : '' }}">
                                        <div class="row d-flex justify-content-center">
                                            @foreach ($plans as $plan)
                                                <div class="pricing-packages-section-card col-lg-4 col-sm-6 px-xl-3">
                                                    <div class="pricing-plan-card card bg-light shadow-none">
                                                        <div class="card-body text-center p-0">
                                                            <div class="card-body-top py-30">
                                                                <p class="mb-2 text-primary fs-18 fw-bold">
                                                                    {{ html_entity_decode(Str::limit($plan['name'], 50, '...')) }}
                                                                </p>
                                                                <div class="text-center d-flex justify-content-center">
                                                                    <h3 class="text-secondary mb-0">
                                                                        {{ empty($plan['salary_currency']['currency_icon']) ? '$' : $plan['salary_currency']['currency_icon'] }}{{ $plan['amount'] }}
                                                                    </h3>
                                                                    @if ($plan['unlimited_plan'] == 1)
                                                                    <span class="text-gray mt-xl-4 mt-sm-3 mt-2 ms-1">
                                                                        {{ getFrontSelectLanguage() == 'ar' ? '\\' : '/' }} {{ __('messages.plan.unlimited') }}</span>
                                                                    @else
                                                                    <span class="text-gray mt-xl-4 mt-sm-3 mt-2 ms-1">
                                                                        {{ getFrontSelectLanguage() == 'ar' ? '\\' : '/' }} {{ __('web.web_home.monthly') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="card-body-bottom py-30">
                                                                <div
                                                                    class="text d-flex align-items-center justify-content-center mb-0">
                                                                    <div class="check-box {{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }}">
                                                                        <i class="fa-solid fa-check text-white fs-14"></i>
                                                                    </div>
                                                                    <span
                                                                        class="">{{ $plan['allowed_jobs'] . ' ' . ($plan['allowed_jobs'] > 1 ? __('messages.plan.jobs_allowed') : __('messages.plan.job_allowed')) }}</span>
                                                                </div>
                                                                <div class="px-4 pt-2">
                                                                    @if (Auth::check() && Auth::user()->hasRole('Candidate'))
                                                                        <a href="#"
                                                                            class="btn btn-light w-100 fs-14 mt-3 py-2 px-4"
                                                                            >{{ __('messages.pricing_table.buy_plan') }}</a>
                                                                    @elseif(Auth::check() && Auth::user()->hasRole('Employer'))
                                                                        <a href="{{ route('manage-subscription.index') }}"
                                                                            class="btn btn-light w-100 fs-14 mt-3 py-2 px-4"
                                                                            >{{ __('messages.pricing_table.buy_plan') }}</a>
                                                                    @elseif(Auth::check() && Auth::user()->hasRole('Admin'))
                                                                        <a href="#"
                                                                            class="btn btn-light w-100 fs-14 mt-3 py-2 px-4 d-none"
                                                                            >{{ __('messages.pricing_table.buy_plan') }}</a>
                                                                    @else
                                                                        <a href="{{ route('employer.register') }}"
                                                                            class="btn btn-light w-100 fs-14 mt-3 py-2 px-4"
                                                                            >{{ __('messages.pricing_table.buy_plan') }}</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($isshoebtn == 1)
                            <button class="carousel-control-prev about-control-prev" type="button"
                                data-bs-target="#carouselExampleControlsabout" data-bs-slide="prev">
                                <i class="icon fa-solid fa-arrow-left text-primary"></i>
                            </button>
                            <button class="carousel-control-next about-control-next" type="button"
                                data-bs-target="#carouselExampleControlsabout" data-bs-slide="next">
                                <i class="icon fa-solid fa-arrow-right text-primary"></i>
                            </button>
                            @endif
                        </div>
                    </section>
                </div>
            </section>
        @endif --}}
        <!-- end pricing-packages-section -->
        {{ Form::hidden('homeData', json_encode(getCountries()), ['id' => 'indexHomeData']) }}
    </div>
@endsection
