@extends('front_web.layouts.app')
@section('title')
    {{ __('messages.company.company_listing') }}
@endsection
@section('page_css')
    @if (\Illuminate\Support\Facades\App::getLocale() == 'ar')
        <style>
            .job-post-wrapper ul.pagination {
                direction: rtl;
            }
        </style>
    @endif
@endsection
@section('content')

    <div class="companies-page">
        <!-- start hero section -->
        <section class="hero-section position-relative bg-gradient pt-15 pb-40">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 text-center">
                        <div class="hero-content">
                            <h1 class="text-secondary mb-2">@lang('messages.companies')</h1>
                            <nav aria-label="breadcrumb ">
                                <ol class="breadcrumb justify-content-center mb-4 pb-3">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('front.home') }}" class="fs-18 text-gray">@lang('web.home')
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item text-primary fs-18" aria-current="page">
                                        @lang('messages.companies')
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end hero section -->

        @livewire('company-search', ['isFeatured' => Request::get('is_featured')])
    </div>
@endsection
