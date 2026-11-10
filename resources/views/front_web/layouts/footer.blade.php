<footer class="footer bg-gradient">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xxl-3 col-xl-4 col-lg-6 mb-xl-0 mb-5">
                <div class="footer-logo">
                    <a href="{{ route('front.home') }}">
                        <img src="{{ asset($settings['footer_logo']) }}" alt="jobs-landing" class="img-fluid"
                            style="width: 80px" />
                    </a>
                </div>
                <p class="d-block text-gray my-4">
                    {{ __('web.footer.newsletter_text') }}
                </p>
                <form id="newsLetterForm">
                    <div class="email d-flex">
                        <input type="email" id="mc-email" name="email"
                            placeholder="{{ __('web.enter_your_mail') }}" class="text-gray" />
                        <div class="icon d-flex justify-content-center align-items-center bg-primary">
                            <button
                                class="icon d-flex justify-content-center align-items-center bg-primary border-0 btnLetterSave"
                                title="Subscribe">
                                <i class="fa-solid fa-paper-plane text-white"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="social-icon d-flex mt-4">
                    @if (!empty($settings['facebook_url']))
                        <a href="{{ $settings['facebook_url'] }}" target="_blank" class=" me-2">
                            <i
                                class="fa-brands fa-facebook-f me-4  pe-1 d-flex align-items-center justify-content-center"></i>
                        </a>
                    @endif
                    @if (!empty($settings['twitter_url']))
                        <a href="{{ $settings['twitter_url'] }}" target="_blank" class=" mx-2">
                            <i class="fa-brands fa-twitter me-4 d-flex align-items-center justify-content-center"></i>
                        </a>
                    @endif
                    @if (!empty($settings['google_plus_url']))
                        <a href="{{ $settings['google_plus_url'] }}" target="_blank" class=" mx-2">
                            {{-- <i class="fa-brands fa-instagram me-3 d-flex align-items-center justify-content-center"></i> --}}
                            <i class="fa-brands fa-google me-4 d-flex align-items-center justify-content-center"></i>
                        </a>
                    @endif
                    @if (!empty($settings['linkedIn_url']))
                        <a href="{{ $settings['linkedIn_url'] }}" target="_blank" class=" mx-2">
                            <i
                                class="fa-brands fa-linkedin-in me-4 d-flex align-items-center justify-content-center"></i>
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-xl-2 col-lg-5 col-md-6 mb-3 ps-xl-5">
                <h3 class="mb-3 text-secondary fs-18">{{ __('web.footer.useful_links') }}</h3>
                <ul class="p-0">
                    <li>
                        <a href="{{ url('/') }}"
                            class="text-decoration-none {{ Request::is('/') ? 'footer-navbar-color-active text-dark' : 'text-gray' }} mb-3 d-block fs-14">{{ __('web.home') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.search.jobs') }}"
                            class="text-decoration-none {{ Request::is('search-jobs') || Request::is('job-details*') ? 'footer-navbar-color-active text-dark' : 'text-gray' }} mb-3 d-block fs-14">{{ __('web.jobs') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.company.lists') }}"
                            class="text-decoration-none {{ Request::is('company-lists') || Request::is('company-details*') ? 'footer-navbar-color-active text-dark' : 'text-gray' }} mb-3 d-block fs-14">{{ __('web.companies') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-xl-2 col-lg-6 col-md-6 mb-3">
                <h3 class="mb-3 text-secondary fs-18">{{ __('web.web_home.helpful_resources') }}</h3>
                <ul class="p-0">
                    <li>
                        <a href="{{ route('front.about.us') }}"
                            class="text-decoration-none mb-3 d-block {{ Request::is('about-us') ? 'footer-navbar-color-active text-dark' : 'text-gray' }} fs-14">{{ __('web.about_us') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('front.contact') }}"
                            class="text-decoration-none mb-3 d-block {{ Request::is('contact-us') ? 'footer-navbar-color-active text-dark' : 'text-gray' }} fs-14">{{ __('web.contact_us') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('front.post.lists') }}"
                            class="text-decoration-none mb-3 d-block {{ Request::is('posts*') ? 'footer-navbar-color-active text-dark' : 'text-gray' }} fs-14">
                            {{ __('messages.post.blog') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('privacy.policy.list') }}"
                            class="text-decoration-none mb-3 d-block {{ Request::is('privacy-policy-list') ? 'footer-navbar-color-active text-dark' : 'text-gray' }} fs-14">{{ __('messages.setting.privacy_policy') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('terms.conditions.list') }}"
                            class="text-decoration-none mb-3 d-block {{ Request::is('terms-conditions-list') ? 'footer-navbar-color-active text-dark' : 'text-gray' }} fs-14">{{ __('messages.setting.terms_conditions') }}</a>
                    </li>
                </ul>
            </div>
            <div class="col-xl-3 col-lg-5">
                <h3 class="mb-3 text-secondary fs-18">{{ __('web.contact_us') }}</h3>
                @php
                    $contactPhone = trim((string) ($settings['phone'] ?? ''));
                    $contactRegion = trim((string) ($settings['region_code'] ?? ''));
                    $contactEmail = trim((string) ($settings['email'] ?? ''));
                    $contactAddress = trim((string) ($settings['address'] ?? ''));
                    $phoneDigitsOnly = preg_replace('/\D+/', '', $contactPhone) ?? '';
                    $regionDigits = preg_replace('/\D+/', '', $contactRegion) ?? '';
                    if ($regionDigits !== '' && str_starts_with($phoneDigitsOnly, '0')) {
                        $phoneDigitsOnly = substr($phoneDigitsOnly, 1);
                    }
                    $phoneDigits = $regionDigits.$phoneDigitsOnly;
                    $phoneDisplay = $contactPhone;
                    $phoneHref = $phoneDigits !== '' ? 'tel:+'.$phoneDigits : '#';
                @endphp
                <div class="footer-info">
                    @if ($contactPhone !== '')
                        <div class="d-flex footer-info__block mb-3">
                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} align-content-center">
                                <img src="{{ asset('img_template/contact.svg') }}" class="w-100" alt="" />
                            </div>
                            <a href="{{ $phoneHref }}" class="text-decoration-none text-gray fs-13">
                                {{ $phoneDisplay }}
                            </a>
                        </div>
                    @endif
                    @if ($contactAddress !== '')
                        <div class="d-flex footer-info__block mb-3">
                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }}">
                                <img src="{{ asset('img_template/address.svg') }}" alt="" />
                            </div>
                            <p class="text-gray mb-0 fs-14">
                                {{ $contactAddress }}
                            </p>
                        </div>
                    @endif
                    @if ($contactEmail !== '')
                        <div class="d-flex footer-info__block mb-3">
                            <div class="{{ getFrontSelectLanguage() == 'ar' ? 'ms-3' : 'me-3' }} align-content-center">
                                <img src="{{ asset('img_template/email.svg') }}" class="w-100" alt="" />
                            </div>
                            <a href="mailto:{{ $contactEmail }}" class="text-decoration-none text-gray">
                                {{ $contactEmail }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-12 text-center mt-lg-5 mt-4 copy-right">
                <p class="pt-4 pb-4 text-gray fs-13">
                    &copy;{{ date('Y') }}
                    <a href="{{ getSettingValue('company_url') }}" class="text-primary">
                        {{ html_entity_decode($settings['application_name']) }}</a>.
                    {{ __('web.footer.all_rights_reserved') }}.
                </p>
            </div>
        </div>
    </div>
</footer>
