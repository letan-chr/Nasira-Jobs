@php($notifications = getNotification(\App\Models\Notification::ADMIN))@php($notificationCount = $notifications->count())
<header class='d-flex align-items-center justify-content-between flex-grow-1 header px-4 px-lg-7 px-xl-0'>
    <button type="button" class="btn px-0 aside-menu-container__aside-menubar d-block d-xl-none sidebar-btn">
        <i class="fa-solid fa-bars fs-1"></i>
    </button>
    <nav class="navbar navbar-expand-xl navbar-light top-navbar d-xl-flex d-block px-3 px-xl-0 py-4 py-xl-0 " id="nav-header">
        <div class="container-fluid">
            <div class="navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @include('layouts.sub_menu')
                </ul>
            </div>
        </div>
    </nav>
    <ul class="nav align-items-center">
        @if(getLoggedInUser()->theme_mode)
            <li class="px-sm-3 px-2">
                <a  href="{{ route('theme.mode') }}" title="Switch to Light Mode">
                    <i class="fa-solid fa-sun text-primary fs-2"></i>
                </a>
            </li>
        @else
            <li class="px-sm-3 px-2">
                <a  href="{{ route('theme.mode') }}" title="Switch to Dark Mode">
                    <i class="fa-solid fa-moon text-primary fs-2"></i>
                </a>
            </li>
        @endif

        <li class="px-sm-3 px-2">
            <div class="dropdown custom-dropdown d-flex align-items-center py-4">
                <button class="btn dropdown-toggle hide-arrow {{ checkLanguageSession() == 'ar' ? 'pe-2 ps-0' : 'ps-2 pe-0' }} py-0 position-relative" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-bell text-primary fs-2"></i>
                    @if($notificationCount > 0)
                    <span class="position-absolute notification-count top-0 start-100 translate-middle badge badge-circle bg-danger" id="counter">
                    {{ ($notificationCount) }}
                    <span class="visually-hidden">unread messages</span>
                    @endif
                </span>
                </button>
                <div class="dropdown-menu py-0 my-2" aria-labelledby="dropdownMenuButton1">
                    <div class="{{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} border-bottom py-4 px-7">
                        <h3 class="text-gray-900 mb-0">{{__('messages.notification.notifications')}}</h3>
                    </div>
                    <div class="px-7 mt-5 inner-scroll height-270">
                        @if($notificationCount > 0)
                            @foreach($notifications as $notification)
                                <div class="d-flex position-relative mb-5 readNotification cursor-pointer" data-id="{{ $notification->id }}" id="readNotification">
                                    <span class="{{ checkLanguageSession() == 'ar' ? 'ms-5' : 'me-5' }} text-primary fs-2 icon-label">
                                        <i class="{{ getNotificationIcon($notification->type) }}"></i></span>
                                    <div>
                                        <h5 class="text-gray-900 fs-6 mb-2">{{$notification->title}}</h5>
                                        <h6 class="text-gray-600 fs-small fw-light mb-0">
                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans(null, true)}}</h6>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state fs-6 text-gray-800 fw-bold text-center mt-5" data-height="400">
                                <p>{{ __('messages.notification.empty_notifications') }}</p>
                            </div>
                        @endif
                            <div class="empty-state fs-6 text-gray-800 fw-bold text-center mt-5 d-none"
                                 data-height="400">
                                <p>{{ __('messages.notification.empty_notifications') }}</p>
                            </div>
                    </div>
                    @if($notificationCount > 0)
                    <div class="text-center border-top p-4">
                        <h5 class="text-primary mb-0 fs-5 cursor-pointer" id="readAllNotification">{{ __('messages.notification.mark_all_as_read') }}</h5>
                    </div>
                    @endif
                </div>
            </div>
        </li>
        <li class="px-sm-3 px-2">
            <div class="dropdown d-flex align-items-center py-4">
                <div class="image image-circle image-mini">
                    <img src="{{ getLoggedInUser()->avatar }}"
                         class="img-fluid" alt="profile image">
                </div>
                <button class="btn dropdown-toggle {{ checkLanguageSession() == 'ar' ? 'pe-2 ps-0' : 'ps-2 pe-0' }} hide-arrow" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    {{ getLoggedInUser()->full_name }}
                </button>
                <div class="dropdown-menu py-7 pb-4 my-2" aria-labelledby="dropdownMenuButton1"
                     data-bs-auto-close="outside">
                    <div class="text-center border-bottom pb-5">
                        <div class="image image-circle image-tiny mb-5">
                            <img src="{{ getLoggedInUser()->avatar }}" class="img-fluid" alt="profile image">
                        </div>
                        <h3 class="text-gray-900">{{ getLoggedInUser()->full_name }}</h3>
                        <h4 class="mb-0 fw-400 fs-6">{{ getLoggedInUser()->email }}</h4>
                    </div>
                    <ul class="pt-4 pe-0">
                        <li>
                            <a class="dropdown-item text-gray-900 editAdminProfileModal {{ checkLanguageSession() == 'ar' ? 'text-end' : '' }}" href="javascript:void(0)"
                               data-id="{{ getLoggedInUserId() }}">
                            <span class="dropdown-icon {{ checkLanguageSession() == 'ar' ? 'ms-4' : 'me-4' }} text-gray-600">
                                <i class="fa fa-user"></i>
                            </span>
                                {{ __('messages.user.edit_profile') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-gray-900 changeAdminPasswordModal {{ checkLanguageSession() == 'ar' ? 'text-end' : '' }}" href="javascript:void(0)"
                               data-id="{{ getLoggedInUserId() }}">
                            <span class="dropdown-icon {{ checkLanguageSession() == 'ar' ? 'ms-4' : 'me-4' }} text-gray-600">
                                <i class="fa fa-lock"></i>
                            </span>
                                {{ (Str::limit(__('messages.user.change_password'),20,'...')) }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-gray-900 changeAdminLanguageModal {{ checkLanguageSession() == 'ar' ? 'text-end' : '' }}" id="changeLanguage"
                               href="javascript:void(0)"
                               data-id="{{ getLoggedInUserId() }}">
                               <span class="dropdown-icon {{ checkLanguageSession() == 'ar' ? 'ms-4' : 'me-4' }} text-gray-600">
                                   <i class="fa fa-language"></i>
                               </span>
                                {{ (Str::limit(__('messages.user_language.change_language'),20,'...')) }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-gray-900 d-flex {{ checkLanguageSession() == 'ar' ? 'text-end' : '' }}" href="javascript:void(0)">
                                <span class="dropdown-icon {{ checkLanguageSession() == 'ar' ? 'ms-4' : 'me-4' }} text-gray-600">
                                    <i class="fas fa-sign-out-alt"></i>
                                </span>
                                <form id="logout-form" action="{{url('/logout')}}" method="post">
                                    @csrf
                                </form>
                                <span onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                                    {{ __('messages.user.logout') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li>
            <button type="button" class="btn px-0 d-block d-xl-none header-btn pb-2">
                <i class="fa-solid fa-bars fs-1"></i>
            </button>
        </li>
    </ul>
</header>
<div class="bg-overlay" id="nav-overly"></div>
