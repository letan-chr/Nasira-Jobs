{{-- <link href="{{ mix('assets/css/style.css') }}" rel="stylesheet" type="text/css"/> --}}
<div class="aside-menu-container" id="sidebar">
    <!--begin::Brand-->
    <div class="aside-menu-container__aside-logo flex-column-auto">
        <a data-turbo="false" href="{{ url('/') }}" target="_blank" data-toggle="tooltip" data-placement="right"
            class="text-decoration-none sidebar-logo image image-mini" title="{{ getAppName() }}">
            <img src="{{ getLogoUrl() }}" alt="Logo" width="70px" height="30px" alt="Logo"
                class="img-fluid new-logo-image" />
            <span class="navbar-brand-name text-dark text-decoration-none logo ps-2" tooltip= "{{ getAppName() }}">
                {!! substr(strip_tags(getAppName()), 0, 15) . (strlen(getAppName()) > 15 ? '...' : '') !!}</span>
        </a>

        <button type="button" class="btn px-0 aside-menu-container__aside-menubar d-lg-block d-none sidebar-btn">
            <i class="fa-solid fa-bars fs-1"></i>
        </button>

    </div>
    <!--end::Brand-->
    <form class="d-flex position-relative aside-menu-container__aside-search search-control py-3 mt-1">
        <div class="position-relative w-100 sidebar-search-box">
            <input class="form-control" type="text" placeholder={{ __('messages.common.search') }} id="menuSearch"
                aria-label="Search" name="search">
            <span
                class="aside-menu-container__search-icon position-absolute d-flex align-items-center top-0 left-50 bottom-0">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
        </div>
    </form>
    <div class="no-record text-center d-none">{{ __('messages.common.no_found_record') }}</div>
    <div class="sidebar-scrolling overflow-auto">
        <ul class="aside-menu-container__aside-menu nav flex-column">
            @include('layouts.menu')
        </ul>
    </div>
</div>
<div class="bg-overlay" id="sidebar-overly"></div>
