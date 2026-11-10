@extends('front_web.layouts.app')
@section('title')
    {{ __('web.job_seekers') }}
@endsection
@section('page_css')
    @if (\Illuminate\Support\Facades\App::getLocale() == 'ar')
        <style>
            .candidate-main ul.pagination {
                direction: rtl;
            }
        </style>
    @endif
@endsection
@section('content')
    <div class="job-seekers-page">
        <section class="hero-section position-relative bg-gradient pt-15 pb-40">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 text-center mb-lg-0 mb-md-5 mb-sm-4">
                        <div class="hero-content">
                            <h1 class="text-secondary mb-2">@lang('web.post_menu.categories')</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('front.home') }}" class="fs-18 text-gray">{{ __('web.home') }}
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item text-primary fs-18" aria-current="page">
                                        @lang('web.post_menu.categories')
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- @dd($jobCategories) --}}
        @if (count($jobCategories) > 0)

            <section class="popular-job-categories-section py-100">
                <div class="container">
                    <div class="job-card">
                        <div class="row ">

                            @foreach ($jobCategories as $jobCategory)
                                <div class="col-lg-4 col-md-6 px-xl-3 mb-40">
                                    <div class="card py-30">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                                    <img src="{{ $jobCategory->image_url }}" class="card-img"
                                                        alt="...">
                                                </div>
                                                <div class="">
                                                    <div class="card-body p-0">
                                                        <a href="{{ route('front.search.jobs', ['categories' => $jobCategory->id]) }}"
                                                            class="text-secondary primary-link-hover">
                                                            <h5 class="card-title fs-18">
                                                                {{ html_entity_decode($jobCategory->name) }}</h5>
                                                        </a>
                                                        <p class="card-text fs-14 text-gray">
                                                            {{ ($jobCategory->jobs_count ? $jobCategory->jobs_count : 0) . ' ' . __('web.open_positions') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="icon position-relative pe-0">
                                                @if ($jobCategory->is_featured)
                                                    <div class="col-1 icon position-relative pe-0">
                                                        <i class="text-primary fa-solid fa-bookmark"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- <div class="card-desc d-flex flex-column justify-content-between h-100 mt-4">
                                            <div class="desc d-flex">
                                                <p class="text text-primary fs-14 mb-0 me-3">
                                                    {{ !empty($job->jobsSkill[0]->name) ? $job->jobsSkill[0]->name : 'Skill' }}asd
                                                </p>
                                                <p class="fs-14 text text-primary mb-0">asdasdasd</p>
                                            </div>
                                        </div> --}}
                                        @if ($jobCategory->jobs_count <= 0)
                                            <div class="card-desc mt-3">
                                                <div class="desc d-flex mt-2">
                                                    <p class="jobs-position text text-primary fs-14 mb-0 {{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }}">
                                                        {{ __('web.no_positions') }}
                                                    </p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="card-desc mt-3">
                                                <div class="desc  d-flex mt-2">
                                                    <a href="{{ route('front.search.jobs', ['categories' => $jobCategory->id]) }}"
                                                        class="jobs-position text text-primary fs-14 mb-0 me-3">
                                                        {{ __('web.open_positions') }} ->
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection
