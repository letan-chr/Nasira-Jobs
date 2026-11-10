@extends('front_web.layouts.app')
@section('title')
    {{ __('messages.post.post_details') }}
@endsection
{{-- @section('page_css') --}}
{{--    <link href="{{asset('front_web/scss/blog-details.css')}}" rel="stylesheet" type="text/css"> --}}
{{-- @endsection --}}
@section('content')
    <div class="Blog Detail-page">
        <!-- start hero section -->
        <section class="hero-section position-relative bg-gradient pt-15 pb-40">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 text-center mb-lg-0 mb-md-5 mb-sm-4">
                        <div class="hero-content">
                            <h1 class="text-secondary mb-2">@lang('web.blog_detail')</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('front.home') }}" class="fs-18 text-gray">@lang('web.home')
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item text-primary fs-18" aria-current="page">
                                        {{ __('messages.post.blog') }}
                                    </li>
                                    <li class="breadcrumb-item text-primary fs-18" aria-current="page">
                                        @lang('web.blog_detail')
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end hero section -->

        <!-- start-blog-details-section -->
        <section class="blog-detail-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="blog-detail py-60">
                            <h5 class="fs-4 mb-3 text-secondary">
                                {{ html_entity_decode($blog->title) }}
                            </h5>
                            <div class="designer-details d-flex mb-40">
                                <div class="img {{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }}">
                                    <img src="{{ isset($blog->user->avatar) ? $blog->user->avatar : asset('front_web/images/job-categories.png') }}"
                                        style="border-radius: 50%;height: 45px;width: 45px;object-fit: cover;" />

                                </div>
                                <div class="d-flex flex-wrap gap-sm-3 gap-2 align-content-center">
                                    <p class="fs-16 text-gray mb-0">{{ $blog->user->full_name }}</p>
                                    <span class="text-primary"> | </span>
                                    <p class="fs-16 text-gray mb-0">
                                        {{ \Carbon\Carbon::parse($blog->created_at)->translatedFormat('M jS Y') }}</p>
                                    <span class="text-primary"> | </span>
                                    <p class="fs-16 text-gray mb-0">{{ isset($comments) ? count($comments) : 0 }}
                                        @lang('web.web_blog.comments')</p>
                                </div>
                            </div>
                            @role('Candidate')
                                <div class="designer-details d-flex flex-wrap pb-3">
                                    <a href="{{ $url['facebook'] }}" title="@lang('web.web_jobs.facebook')" target="_blank"
                                        class="d-flex me-2">
                                        <div class="badge bg-primary py-1 px-2">
                                            <i class="fa-brands fa-facebook fs-18"></i>
                                        </div>
                                    </a>
                                    <a href="{{ $url['twitter'] }}" title="@lang('web.web_jobs.twitter')" target="_blank"
                                        class="d-flex me-2">
                                        <div class="badge bg-primary py-1 px-2">
                                            <i class="fa-brands fa-twitter fs-18"></i>
                                        </div>
                                    </a>
                                    <a href="{{ $url['gmail'] }}" title="@lang('web.web_jobs.google')" target="_blank"
                                        class="d-flex me-2">
                                        <div class="badge bg-primary py-1 px-2">
                                            <i class="fa-brands fa-google fs-18"></i>
                                        </div>
                                    </a>
                                    <a href="{{ $url['pinterest'] }}" title="@lang('web.web_jobs.pinterest')" target="_blank"
                                        class="d-flex me-2">
                                        <div class="badge bg-primary py-1 px-2">
                                            <i class="fa-brands fa-pinterest fs-18"></i>
                                        </div>
                                    </a>
                                    <a href="{{ $url['linkedin'] }}" title="@lang('web.web_jobs.linkedin')" target="_blank" class="d-flex">
                                        <div class="badge bg-primary py-1 px-2">
                                            <i class="fa-brands fa-linkedin fs-18"></i>
                                        </div>
                                    </a>
                                </div>
                            @endrole
                            <div class="blog-img mb-40">
                                <img
                                    src="{{ !empty($blog->blog_image_url) ? $blog->blog_image_url : asset('web/img/blog_default_image.jpg') }}">
                            </div>
                            @php
                                $assignCategories = $blog->postAssignCategories->pluck('name')->toArray();
                            @endphp
                            @if (count($assignCategories) > 0)
                                <div class="designer-details d-flex flex-wrap mb-3">
                                    @forelse($assignCategories as $categoryBadges)
                                        <span
                                            class="p-2 m-1  badge bg-{{ getJobOtherColor($loop->index) }}">{{ $categoryBadges }}</span>
                                    @empty
                                        <span> {{ __('messages.employer_menu.no_data_available') }} </span>
                                    @endforelse
                                </div>
                            @endif
                            <div class="dark-mode mb-40 text-break">
                                <p class="fs-16 text-gray mb-0 ">
                                    {!! !empty($blog->description) ? nl2br($blog->description) : __('messages.n/a') !!}
                                </p>
                            </div>
                            <div class="designer-details d-flex justify-content-between">
                                <div class="prev-post mb-2">
                                    @if ($prevPost)
                                        <div class="card p-3">
                                            <a href="{{ route('front.posts.details', $prevPost->id) }}"
                                                class="text-gray primary-link-hover">

                                                    <small><i class="fa fa-angle-left"></i></small>
                                                    {{ __('messages.post.previous_post') }}

                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="next-post mb-2">
                                    @if ($nextPost)
                                        <div class="card p-3">
                                            <a href="{{ route('front.posts.details', $nextPost->id) }}"
                                                class="text-gray primary-link-hover">

                                                    {{ __('messages.post.next_post') }} <small><i
                                                            class="fa fa-angle-right"></i></small>

                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="comments py-60">
                            <h5 class="comment-lable fs-4 mb-3 text-secondary @if (count($comments) == 0) d-none @endif">@lang('web.web_blog.comments') <span class="comment-count"
                                    id="post-comment">({{ count($comments) }})</span></h5>
                            <div class="row comment-box">
                                @foreach ($comments as $commentRecord)
                                    <div class="comment-card card py-20 {{ $loop->last ? '' : 'mb-40' }}">
                                        <div class="d-flex flex-sm-row justify-content-between align-items-start">
                                            <div class="d-flex align-items-center me-2">
                                                <div class="card-img {{ getFrontSelectLanguage() == 'ar' ? 'ms-4' : 'me-4' }}">
                                                    @if (isset($commentRecord->user_id))
                                                        <img class="card-img" src="{{ $commentRecord->user->avatar }}"
                                                            alt="user-image">
                                                    @else
                                                        <img class="card-img"
                                                            src="{{ asset('front_web/images/job-categories.png') }}"
                                                            alt="user-image">
                                                    @endif
                                                </div>
                                                <div class="">
                                                    <div class="card-body p-0">
                                                        <h5 class="card-title w-100 fs-16 text-secondary text-break">
                                                            {{ $commentRecord->name }}
                                                        </h5>
                                                        <p class="fs-16 text-gray mb-0 text-break"
                                                            id="comment-{{ $commentRecord->id }}">
                                                            {{ $commentRecord->comment }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="">
                                                @if ($commentRecord->user_id == getLoggedInUserId() && getLoggedInUser())
                                                    <div class="d-inline-flex ms-2">
                                                        <a href="javascript:void(0)"
                                                            title="{{ __('messages.common.edit') }}"
                                                            class="edit-comment-btn action-btn"
                                                            data-id="{{ $commentRecord->id }}">
                                                            <div class="badge text-primary py-2 ms-1"
                                                                data-text="Edit Comment">
                                                                <span class="fa fa-pencil"></span>
                                                            </div>
                                                        </a>
                                                        <a href="javascript:void(0)"
                                                            title="{{ __('messages.common.delete') }}"
                                                            class="action-btn delete-comment-btn float-right"
                                                            data-id="{{ $commentRecord->id }}">
                                                            <div class="badge text-danger py-2 ms-1"
                                                                data-text="Delete Comment">
                                                                <span class="fa fa-trash"></span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-end text-nowrap">
                                            <span class="fs-14 text-gray">{{ \Carbon\Carbon::parse($commentRecord->created_at)->translatedFormat('d, M Y g:i a') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="leave-comment py-60">
                            <h5 class="fs-4 mb-3 text-secondary mb-4">@lang('messages.post.post_a_comments')</h5>
                            {{ Form::open(['id' => 'commentForm']) }}
                            {{ Form::token() }}
                            {{ Form::hidden('comment-id', null, ['class' => 'comment-id', 'value' => '']) }}
                            <div class="row">
                                @if (!Auth::check())
                                    <div class="col-md-6">
                                        <div class="form-group mb-md-4 mb-3 ">
                                            <label for="" class="fs-16 text-secondary mb-3">{{ __('web.your_name') }}</label>
                                            <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control fs-14 text-gray bg-white  br-10 p-3 comment-name"
                                                name="name" placeholder="{{ __('web.web_blog.your_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-md-4 mb-3 ">
                                            <label for="" class="fs-16 text-secondary mb-3">{{ __('web.your_email') }}</label>
                                            <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control fs-14 text-gray bg-white  br-10 p-3 comment-email"
                                                name="email" placeholder="{{ __('web.web_blog.your_email') }}">
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="fs-16 text-secondary mb-2">{{__('web.your_comment')}}</label>
                                         <span class="text-danger">*</span></label>
                                        <textarea id="comment-field" class="form-control fs-14 text-gray br-10 comment"
                                            placeholder="{{ __('web.web_blog.add_your_comment') }}" rows="3" name="comment"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm-6 mb-40 text-center">
                                    <button type="submit" id="submitBtn" class="btn btn-primary  mt-5"
                                        data-loading-text="<span class='spinner-border spinner-border-sm'></span> {{ __('messages.common.process') }}">
                                        @lang('messages.post_comment.post_comment')</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end-blog-details-section -->
        @include('front_web.blogs.templates.templates')
        {{ Form::hidden('blogComment', route('blog.create.comment', $blog->id), ['id' => 'blogComment']) }}
        {{ Form::hidden('defaultBlogImage', asset('front_web/images/job-categories.png'), ['id' => 'defaultBlogImage']) }}
    </div>
@endsection
{{-- @section('page_scripts') --}}
{{--    <script> --}}
{{--        let blogComment = "{{ route('blog.create.comment', $blog->id) }}"; --}}
{{--        let commentUrl = "{{ url('post-comments') }}"; --}}
{{--        let editCommentUrl = "{{ '/edit' }}"; --}}
{{--        let defaultImage = "{{ asset('front_web/images/job-categories.png') }}"; --}}
{{--    </script> --}}
{{-- @endsection --}}
