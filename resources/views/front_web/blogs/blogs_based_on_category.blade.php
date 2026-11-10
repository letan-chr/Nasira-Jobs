@extends('front_web.layouts.app')
@section('title')
    {{ __('web.post_of') . html_entity_decode($blogCategory[$categoryId]) }}
@endsection
{{-- @section('page_css') --}}
{{--    <link rel="stylesheet" href="{{ asset('front_web/scss/blog.css') }}"> --}}
{{-- @endsection --}}
@section('content')
    {{-- <section class="hero-section position-relative bg-light py-40">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6  text-center mb-lg-0 mb-md-5 mb-sm-4 ">
                    <div class="hero-content">
                        <h1 class=" text-secondary mb-3">
                            {{ __('web.post_of').html_entity_decode($blogCategory[$categoryId]) }}
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb  justify-content-center mb-0">
                                <li class="breadcrumb-item ">
                                    <a href="{{ route('front.home') }}"
                                       class="fs-18 text-gray">{{ __('web.home') }}</a>
                                </li>
                                <li class="breadcrumb-item text-primary fs-18"
                                    aria-current="page">  {{ __('web.post_of').html_entity_decode($blogCategory[$categoryId]) }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="recent-blog-section py-100 ">
        <div class="container">
            <div class="row ">
                <div class="col-lg-8">
                    <div class="blog-card">
                        <div class="row">
                            @if (count($blogs) > 0)
                                @foreach ($blogs as $blog)
                                    <div class="col-lg-12 {{$loop->last ?'':'mb-40'}}">
                                        <div class="card d-flex flex-md-row">
                                            <div class="card-img-top position-relative blog-detail-img">
                                                <div class="inner-image">
                                                    <img src="{{ !empty($blog->blog_image_url) ? $blog->blog_image_url :asset('assets/img/infyom-logo.png')  }}"
                                                         class="card-img-top rounded-0" alt="Blog Image">
                                                </div>
                                                <div class="overlay position-absolute">
                                                    <a href="{{ route('front.posts.details',$blog->id) }}" class="btn text-white fs-16">
                                                        {{ __('web.post_menu.read_more') }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body py-30 my-auto">
                                                <a href="{{ route('front.posts.details',$blog->id) }}"
                                                   class="text-secondary primary-link-hover">
                                                    <h5 class="card-title fs-18">
                                                        {{ html_entity_decode($blog->title) }}
                                                    </h5>
                                                </a>
                                                <p class="card-text fs-14 text-gray">
                                                    {!! !empty(strip_tags($blog->description)) ? Str::limit(strip_tags($blog->description),150,'...') :__('messages.common.n/a') !!}
                                                </p>
                                                <span class="fs-14 text-gray">
                                                        {{ \Carbon\Carbon::parse($blog->created_at)->translatedFormat('M jS Y')}}
                                                        | {{ isset($blog->comments_count) ? $blog->comments_count : 0 }}
                                                    {{ __('web.web_blog.comments') }}
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h6>
                                    <span class="">{{ __('messages.post.no_posts_available') }}</span>
                                </h6>
                            @endif
                                <div class="mt-5 d-flex align-items-center justify-content-center">
                                    {{ $blogs->withQueryString()->links() }}
                                </div>
                        </div>
                    </div>
                </div>
                @include('front_web.blogs.blog-sidebar')
            </div>
        </div>
    </section> --}}
    <section class="hero-section position-relative bg-gradient pt-15 pb-40">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="hero-content">
                        <h1 class="text-secondary mb-2">
                            {{ __('web.post_of') . html_entity_decode($blogCategory[$categoryId]) }}</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('front.home') }}" class="fs-18 text-gray">{{ __('web.home') }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item text-primary fs-18" aria-current="page">
                                    {{ __('web.post_of') . html_entity_decode($blogCategory[$categoryId]) }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mani-blog recent-blog-section pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-card">
                        @if (count($blogs) > 0)
                            @foreach ($blogs as $blog)
                                <div class="mb-40">
                                    <div class="card d-flex flex-md-row">
                                        <div class="card-img-top position-relative">
                                            <img src="{{ !empty($blog->blog_image_url) ? $blog->blog_image_url : asset('assets/img/infyom-logo.png') }}"
                                                        class="card-img-top rounded-0" alt="Blog Image">
                                            <div class="overlay position-absolute">
                                                <a href="{{ route('front.posts.details', $blog->id) }}"
                                                    class="btn text-white fs-16">
                                                    {{ __('web.post_menu.read_more') }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body py-30 my-auto">
                                            <a href="{{ route('front.posts.details', $blog->id) }}"
                                                class="text-secondary primary-link-hover">
                                                <h5 class="card-title fs-18">
                                                    {{ html_entity_decode($blog->title) }}
                                                </h5>
                                            </a>
                                            <p class="card-text fs-14 text-gray">
                                                {!! !empty(strip_tags($blog->description))
                                                    ? Str::limit(strip_tags($blog->description), 150, '...')
                                                    : __('messages.n/a') !!}
                                            </p>
                                            <span class="fs-14 text-gray">
                                                {{ \Carbon\Carbon::parse($blog->created_at)->translatedFormat('M jS Y') }}
                                                    | {{ isset($blog->comments_count) ? $blog->comments_count : 0 }}
                                                    {{ __('web.web_blog.comments') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h6>
                                <span class="">{{ __('messages.post.no_posts_available') }}</span>
                            </h6>
                        @endif
                        <div class="mt-5 d-flex align-items-center justify-content-center">
                            {{ $blogs->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
                @include('front_web.blogs.blog-sidebar')
            </div>
        </div>
    </section>
@endsection
