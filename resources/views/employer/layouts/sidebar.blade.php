<div class="ps-xl-7 px-2 pe-xl-0 d-flex align-items-stretch">
    <ul class="horizontal-menu nav flex-row d-block d-xl-flex">
        <li class="nav-item {{ Request::is('employer/dashboard*') ? 'active' : ''}}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{ route('employer.dashboard') }}">
                <span class="horizontal-menu-icon"><i class="fab fa-dashcube"></i></span>
                <span class="horizontal-menu-title">{{ __('messages.dashboard') }}</span>
            </a>
        </li>
        <li class="nav-item {{ \Illuminate\Support\Facades\Route::is('company.edit.form') ? 'active' : ''}}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{ route('company.edit.form', \Illuminate\Support\Facades\Auth::user()->owner_id) }}">
                <span class="horizontal-menu-icon"><i class="far fa-user-circle"></i></span>
                <span class="horizontal-menu-title">{{ __('messages.employer_menu.employer_profile') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('employer/jobs*') ? 'active' : ''}}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{ route('job.index') }}">
                <span class="horizontal-menu-icon"><i class="far fa-star"></i></span>
                <span class="horizontal-menu-title">{{ __('messages.employer_menu.jobs') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('employer/job-stage*') ? 'active' : ''}}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{ route('job.stage.index') }}">
                <span class="horizontal-menu-icon"><i class="far fa-building"></i></span>
                <span class="horizontal-menu-title">{{ __('messages.job_stages') }}</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('employer/followers*') ? 'active' : ''}}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{ route('followers.index') }}">
                <span class="horizontal-menu-icon"><i class="fas fa-briefcase"></i></span>
                <span class="horizontal-menu-title">{{ __('messages.employer_menu.followers') }}</span>
            </a>
        </li>
        <li class="nav-item d-none d-xl-grid dropdown dropdown-hover {{ Request::is('employer/transactions*','employer/manage-subscription*') ? 'active' : '' }}">
            <a class="nav-link d-flex align-items-center py-3 ps-2" aria-current="page"
               href="javascript:void(0)">
                <span class="horizontal-menu-icon"><i class="fas fa-ellipsis-vertical fs-4"></i></span>
            </a>
            <ul class="horizontal-submenu dropdown-menu top-100">
                <li>
                    <a class="dropdown-item {{ Request::is('employer/transaction*') ? 'active' : '' }} {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }}"
                       href="{{ route('transactions.index') }}">
                        <span class="horizontal-menu-icon me-1"><i class="fas fa-money-bill fs-6"></i></span>
                        <span class="horizontal-menu-title fs-6">{{ __('messages.employer_menu.transactions') }}</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item {{ Request::is('employer/manage-subscription*') ? 'active' : '' }} {{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }}"
                       href="{{ route('manage-subscription.index') }}">
                        <span class="horizontal-menu-icon me-1"><i class="fab fa-bandcamp fs-6"></i></span>
                        <span class="horizontal-menu-title fs-6">{{ __('messages.employer_menu.manage_subscriptions') }}</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- start side bar menu for bar--}}
        <li class="nav-item d-xl-none {{ Request::is('employer/transaction*') ? 'active' : ''}}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{ route('transactions.index') }}">
                <span class="horizontal-menu-icon me-1"><i class="fas fa-money-bill"></i></span>
                <span class="horizontal-menu-title">{{ __('messages.employer_menu.transactions') }}</span>
            </a>
        </li>
        <li class="nav-item d-xl-none {{ Request::is('employer/manage-subscription*') ? 'active' : ''}}">
            <a class="nav-link d-flex align-items-center py-3" aria-current="page"
               href="{{ route('manage-subscription.index') }}">
                <span class="horizontal-menu-icon me-1"><i class="fab fa-bandcamp "></i></span>
                <span class="horizontal-menu-title">{{ __('messages.employer_menu.manage_subscriptions') }}</span>
            </a>
        </li>
        {{-- end side bar menu for bar--}}
    </ul>
</div>
