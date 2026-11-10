<li class="nav-item {{ Request::is('admin/dashboard*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('admin.dashboard') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fas fa fa-digital-tachograph"></i></span>
        <span class="aside-menu-title">{{ __('messages.dashboard') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('admin/employers*','admin/reported-employers*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('company.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fas fa-user-friends"></i></span>
        <span class="aside-menu-title">{{ __('messages.employers') }}</span>
        <span class="d-none">{{ __('messages.employers') }}</span>
        <span class="d-none">{{ __('messages.company.reported_employers') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('admin/admin*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('admin.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fa-solid fa-user-tie"></i></span>
        <span class="aside-menu-title">{{ __('messages.candidate.admins') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('admin/roles*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('roles.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fas fa-user-shield"></i></span>
        <span class="aside-menu-title">{{ __('messages.roles') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('admin/candidates*','admin/degree-levels*','admin/reported-candidates*','admin/resumes*','admin/selected-candidate*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('candidates.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fas fa-user-circle"></i></span>
        <span class="aside-menu-title">{{ __('messages.candidates') }}</span>
        <span class="d-none">{{ __('messages.candidates') }}</span>
        <span class="d-none">{{ __('messages.required_degree_levels') }}</span>
        <span class="d-none">{{ __('messages.candidate.reported_candidates') }}</span>
        <span class="d-none">{{ __('messages.all_resumes') }}</span>
        <span class="d-none">{{ __('messages.selected_candidate') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('admin/jobs*','admin/pending-jobs*','admin/job-categories*','admin/job-types*','admin/job-tags*','admin/job-shifts*','admin/reported-jobs*','admin/job-notification*','admin/expired-jobs*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('admin.jobs.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fas fa-briefcase"></i></span>
        <span class="aside-menu-title">{{ __('messages.jobs') }}</span>
        <span class="d-none">{{ __('messages.jobs') }}</span>
        <span class="d-none">{{ __('messages.job_categories') }}</span>
        <span class="d-none">{{ __('messages.job_types') }}</span>
        <span class="d-none">{{ __('messages.job_tags') }}</span>
        <span class="d-none">{{ __('messages.job_shifts') }}</span>
        <span class="d-none">{{ __('messages.reported_jobs') }}</span>
        <span class="d-none">{{ __('messages.job_notification.job_notifications') }}</span>
        <span class="d-none">{{ __('messages.expired_jobs') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('admin/post-categories*','admin/posts*','admin/post-comments*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('post-categories.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="far fa-list-alt"></i></span>
        <span class="aside-menu-title">{{ __('messages.blogs') }}</span>
        <span class="d-none">{{ __('messages.post_category.post_categories') }}</span>
        <span class="d-none">{{ __('messages.post.posts') }}</span>
        <span class="d-none">{{ __('messages.post_comments') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('admin/plans*','admin/transactions*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('plans.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fab fa-bandcamp"></i></span>
        <span class="aside-menu-title">{{ __('messages.plan.subscriptions') }}</span>
        <span class="d-none">{{ __('messages.post_comments') }}</span>
        <span class="d-none">{{ __('messages.subscriptions_plans') }}</span>
    </a>
</li>
<li class="nav-item {{ Request::is('admin/subscribers*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('subscribers.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fas fa-bell"></i></span>
        <span class="aside-menu-title">{{ __('messages.subscribers') }}</span>
        <span class="d-none">{{ __('messages.subscribers') }}</span>
        <span class="d-none">{{ __('messages.transactions') }}</span>

    </a>
</li>
<li class="nav-item {{ Request::is('admin/countries*','admin/states*','admin/cities*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('countries.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fas fa-globe-americas"></i></span>
        <span class="aside-menu-title">{{ __('messages.country.countries') }}</span>
        <span class="d-none">{{ __('messages.country.countries') }}</span>
        <span class="d-none">{{ __('messages.state.states') }}</span>
        <span class="d-none">{{ __('messages.city.cities') }}</span>

    </a>
</li>
<li class="nav-item {{ Request::is('admin/marital-status*','admin/skills*','admin/salary-periods*','admin/industries*','admin/company-sizes*','admin/functional-areas*','admin/career-levels*','admin/salary-currencies*','admin/ownership-types*','admin/languages*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('maritalStatus.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fas fa-life-ring"></i></span>
        <span class="aside-menu-title">{{ __('messages.general') }}</span>
        <span class="d-none">{{ __('messages.marital_statuses') }}</span>
        <span class="d-none">{{ __('messages.skills') }}</span>
        <span class="d-none">{{ __('messages.salary_periods') }}</span>
        <span class="d-none">{{ __('messages.industries') }}</span>
        <span class="d-none">{{ __('messages.company_sizes') }}</span>
        <span class="d-none">{{ __('messages.functional_areas') }}</span>
        <span class="d-none">{{ __('messages.career_levels') }}</span>
        <span class="d-none">{{ __('messages.salary_currencies') }}</span>
        <span class="d-none">{{ __('messages.ownership_types') }}</span>
        <span class="d-none">{{ __('messages.languages') }}</span>

    </a>
</li>
<li class="nav-item {{ Request::is('admin/noticeboards*','admin/faqs*','admin/inquires*','admin/notification-settings*','admin/privacy-policy*','admin/front-settings*','admin/email-template*','admin/settings*','admin/appearance*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('noticeboards.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fas fa-sticky-note"></i></span>
        <span class="aside-menu-title">{{ __('messages.cms') }}</span>
        <span class="d-none">{{ __('messages.noticeboards') }}</span>
        <span class="d-none">{{ __('messages.faq.faq') }}</span>
        <span class="d-none">{{ __('messages.inquires') }}</span>
        <span class="d-none">{{ __('messages.setting.notification_settings') }}</span>
        <span class="d-none">{{ __('messages.setting.privacy_policy') }}</span>
        <span class="d-none">{{ __('messages.setting.front_settings') }}</span>
        <span class="d-none">{{ __('messages.translation_manager') }}</span>
        <span class="d-none">{{ __('messages.email_templates') }}</span>
        <span class="d-none">{{ __('messages.settings') }}</span>
        <span class="d-none">Appearance</span>

    </a>
</li>
<li class="nav-item {{ Request::is('admin/testimonials*','admin/branding-sliders*','admin/header-sliders*','admin/image-sliders*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('testimonials.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fas fa-sticky-note"></i></span>
        <span class="aside-menu-title">{{ __('messages.cms_sliders') }}</span>
        <span class="d-none">{{ __('messages.testimonials') }}</span>
        <span class="d-none">{{ __('messages.branding_sliders') }}</span>
        <span class="d-none">{{ __('messages.header_sliders') }}</span>
        <span class="d-none">{{ __('messages.image_sliders') }}</span>

    </a>
</li>
<li class="nav-item {{ Request::is('admin/cms-services*','admin/cms-about-us*') ? 'active' : '' }}">
    <a class="nav-link d-flex align-items-center py-3" aria-current="page" href="{{ route('cms.services.index') }}">
        <span class="aside-menu-icon {{ checkLanguageSession() == 'ar' ? 'ps-3' : 'pe-3' }}"><i class="fas fa-sticky-note"></i></span>
        <span class="aside-menu-title">{{ __('messages.front_cms') }}</span>
        <span class="d-none">{{ __('messages.cms_services') }}</span>
        <span class="d-none">{{ __('messages.about_us_services') }}</span>

    </a>
</li>
