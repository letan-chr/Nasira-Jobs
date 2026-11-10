<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/dashboard*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/dashboard*') ? 'active' : '' }}"
       href="{{ route('admin.dashboard') }}">{{ __('messages.dashboard') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/employers*', 'admin/reported-employers*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/employers*') ? 'active' : '' }}"
       href="{{ route('company.index') }}">{{ __('messages.employers') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/employers*', 'admin/reported-employers*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/reported-employers*') ? 'active' : '' }}"
       href="{{ route('reported.companies') }}">{{ __('messages.company.reported_employers') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/admins*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/admins*') ? 'active' : '' }}"
       href="{{ route('admin.index') }}">{{ __('messages.candidate.admins') }}</a>
</li>

<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/candidates*','admin/degree-levels*','admin/reported-candidates*','admin/resumes*','admin/selected-candidates*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/candidates*') ? 'active' : '' }}"
       href="{{ route('candidates.index') }}">{{ __('messages.candidates') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/candidates*','admin/degree-levels*','admin/reported-candidates*','admin/resumes*','admin/selected-candidates*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/degree-levels*') ? 'active' : '' }}"
       href="{{ route('requiredDegreeLevel.index') }}">{{ __('messages.required_degree_levels') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/candidates*','admin/degree-levels*','admin/reported-candidates*','admin/resumes*','admin/selected-candidates*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/reported-candidates*') ? 'active' : '' }}"
       href="{{ route('reported.candidates') }}">{{ __('messages.candidate.reported_candidates') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/candidates*','admin/degree-levels*','admin/reported-candidates*','admin/resumes*','admin/selected-candidates*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/resumes*') ? 'active' : '' }}"
       href="{{ route('resumes.index') }}">{{ __('messages.all_resumes') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/candidates*','admin/degree-levels*','admin/reported-candidates*','admin/resumes*','admin/selected-candidates*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/selected-candidates*') ? 'active' : '' }}"
       href="{{ route('selected.candidate') }}">{{ __('messages.selected_candidate') }}</a>
</li>

<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/jobs*','admin/pending-jobs*','admin/job-categories*','admin/job-types*','admin/job-tags*','admin/job-shifts*','admin/reported-jobs*','admin/job-notification*','admin/expired-jobs*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/jobs*') ? 'active' : '' }}"
       href="{{ route('admin.jobs.index') }}">{{ __('messages.jobs') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/jobs*','admin/pending-jobs*','admin/job-categories*','admin/job-types*','admin/job-tags*','admin/job-shifts*','admin/reported-jobs*','admin/job-notification*','admin/expired-jobs*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/pending-jobs*') ? 'active' : '' }}"
       href="{{ route('admin.PendingJobs.index') }}">{{ __('messages.pending_jobs.pending_jobs') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/jobs*','admin/pending-jobs*','admin/job-categories*','admin/job-types*','admin/job-tags*','admin/job-shifts*','admin/reported-jobs*','admin/job-notification*','admin/expired-jobs*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/job-categories*') ? 'active' : '' }}"
       href="{{ route('job-categories.index') }}">{{ __('messages.job_categories') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/jobs*','admin/pending-jobs*','admin/job-categories*','admin/job-types*','admin/job-tags*','admin/job-shifts*','admin/reported-jobs*','admin/job-notification*','admin/expired-jobs*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/job-types*') ? 'active' : '' }}"
       href="{{ route('jobType.index') }}">{{ __('messages.job_types') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/jobs*','admin/pending-jobs*','admin/job-categories*','admin/job-types*','admin/job-tags*','admin/job-shifts*','admin/reported-jobs*','admin/job-notification*','admin/expired-jobs*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/job-tags*') ? 'active' : '' }}"
       href="{{ route('jobTag.index') }}">{{ __('messages.job_tags') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/jobs*','admin/pending-jobs*','admin/job-categories*','admin/job-types*','admin/job-tags*','admin/job-shifts*','admin/reported-jobs*','admin/job-notification*','admin/expired-jobs*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/job-shifts*') ? 'active' : '' }}"
       href="{{ route('jobShift.index') }}">{{ __('messages.job_shifts') }}</a>
</li>
<div class="{{ !Request::is('admin/jobs*','admin/pending-jobs*','admin/job-categories*','admin/job-types*','admin/job-tags*','admin/job-shifts*','admin/reported-jobs*','admin/job-notification*','admin/expired-jobs*') ? 'd-none' : '' }}">
    <li class="nav-item d-none d-xl-grid dropdown dropdown-hover">
        <a class="nav-link d-flex align-items-center py-3 ps-2" aria-current="page"
           href="javascript:void(0)">
            <span class="horizontal-menu-icon"><i class="fas fa-ellipsis-vertical fs-4"></i></span>
        </a>
        <ul class="horizontal-submenu dropdown-menu top-100">
            <li>
                <a class="dropdown-item {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} {{ Request::is('admin/reported-jobs*') ? 'active' : '' }} {{ !Request::is('admin/jobs*','admin/pending-jobs*','admin/job-categories*','admin/job-types*','admin/job-tags*','admin/job-shifts*','admin/reported-jobs*','admin/job-notification*','admin/expired-jobs*') ? 'd-none' : '' }}"
                   href="{{ route('reported.jobs') }}">{{ __('messages.reported_jobs') }}</a>
            </li>
            <li>
                <a class="dropdown-item {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} {{ Request::is('admin/job-notification*') ? 'active' : '' }} {{ !Request::is('admin/jobs*','admin/pending-jobs*','admin/job-categories*','admin/job-types*','admin/job-tags*','admin/job-shifts*','admin/reported-jobs*','admin/job-notification*','admin/expired-jobs*') ? 'd-none' : '' }}"
                   href="{{ route('job-notification.index') }}">{{ __('messages.job_notification.job_notifications') }}</a>
            </li>
            <li>
                <a class="dropdown-item {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} {{ Request::is('admin/expired-jobs*') ? 'active' : '' }} {{ !Request::is('admin/jobs*','admin/pending-jobs*','admin/job-categories*','admin/job-types*','admin/job-tags*','admin/job-shifts*','admin/reported-jobs*','admin/job-notification*','admin/expired-jobs*') ? 'd-none' : '' }}"
                   href="{{ route('admin.jobs.expiredJobs') }}">{{ __('messages.expired_jobs') }}</a>
            </li>
        </ul>
    </li>
</div>

<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/post-categories*','admin/posts*','admin/post-comments*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/post-categories*') ? 'active' : '' }}"
       href="{{ route('post-categories.index') }}">{{ __('messages.post_category.post_categories') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/post-categories*','admin/posts*','admin/post-comments*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/posts*') ? 'active' : '' }}"
       href="{{ route('posts.index') }}">{{ __('messages.post.posts') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/post-categories*','admin/posts*','admin/post-comments*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/post-comments*') ? 'active' : '' }}"
       href="{{ route('post.comments') }}">{{ __('messages.post_comments') }}</a>
</li>

<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/plans*','admin/transactions*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/plans*') ? 'active' : '' }}"
       href="{{ route('plans.index') }}">{{ __('messages.subscriptions_plans') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/plans*','admin/transactions*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/transactions*') ? 'active' : '' }}"
       href="{{ route('admin.transactions.index') }}">{{ __('messages.transactions') }}</a>
</li>

<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/subscribers*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/subscribers*') ? 'active' : '' }}"
       href="{{ route('subscribers.index') }}">{{ __('messages.subscribers') }}</a>
</li>

<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/countries*','admin/states*','admin/cities*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/countries*') ? 'active' : '' }}"
       href="{{ route('countries.index') }}">{{ __('messages.country.countries') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/countries*','admin/states*','admin/cities*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/states*') ? 'active' : '' }}"
       href="{{ route('states.index') }}">{{ __('messages.state.states') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/countries*','admin/states*','admin/cities*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/cities*') ? 'active' : '' }}"
       href="{{ route('cities.index') }}">{{ __('messages.city.cities') }}</a>
</li>

<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/marital-status*','admin/skills*','admin/salary-periods*','admin/industries*','admin/company-sizes*','admin/functional-areas*','admin/career-levels*','admin/salary-currencies*','admin/ownership-types*','admin/languages*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/marital-status*') ? 'active' : '' }}"
       href="{{ route('maritalStatus.index') }}">{{ __('messages.marital_statuses') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/marital-status*','admin/skills*','admin/salary-periods*','admin/industries*','admin/company-sizes*','admin/functional-areas*','admin/career-levels*','admin/salary-currencies*','admin/ownership-types*','admin/languages*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/skills*') ? 'active' : '' }}"
       href="{{ route('skills.index') }}">{{ __('messages.skills') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/marital-status*','admin/skills*','admin/salary-periods*','admin/industries*','admin/company-sizes*','admin/functional-areas*','admin/career-levels*','admin/salary-currencies*','admin/ownership-types*','admin/languages*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/salary-periods*') ? 'active' : '' }}"
       href="{{ route('salaryPeriod.index') }}">{{ __('messages.salary_periods') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/marital-status*','admin/skills*','admin/salary-periods*','admin/industries*','admin/company-sizes*','admin/functional-areas*','admin/career-levels*','admin/salary-currencies*','admin/ownership-types*','admin/languages*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/industries*') ? 'active' : '' }}"
       href="{{ route('industry.index') }}">{{ __('messages.industries') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/marital-status*','admin/skills*','admin/salary-periods*','admin/industries*','admin/company-sizes*','admin/functional-areas*','admin/career-levels*','admin/salary-currencies*','admin/ownership-types*','admin/languages*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/company-sizes*') ? 'active' : '' }}"
       href="{{ route('companySize.index') }}">{{ __('messages.company_sizes') }}</a>
</li>
<div class="{{ !Request::is('admin/marital-status*','admin/skills*','admin/salary-periods*','admin/industries*','admin/company-sizes*','admin/functional-areas*','admin/career-levels*','admin/salary-currencies*','admin/ownership-types*','admin/languages*') ? 'd-none' : '' }}">
    <li class="nav-item d-none d-xl-grid dropdown dropdown-hover">
        <a class="nav-link d-flex align-items-center py-3 ps-2" aria-current="page"
           href="javascript:void(0)">
            <span class="horizontal-menu-icon"><i class="fas fa-ellipsis-vertical fs-4"></i></span>
        </a>
        <ul class="horizontal-submenu dropdown-menu top-100">
            <li>
                <a class="dropdown-item {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} {{ Request::is('admin/functional-areas*') ? 'active' : '' }}{{ !Request::is('admin/marital-status*','admin/skills*','admin/salary-periods*','admin/industries*','admin/company-sizes*','admin/functional-areas*','admin/career-levels*','admin/salary-currencies*','admin/ownership-types*','admin/languages*') ? 'd-none' : '' }}"
                   href="{{ route('functionalArea.index') }}">{{ __('messages.functional_areas') }}</a>
            </li>
            <li>
                <a class="dropdown-item {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} {{ Request::is('admin/career-levels*') ? 'active' : '' }} {{ !Request::is('admin/marital-status*','admin/skills*','admin/salary-periods*','admin/industries*','admin/company-sizes*','admin/functional-areas*','admin/career-levels*','admin/salary-currencies*','admin/ownership-types*','admin/languages*') ? 'd-none' : '' }}"
                   href="{{ route('careerLevel.index') }}">{{ __('messages.career_levels') }}</a>
            </li>
            <li>
                <a class="dropdown-item {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} {{ Request::is('admin/salary-currencies*') ? 'active' : '' }} {{ !Request::is('admin/marital-status*','admin/skills*','admin/salary-periods*','admin/industries*','admin/company-sizes*','admin/functional-areas*','admin/career-levels*','admin/salary-currencies*','admin/ownership-types*','admin/languages*') ? 'd-none' : '' }}"
                   href="{{ route('salaryCurrency.index') }}">{{ __('messages.salary_currencies') }}</a>
            </li>
            <li>
                <a class="dropdown-item {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} {{ Request::is('admin/ownership-types*') ? 'active' : '' }} {{ !Request::is('admin/marital-status*','admin/skills*','admin/salary-periods*','admin/industries*','admin/company-sizes*','admin/functional-areas*','admin/career-levels*','admin/salary-currencies*','admin/ownership-types*','admin/languages*') ? 'd-none' : '' }}"
                   href="{{ route('ownerShipType.index') }}">{{ __('messages.ownership_types') }}</a>
            </li>
            <li>
                <a class="dropdown-item {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} {{ Request::is('admin/languages*') ? 'active' : '' }} {{ !Request::is('admin/marital-status*','admin/skills*','admin/salary-periods*','admin/industries*','admin/company-sizes*','admin/functional-areas*','admin/career-levels*','admin/salary-currencies*','admin/ownership-types*','admin/languages*') ? 'd-none' : '' }}"
                   href="{{ route('languages.index') }}">{{ __('messages.languages') }}</a>
            </li>
        </ul>
    </li>
</div>

<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/noticeboards*','admin/faqs*','admin/inquires*','admin/notification-settings*','admin/privacy-policy*','admin/front-settings*','admin/email-template*','admin/settings*','admin/appearance*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/noticeboards*') ? 'active' : '' }}"
       href="{{ route('noticeboards.index') }}">{{ __('messages.noticeboards') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/noticeboards*','admin/faqs*','admin/inquires*','admin/notification-settings*','admin/privacy-policy*','admin/front-settings*','admin/email-template*','admin/settings*','admin/appearance*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/faqs*') ? 'active' : '' }}"
       href="{{ route('faqs.index') }}">{{ __('messages.faq.faq') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/noticeboards*','admin/faqs*','admin/inquires*','admin/notification-settings*','admin/privacy-policy*','admin/front-settings*','admin/email-template*','admin/settings*','admin/appearance*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/inquires*') ? 'active' : '' }}"
       href="{{ route('inquires.index') }}">{{ __('messages.inquires') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/noticeboards*','admin/faqs*','admin/inquires*','admin/notification-settings*','admin/privacy-policy*','admin/front-settings*','admin/email-template*','admin/settings*','admin/appearance*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/notification-settings*') ? 'active' : '' }}"
       href="{{ route('notification.settings.index') }}">{{ __('messages.setting.notification_settings') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mt-3 mb-xl-0 {{ !Request::is('admin/noticeboards*','admin/faqs*','admin/inquires*','admin/notification-settings*','admin/privacy-policy*','admin/front-settings*','admin/email-template*','admin/settings*','admin/appearance*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/appearance*') ? 'active' : '' }}"
       href="{{ route('appearance.index') }}">Appearance</a>
</li>
<div class="{{ !Request::is('admin/noticeboards*','admin/faqs*','admin/inquires*','admin/notification-settings*','admin/privacy-policy*','admin/front-settings*','admin/email-template*','admin/settings*','admin/appearance*') ? 'd-none' : '' }}">
<li class="nav-item d-none d-xl-grid dropdown dropdown-hover">
    <a class="nav-link d-flex align-items-center py-3 ps-2" aria-current="page"
       href="javascript:void(0)">
        <span class="horizontal-menu-icon"><i class="fas fa-ellipsis-vertical fs-4"></i></span>
    </a>
    <ul class="horizontal-submenu dropdown-menu top-100">
        <li>
            <a class="dropdown-item {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} {{ Request::is('admin/privacy-policy*') ? 'active' : '' }} {{ !Request::is('admin/noticeboards*','admin/faqs*','admin/inquires*','admin/notification-settings*','admin/privacy-policy*','admin/front-settings*','admin/email-template*','admin/settings*','admin/appearance*') ? 'd-none' : '' }}"
               href="{{ route('privacy.policy.index') }}">{{ __('messages.setting.privacy_policy') }}</a>
        </li>
        <li>
            <a class="dropdown-item {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} {{ Request::is('admin/front-settings*') ? 'active' : '' }} {{ !Request::is('admin/noticeboards*','admin/faqs*','admin/inquires*','admin/notification-settings*','admin/privacy-policy*','admin/front-settings*','admin/email-template*','admin/settings*','admin/appearance*') ? 'd-none' : '' }}"
               href="{{ route('front.settings.index') }}">{{ __('messages.setting.front_settings') }}</a>
        </li>
        {{-- <li>
            <a class="dropdown-item {{ Request::is('admin/translation-manager*') ? 'active' : '' }} {{ !Request::is('admin/noticeboards*','admin/faqs*','admin/inquires*','admin/notification-settings*','admin/privacy-policy*','admin/front-settings*','admin/translation-manager*','admin/email-template*','admin/settings*') ? 'd-none' : '' }}"
               href="{{ route('translation-manager.index') }}">{{ __('messages.translation_manager') }}</a>
        </li> --}}
        <li>
            <a class="dropdown-item {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} {{ Request::is('admin/email-template*') ? 'active' : '' }} {{ !Request::is('admin/noticeboards*','admin/faqs*','admin/inquires*','admin/notification-settings*','admin/privacy-policy*','admin/front-settings*','admin/email-template*','admin/settings*','admin/appearance*') ? 'd-none' : '' }}"
               href="{{ route('email.template.index') }}">{{ __('messages.email_templates') }}</a>
        </li>
        <li>
            <a class="dropdown-item {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} {{ Request::is('admin/settings*') ? 'active' : '' }} {{ !Request::is('admin/noticeboards*','admin/faqs*','admin/inquires*','admin/notification-settings*','admin/privacy-policy*','admin/front-settings*','admin/email-template*','admin/settings*','admin/appearance*') ? 'd-none' : '' }}"
               href="{{ route('settings.index') }}">{{ __('messages.settings') }}</a>
        </li>
    </ul>
</li>
</div>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/testimonials*','admin/branding-sliders*','admin/header-sliders*','admin/image-sliders*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/testimonials*') ? 'active' : '' }}"
       href="{{ route('testimonials.index') }}">{{ __('messages.testimonials') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/testimonials*','admin/branding-sliders*','admin/header-sliders*','admin/image-sliders*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/branding-sliders*') ? 'active' : '' }}"
       href="{{ route('branding.sliders.index') }}">{{ __('messages.branding_sliders') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/testimonials*','admin/branding-sliders*','admin/header-sliders*','admin/image-sliders*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/header-sliders*') ? 'active' : '' }}"
       href="{{ route('header.sliders.index') }}">{{ __('messages.header_sliders') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/testimonials*','admin/branding-sliders*','admin/header-sliders*','admin/image-sliders*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/image-sliders*') ? 'active' : '' }}"
       href="{{ route('image-sliders.index') }}">{{ __('messages.image_sliders') }}</a>
</li>

<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/cms-services*','admin/cms-about-us*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/cms-services*') ? 'active' : '' }}"
       href="{{ route('cms.services.index') }}">{{ __('messages.cms_services') }}</a>
</li>
<li class="nav-item position-relative mx-xl-3 mb-3 mb-xl-0 {{ !Request::is('admin/cms-services*','admin/cms-about-us*') ? 'd-none' : '' }}">
    <a class="nav-link p-0 {{ Request::is('admin/cms-about-us*') ? 'active' : '' }}"
       href="{{ route('cms.about-us.service') }}">{{ __('messages.about_us_services') }}</a>
</li>
