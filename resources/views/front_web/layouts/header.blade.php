@php
    $solutionGroups = \App\Support\SolutionsCatalog::megaGroups();
@endphp
<header class="nasira-header">
    <nav class="navbar navbar-expand-lg nasira-navbar">
        <div class="container nasira-nav-shell">
            <a class="navbar-brand nasira-brand" href="{{ url('/') }}">
                <img src="{{ asset('front_web/images/nasira-logo.png') }}" alt="{{ getAppName() }}" />
            </a>

            <div class="nasira-nav-mobile-tools">
                <a href="{{ route('front.search.jobs') }}" class="nasira-icon-btn d-lg-none" aria-label="Search jobs">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>
                <button class="navbar-toggler nasira-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="nasira-toggler-lines" id="toggler-icon">
                        <span class="icon-bar top-bar"></span>
                        <span class="icon-bar middle-bar"></span>
                        <span class="icon-bar bottom-bar"></span>
                    </span>
                </button>
            </div>

            <div class="collapse navbar-collapse nasira-nav-collapse" id="navbarNav">
                <ul class="navbar-nav nasira-nav-links">
                    <li class="nav-item">
                        <a class="nasira-nav-link nav-link {{ Request::is('/') ? 'is-active' : '' }}"
                            href="{{ route('front.home') }}">{{ __('web.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nasira-nav-link nav-link {{ Request::is('search-jobs') || Request::is('job-details*') ? 'is-active' : '' }}"
                            href="{{ route('front.search.jobs') }}">{{ __('web.jobs') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nasira-nav-link nav-link {{ Request::is('company-lists') || Request::is('company-details*') ? 'is-active' : '' }}"
                            href="{{ route('front.company.lists') }}">{{ __('web.companies') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nasira-nav-link nav-link {{ Request::is('cv-design*') ? 'is-active' : '' }}"
                            href="{{ route('front.cv.design') }}">CV Design</a>
                    </li>
                    <li class="nav-item nasira-solutions-item">
                        <a class="nasira-nav-link nav-link nasira-solutions-trigger {{ Request::is('solutions*') ? 'is-active' : '' }}"
                            href="{{ route('front.solutions') }}">
                            Solutions <i class="fa-solid fa-chevron-down nasira-solutions-caret" aria-hidden="true"></i>
                        </a>
                        <div class="nasira-solutions-mega" role="menu">
                            <div class="nasira-solutions-mega-inner">
                                @foreach ($solutionGroups as $groupKey => $group)
                                    <div class="nasira-solutions-col {{ $groupKey === 'convert' ? 'nasira-solutions-col--convert' : '' }}" data-group="{{ $groupKey }}">
                                        <div class="nasira-solutions-col-head">
                                            <span class="nasira-solutions-col-title">{{ $group['title'] }}</span>
                                        </div>
                                        <ul class="nasira-solutions-list {{ $groupKey === 'convert' ? 'nasira-solutions-list--multi-col' : '' }}">
                                            @foreach ($group['items'] as $item)
                                                <li>
                                                    <a href="{{ !empty($item['route']) ? route($item['route']) : route('front.solutions.show', $item['slug']) }}">
                                                        <i class="fa-solid {{ $item['icon'] }}" aria-hidden="true"></i>
                                                        <span>{{ $item['name'] }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                            <div class="nasira-solutions-mega-foot">
                                <a href="{{ route('front.solutions') }}" class="nasira-solutions-all">
                                    View all tools <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nasira-nav-link nav-link {{ Request::is('posts*') ? 'is-active' : '' }}"
                            href="{{ route('front.post.lists') }}">Tips</a>
                    </li>
                    <li class="nav-item">
                        <a class="nasira-nav-link nav-link {{ Request::is('about-us') ? 'is-active' : '' }}"
                            href="{{ route('front.about.us') }}">About</a>
                    </li>
                </ul>

                <div class="nasira-nav-cta">
                    <a href="{{ route('front.search.jobs') }}" class="nasira-icon-btn d-none d-lg-inline-flex" aria-label="Search jobs">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </a>

                    @if (!Auth::check())
                        <div class="nasira-auth-group">
                            <a href="{{ route('front.candidate.login') }}" class="btn btn-nasira-login">
                                {{ __('web.login') }}
                            </a>
                        </div>
                    @else
                        <div class="nav-item nasira-dd nasira-user-dd">
                            <a href="javascript:void(0)" class="nasira-user-chip user-logo">
                                <img src="{{ getLoggedInUser()->avatar }}" alt="" />
                                <span class="nasira-user-name">{{ getLoggedInUser()->full_name }}</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </a>
                            <ul class="nav submenu nasira-submenu">
                                <li class="nav-item">
                                    <a href="{{ dashboardURL() }}" class="nav-link">{{ __('web.go_to_dashboard') }}</a>
                                </li>
                                @role('Candidate')
                                    <li class="nav-item">
                                        <a href="{{ route('candidate.profile') }}" class="nav-link">{{ __('web.my_profile') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('favourite.jobs') }}" class="nav-link">{{ __('messages.favourite_jobs') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('favourite.companies') }}" class="nav-link">{{ __('messages.candidate_dashboard.followings') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('candidate.applied.job') }}" class="nav-link">{{ __('messages.applied_job.applied_jobs') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('candidate.job.alert') }}" class="nav-link">{{ __('messages.job.job_alert') }}</a>
                                    </li>
                                @endrole
                                @role('Employer')
                                    <li class="nav-item">
                                        <a href="{{ route('company.edit.form', \Illuminate\Support\Facades\Auth::user()->owner_id) }}" class="nav-link">{{ __('web.my_profile') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('job.index') }}" class="nav-link">{{ __('messages.employer_menu.jobs') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('followers.index') }}" class="nav-link">{{ __('messages.employer_menu.followers') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('manage-subscription.index') }}" class="nav-link">{{ __('messages.employer_menu.manage_subscriptions') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('transactions.index') }}" class="nav-link">{{ __('messages.employer_menu.transactions') }}</a>
                                    </li>
                                @endrole
                                <li class="nav-item">
                                    <a href="{{ url('logout') }}" class="nav-link"
                                        onclick="event.preventDefault(); localStorage.clear(); document.getElementById('logout-form').submit();">
                                        {{ __('web.logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>
