@extends('front_web.layouts.app')
@section('title')
    {{ __('messages.post.blog') }}
@endsection
{{-- @section('page_css') --}}
{{--    <link rel="stylesheet" href="{{ asset('front_web/scss/blog.css') }}"> --}}
{{-- @endsection --}}
@section('content')
    <div class="Blog-page">
        <!-- start hero section -->
        <section class="hero-section position-relative bg-gradient pt-15 pb-40">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 text-center">
                        <div class="hero-content">
                            <h1 class="text-secondary mb-2">{{ __('messages.post.blog') }}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('front.home') }}" class="fs-18 text-gray">{{ __('web.home') }}
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item text-primary fs-18" aria-current="page">
                                        {{ __('messages.post.blog') }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end hero section -->
        <!-- start blog-section -->
        <section class="mani-blog recent-blog-section pt-60 pb-60">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="blog-card">
                            @if (count($blogs) > 0)
                                @foreach ($blogs as $blog)
                                    <div class="mb-40 {{ $loop->last ? '' : 'mb-40' }}">
                                        <div class="card d-flex flex-md-row">
                                            <div class="card-img-top position-relative">
                                                <img src="{{ !empty($blog->blog_image_url) ? $blog->blog_image_url : asset('front_web/images/blog-1.png') }}"
                                                    class="card-img-top" alt="Employee Motivation" />
                                                <div class="overlay position-absolute">
                                                    <a href="{{ route('front.posts.details', $blog->id) }}"
                                                        class="btn text-white fs-16">
                                                        {{ __('web.post_menu.read_more') }}
                                                    </a>
                                                </div>
                                            </div>
                                            <a href="{{ route('front.posts.details', $blog->id) }}" class="w-100">
                                                <div class="card-body py-30 my-auto">
                                                    <h5 class="card-title fs-18 text-secondary">
                                                        {{ html_entity_decode($blog->title) }}
                                                    </h5>
                                                    <p class="card-text fs-14 text-gray text-break">
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
                                            </a>
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
        <!-- end blog-section -->
    </div>
@endsection
