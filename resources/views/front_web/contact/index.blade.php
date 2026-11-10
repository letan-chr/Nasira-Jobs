@extends('front_web.layouts.app')
@section('title')
    {{ __('web.contact_us') }}
@endsection
@section('page_css')
    <style>
        .iti {
            display: block !important;
        }
    </style>
@endsection
@section('content')
    <div class="Blog-page">
        <!-- start hero section -->
        <section class="hero-section position-relative bg-gradient pt-15 pb-40">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 text-center">
                        <div class="hero-content">
                            <h1 class="text-secondary mb-2">{{ __('web.contact_us') }}</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('front.home') }}" class="fs-18 text-gray">{{ __('web.home') }}
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item text-primary fs-18" aria-current="page">
                                        {{ __('web.contact_us') }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end hero section -->

        <!--start contact-us-section-->
        <section class="contact-us-section py-60 mb-5">
            <div class="container">
                <div class="contact-us bg-light br-10">
                    <div class="row">
                        <div class="col-lg-3 d-lg-block d-none text-end">
                            <div class="contact-img mt-5">
                                <img src="{{ asset('img_template/contact-page.png') }}">
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <form id="formContact" name="frm-contact" class="py-40 px-lg-5 px-40" method="post"
                                action="{{ route('send.contact.email') }}">
                                @csrf
                                @include('flash::message')
                                @include('front_web.layouts.errors')
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for=""
                                                class="fs-16 text-secondary mb-2">{{ __('web.web_contact.your_name') }}:
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control fs-14 text-gray br-10" name="name"
                                                placeholder="@lang('web.web_contact.your_name')" value="{{ old('name') }}"
                                                autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for=""
                                                class="fs-16 text-secondary mb-2">{{ __('web.web_contact.your_email') }}:
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control fs-14 text-gray br-10" name="email"
                                                placeholder="@lang('web.web_contact.your_email')" value="{{ old('email') }}"
                                                autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for=""
                                                class="fs-16 text-secondary mb-2">{{ __('web.web_contact.subject') }}:
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input class="form-control fs-14 text-gray br-10" type="text" name="subject"
                                                value="{{ old('subject') }}" placeholder="@lang('web.web_contact.subject')"
                                                autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for=""
                                                class="fs-16 text-secondary mb-2">{{ __('web.web_contact.your_phone_no') }}:</label>
                                            <input class="form-control fs-14 text-gray br-10 d-block" type="tel"
                                                name="phone_no" value="{{ old('phone_no') }}"
                                                placeholder="@lang('web.web_contact.phone_number')" autocomplete="off" id='phoneNumber'>
                                            <input type="hidden" name="region_code" id="prefix_code">
                                            <p id="valid-msg" class="text-success d-none fw-400 fs-small mt-2">
                                                {{ __('messages.phone.valid_number') }}</p>
                                            <p id="error-msg" class="text-danger d-none fw-400 fs-small mt-2"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <div class="form-group">
                                            <label for=""
                                                class="fs-16 text-secondary mb-2">{{ __('web.web_contact.your_message') }}:
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control fs-14 text-gray br-10" rows="3" name="message" placeholder="@lang('web.web_contact.type_your_message')"
                                                required>{{ trim(old('message')) }}</textarea>
                                        </div>
                                    </div>

                                    @if (\App\Support\GoogleRecaptcha::isEnabled())
                                    <div class="col-md-12 mb-4">
                                        <div class="form-group">
                                            <div class="g-recaptcha d-flex justify-content-center"
                                                id="gRecaptchaContainerCompanyRegistration"
                                                data-sitekey="{{ config('app.google_recaptcha_site_key') }}"
                                                name="g-recaptcha"></div>
                                            <div id="g-recaptcha-error"></div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-6 text-center">
                                        <button class="btn btn-primary " type="submit">
                                            {{ __('web.contact_us_menu.send_message') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--end contact-us-section-->
    </div>
@endsection
<script>
    var phoneNo = "{{ old('region_code') . old('phone_no') }}";
</script>
{{-- @section('page_scripts') --}}
{{--    <script> --}}
{{--        let isEdit = false --}}
{{--        var phoneNo = "{{ old('region_code').old('phone') }}" --}}
{{--        let utilsScript = "{{asset('assets/js/inttel/js/utils.min.js')}}" --}}
{{--    </script> --}}

{{--    <script src='https://www.google.com/rec aptcha/api.js'></script> --}}
{{-- @endsection --}}
