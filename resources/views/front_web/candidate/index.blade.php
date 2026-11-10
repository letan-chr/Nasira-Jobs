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
    {{--    <link rel="stylesheet" href="{{ asset('front_web/scss/jobs.css') }}"> --}}
    {{--    <link rel="stylesheet" href="{{ asset('front_web/scss/companies.css') }}"> --}}
@endsection
@section('content')
    <div class="job-seekers-page">
        {{-- <section class="hero-section position-relative bg-color-light py-40">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6  text-center mb-lg-0 mb-md-5 mb-sm-4 ">
                        <div class="hero-content">
                            <h1 class="text-secondary mb-3">
                                @lang('web.job_seekers')
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center mb-0">
                                    <li class="breadcrumb-item "><a href="{{route('front.home')}}" class="fs-18 text-gray">{{ __('web.home') }} </a>
                                    </li>
                                    <li class="breadcrumb-item text-primary fs-18" aria-current="page">@lang('web.job_seekers')</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="latest-job-section py-60">
            @livewire('candidate-search')
        </section> --}}

        <section class="hero-section position-relative bg-gradient pt-15 pb-40">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6  text-center mb-lg-0 mb-md-5 mb-sm-4 ">
                        <div class="hero-content">
                            <h1 class=" text-secondary mb-3">
                                @lang('web.job_seekers')
                            </h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb  justify-content-center mb-0">
                                    <li class="breadcrumb-item "><a href="{{route('front.home')}}" class="fs-18 text-gray">{{ __('web.home') }}
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item text-primary fs-18" aria-current="page">@lang('web.job_seekers')</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end hero section -->

        <!-- start latest-job section -->

        <section class="latest-job-section py-60">
            @livewire('candidate-search')
        </section>
    </div>
@endsection
{{-- @section('scripts') --}}
{{--    <script> --}}
{{--        $(document).ready(function () { --}}
{{--            $(document).on('click', '#btnReset', function () { --}}
{{--                $('#All').prop('checked', true); --}}
{{--                $('#searchBy').prop('selectedIndex', 0); --}}
{{--            }); --}}
{{--            window.livewire.hook('message.processed', () => { --}}
{{--                $(window).scrollTop(0); --}}
{{--            }); --}}
{{--            $('#searchByCandidate, .search-by-location').val(''); --}}
{{--        }); --}}
{{--    </script> --}}
{{-- @endsection --}}
