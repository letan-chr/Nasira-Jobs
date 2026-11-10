@extends('front_web.layouts.app')
@section('title')
    {{ __('messages.about_us') }}
@endsection
{{-- @section('page_css') --}}
{{--    <link rel="stylesheet" href="{{ asset('front_web/scss/about-us.css') }}"> --}}
{{-- @endsection --}}
@section('content')
    <div class="About Us-page">
        <!-- start hero section -->
        <section class="hero-section position-relative bg-gradient pt-15 pb-40">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 text-center mb-lg-0 mb-md-5 mb-sm-4">
                        <div class="hero-content">
                            <h1 class="text-secondary mb-2">{{ __('web.about_us') }}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('front.home') }}" class="fs-18 text-gray">{{ __('web.home') }}
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item text-primary fs-18" aria-current="page">
                                        {{ __('web.about_us') }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end hero section -->

        <!-- start-about-section -->
        <div class="about-section pt-60 pb-100">
            <div class="container">
                <div class="about-infyjob">
                    <h5 class="fs-18 text-secondary mb-3">{{ __('web.about_us') }}</h5>
                    <p class="fs-16 text-gray mb-0">
                        {!! getSettingValue('about_us') !!}
                    </p>
                </div>
            </div>
        </div>
        <!-- end-about-section -->

        <!-- start-how-it-works section -->
        <section class="how-it-works-section bg-light pt-100 pb-60">
            <div class="container">
                <div class="overflow-hidden pb-60">
                    <div class="section-heading text-center">
                        <h2 class="text-secondary mb-0 d-inline-block">{{ __('web.about_us_menu.how_it_works') }}?</h2>
                    </div>
                </div>
                <div class="work-process">
                    <div class="row justify-content-center">
                        <div class="col-xxl-10">
                            <div class="row justify-content-center position-relative">
                                <div class="col-lg-4 text-center px-xl-5 px-lg-4 mb-40">
                                    <div class="img bg-white mx-auto d-flex justify-content-center align-items-center mb-4">
                                        <img src="{{ $settings['about_image_one'] }}" />
                                    </div>
                                    <div class="card-body p-0 pt-lg-2">
                                        <h5 class="fs-18 text-secondary">{{ $settings['about_title_one'] }}</h5>
                                        <p class="fs-14 text-gray mb-0">
                                            {{ $settings['about_description_one'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center px-xl-5 px-lg-4 mb-40">
                                    <div class="img bg-white mx-auto d-flex justify-content-center align-items-center mb-4">
                                        <img src="{{ $settings['about_image_two'] }}" />
                                    </div>
                                    <div class="card-body p-0 pt-lg-2">
                                        <h5 class="fs-18 text-secondary">{{ $settings['about_title_two'] }}</h5>
                                        <p class="fs-14 text-gray mb-0">
                                            {{ $settings['about_description_two'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-center px-xl-5 px-lg-4 mb-40">
                                    <div class="img bg-white mx-auto d-flex justify-content-center align-items-center mb-4">
                                        <img src="{{ $settings['about_image_three'] }}" />
                                    </div>
                                    <div class="card-body p-0 pt-lg-2">
                                        <h5 class="fs-18 text-secondary">{{ $settings['about_title_three'] }}</h5>
                                        <p class="fs-14 text-gray mb-0">
                                            {{ $settings['about_description_three'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="arrow1 position-absolute d-lg-block d-none">
                                    <img src="{{ asset('img_template/arrow-1.png') }}" />
                                </div>
                                <div class="arrow2 position-absolute d-lg-block d-none">
                                    <img src="{{ asset('img_template/arrow-2.png') }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end-how-it-works section -->

        <!-- start question-section -->
        {{-- <section class="question-section py-100">
            <div class="container">
                <div class="overflow-hidden pb-60">
                    <div class="section-heading text-center">
                        <h2 class="text-secondary mb-0 d-inline-block">
                            {{ __('web.about_us_menu.frequently_asked_questions') }}
                        </h2>
                    </div>
                </div>
                <div class="questions">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            @if (count($faqLists) > 0)
                                <div class="accordion" id="accordionExample">
                                    @foreach ($faqLists as $key => $faqList)
                                        <div class="accordion-item br-10">
                                            <h2 class="accordion-header" id="heading-{{ $key }}">
                                                <button class="accordion-button collapsed fs-18  p-3" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-{{ $key }}" aria-expanded="false"
                                                    aria-controls="collapse-{{ $key }}">
                                                    {{ html_entity_decode($faqList->title) }}
                                                </button>
                                            </h2>
                                            <div id="collapse-{{ $key }}" class="accordion-collapse collapse "
                                                aria-labelledby="heading-{{ $key }}"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    {!! nl2br(e($faqList->description)) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div>
                                    <h5 class="text-center">{{ __('web.about_us_menu.faq_not_available') }}.</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}
        <section class="question-section py-100">
            <div class="container">
                <div class="overflow-hidden pb-60">
                    <div class="section-heading text-center">
                        <h2 class="text-secondary mb-0 d-inline-block">
                            {{ __('web.about_us_menu.frequently_asked_questions') }}
                        </h2>
                    </div>
                </div>
                <div class="questions">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            @if (count($faqLists) > 0)
                                <div class="accordion" id="accordionExample">
                                    @foreach ($faqLists as $key => $faqList)
                                        <div class="accordion-item br-10">
                                            <h2 class="accordion-header" id="heading-{{ $key }}">
                                                <button class="accordion-button @if ($key !== 1) collapsed @endif fs-18 p-3" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapse-{{ $key }}"
                                                    aria-expanded="true" aria-controls="collapse-{{ $key }}">
                                                    {{ html_entity_decode($faqList->title) }}
                                                </button>
                                            </h2>
                                            <div id="collapse-{{ $key }}"
                                                class="accordion-collapse collapse @if ($key == 1) show @endif"
                                                aria-labelledby="heading-{{ $key }}"
                                                data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <p class="fs-14 text-gray">
                                                        {!! nl2br(e($faqList->description)) !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div>
                                    <h5 class="text-center">{{ __('web.about_us_menu.faq_not_available') }}.</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end question-section -->
    </div>
@endsection
