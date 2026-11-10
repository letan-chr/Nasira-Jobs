<section class="testimonial-section overflow-hidden py-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-3 col-lg-4 col-sm-6 col-7">
                <div class="section-heading">
                    <h2 class="text-secondary bg-white text-center mx-xxl-3 mx-xl-0 mx-lg-2 mx-md-4">@lang('web.home_menu.testimonials')</h2>
                </div>
            </div>
        </div>
        <div class="testimonial">
            <div class="row testimonial-block justify-content-center">
                <div class="col-lg-9 testimonial-carousel">
                    @foreach($testimonials as $testimonial)
                        <div class="testimonial-card">
                            <div class="row justify-content-md-between justify-content-center">
                                <div class="col-md-3 col-sm-6 col-8 d-flex justify-content-center">
                                    <div class="position-relative">
                                        <div class="testimonial-img">
                                            <img src="{{ isset($testimonial->customer_image_url)? $testimonial->customer_image_url:asset('assets/img/infyom-logo.png') }}" alt="profile">
                                        </div>
                                        <div class="comma position-absolute">
                                            <img src="{{asset('front_web/images/comma.png')}}" alt="comma">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-8 profile-desc ps-lg-5 ps-md-3">
                                    <div class="row flex-column-reverse flex-md-row">
                                        <div class="col-12">
                                            <div class="testimonial-desc fs-16 text-gray">
                                                {!! !empty(nl2br($testimonial->description))?nl2br($testimonial->description) : __('messages.n/a') !!}
                                            </div>
                                        </div>
                                        <div class="col-12 text-md-start text-center">
                                            <p class="fs-18 text-secondary mb-md-0 mt-3">{{ html_entity_decode($testimonial->customer_name) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
