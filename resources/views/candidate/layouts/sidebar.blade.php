<div class="{{ checkLanguageSession() == 'ar' ? 'ps-xl-0' : 'ps-xl-7' }} px-2 pe-xl-0 d-flex align-items-stretch">
    <ul class="horizontal-menu nav flex-row d-block d-xl-flex">
        <li class="nav-item {{ Request::is('candidate/dashboard*') ? 'active' : ''}}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{ route('dashboard') }}">
                <span class="horizontal-menu-icon"><i class="fab fa-dashcube"></i></span>
                <span class="horizontal-menu-title">{{ __('messages.candidate.dashboard') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('candidate/profile*') ? 'active' : ''}}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{ route('candidate.profile') }}">
                <span class="horizontal-menu-icon"><i class="far fa-user-circle"></i></span>
                <span class="horizontal-menu-title">{{ __('messages.profile') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('candidate/favourite-jobs*') ? 'active' : ''}}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{ route('favourite.jobs') }}">
                <span class="horizontal-menu-icon"><i class="far fa-star"></i></span>
                <span class="horizontal-menu-title">{{ __('messages.favourite_jobs') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('candidate/favourite-companies*') ? 'active' : ''}}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{ route('favourite.companies') }}">
                <span class="horizontal-menu-icon"><i class="far fa-building"></i></span>
                <span class="horizontal-menu-title">{{ __('messages.favourite_companies') }}</span>
            </a>
        </li>
        @if(getCurrentLanguageCode() == 'de' || getCurrentLanguageCode() == 'tr' || getCurrentLanguageCode() == 'pt' || getCurrentLanguageCode() == 'ru' || getCurrentLanguageCode() == 'es' || getCurrentLanguageCode() == 'fr')
            <li class="nav-item d-none d-xl-grid dropdown dropdown-hover {{ Request::is('candidate/applied-job*','candidate/job-alerts*') ? 'active' : '' }}">
                <a class="nav-link d-flex align-items-center py-3 ps-2" aria-current="page"
                   href="javascript:void(0)">
                    <span class="horizontal-menu-icon"><i class="fas fa-ellipsis-vertical fs-4"></i></span>
                </a>
                <ul class="horizontal-submenu dropdown-menu top-100">
                    <li>
                        <a class="dropdown-item {{ Request::is('candidate/applied-job*') ? 'active' : '' }}"
                           href="{{ route('candidate.applied.job') }}">
                            <span class="horizontal-menu-icon me-1"><i class="fas fa-briefcase fs-6"></i></span>
                            <span class="horizontal-menu-title fs-6">{{ __('messages.applied_job.applied_jobs') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item {{ Request::is('candidate/job-alerts*') ? 'active' : '' }}"
                           href="{{ route('candidate.job.alert') }}">
                            <span class="horizontal-menu-icon me-1"><i class="far fa-bell fs-6"></i></span>
                            <span class="horizontal-menu-title fs-6">{{ __('messages.job.job_alert') }}</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- start side bar menu for bar--}}
            <li class="nav-item d-xl-none {{ Request::is('candidate/applied-job*') ? 'active' : ''}}">
                <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                   href="{{ route('candidate.applied.job') }}">
                    <span class="horizontal-menu-icon me-1"><i class="fas fa-briefcase"></i></span>
                    <span class="horizontal-menu-title">{{ __('messages.applied_job.applied_jobs') }}</span>
                </a>
            </li>
            <li class="nav-item d-xl-none {{ Request::is('candidate/job-alerts*') ? 'active' : ''}}">
                <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                   href="{{ route('candidate.job.alert') }}">
                    <span class="horizontal-menu-icon me-1"><i class="far fa-bell"></i></span>
                    <span class="horizontal-menu-title">{{ __('messages.job.job_alert') }}</span>
                </a>
            </li>
            {{-- end side bar menu for bar--}}
        @else
            <li class="nav-item {{ Request::is('candidate/applied-job*') ? 'active' : ''}}">
                <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                   href="{{ route('candidate.applied.job') }}">
                    <span class="horizontal-menu-icon"><i class="fas fa-briefcase"></i></span>
                    <span class="horizontal-menu-title">{{ __('messages.applied_job.applied_jobs') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('candidate/job-alerts*') ? 'active' : ''}}">
                <a class="nav-link d-flex align-items-center py-3" aria-current="page"
                   href="{{ route('candidate.job.alert') }}">
                    <span class="horizontal-menu-icon"><i class="far fa-bell"></i></span>
                    <span class="horizontal-menu-title">{{ __('messages.job.job_alert') }}</span>
                </a>
            </li>
        @endif
    </ul>
</div>
