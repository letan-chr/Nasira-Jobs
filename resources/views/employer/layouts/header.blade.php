@php($notifications = getNotification(\App\Models\Notification::EMPLOYER))
@php($notificationCount = $notifications->count())
<header class='container-fluid container-xxl d-flex align-items-stretch justify-content-between'>
    <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
        <a href="{{ route('front.home') }}"  target="_blank"
           class="text-decoration-none horizontal-sidebar-logo d-flex align-items-center {{ checkLanguageSession() == 'ar' ? 'ps-xl-8' : 'pe-xl-8' }}">
            <div class="image image-mini {{ checkLanguageSession() == 'ar' ? 'ms-3' : 'me-3' }}">
                <img src="{{getLogoUrl()}}"
                     class="img-fluid" alt="profile image">
            </div>
            <span class="text-gray-900 fs-4 d-none d-sm-block"> {{ getAppName() }}</span>
        </a>
    </div>
    <div class="d-flex align-items-stretch justify-content-xl-between justify-content-end flex-grow-1">
        <nav class="navbar navbar-expand-xl navbar-light horizontal-sidebar d-xl-flex d-block align-items-stretch py-3 py-xl-0"
             id="nav-header">
            @include('employer.layouts.sidebar')
        </nav>
        <ul class="nav align-items-stretch flex-nowrap">
            <li class="px-xxl-3 px-2 d-flex align-items-stretch">
                <a href="{{ route('theme.mode') }}" class="d-flex align-items-center" >
                    <i class="fas user-check-icon {{ getLoggedInUser()->theme_mode ? 'fa-sun' : 'fa-moon' }} fs-2"></i>
                </a>
            </li>
            <li class="px-xxl-3 px-2 d-flex align-items-stretch">
                <div class="dropdown custom-dropdown d-flex align-items-stretch">
                    <button class="btn dropdown-toggle hide-arrow p-0 d-flex align-items-center"
                            type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="position-relative">
                            <i class="fa-solid fa-bell text-primary fs-2"></i>
                            @if($notificationCount > 0)
                                <span class="position-absolute notification-count top-0 start-100 translate-middle badge badge-circle bg-danger" id="counter">
                    {{ ($notificationCount) }}
                    <span class="visually-hidden">{{ __('messages.unread_messages') }}</span>
                            @endif
                        </div>
                    </button>
                    <div class="dropdown-menu py-0" aria-labelledby="dropdownMenuButton1">
                        <div class="{{ checkLanguageSession() == 'ar' ? 'text-end' : 'text-start' }} border-bottom py-4 px-7">
                            <h3 class="text-gray-900 mb-0">{{__('messages.notification.notifications')}}</h3>
                        </div>
                        <div class="px-7 mt-5 inner-scroll height-270">
                            @if($notificationCount > 0)
                                @foreach($notifications as $notification)
                                    <div class="d-flex position-relative mb-5 readNotification cursor-pointer"
                                         data-id="{{ $notification->id }}" id="readNotification">
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
                                <h5 class="text-primary mb-0 fs-5 cursor-pointer"
                                    id="readAllNotification">{{ __('messages.notification.mark_all_as_read') }}</h5>
                            </div>
                        @endif
                    </div>

                </div>
            </li>

            <li class="px-xxl-3 px-2 d-flex align-items-stretch">
                <div class="dropdown dropdown-transparent d-flex align-items-stretch">
                    <button class="btn dropdown-toggle px-0 text-gray-600 d-flex align-items-center" type="button"
                            id="dropdownMenuButton1" data-bs-auto-close="outside"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="image image-circle image-mini d-flex align-items-center {{ checkLanguageSession() == 'ar' ? 'ms-sm-3' : 'me-sm-3' }}">
                            <img src="{{ getLoggedInUser()->avatar }}"
                                 class="img-fluid" alt="profile image">
                        </div>
                        {{\Illuminate\Support\Facades\Auth::user()->full_name}}
                        {{--                        <i class="fa-solid fa-angle-down ms-2"></i>--}}
                    </button>
                    <div class="dropdown-menu py-7 pb-4" aria-labelledby="dropdownMenuButton1"
                         data-bs-auto-close="outside">
                        <div class="text-center border-bottom pb-5 ">
                            <div class="image image-circle image-tiny mb-5">
                                <img src="{{ getLoggedInUser()->avatar }}" class="img-fluid" alt="profile image">
                            </div>
                            <h3 class="text-gray-900">{{\Illuminate\Support\Facades\Auth::user()->full_name}}</h3>
                            <h4 class="mb-0 fw-400 fs-6">{{\Illuminate\Support\Facades\Auth::user()->email}}</h4>
                        </div>
                        <ul class="pt-4 pe-0">
                            <li>
                                <a href="javascript:void(0)" class="dropdown-item text-gray-900 editProfileModal {{ checkLanguageSession() == 'ar' ? 'text-end' : '' }}"
                                   data-id="{{ getLoggedInUserId() }}">
                                     <span class="dropdown-icon {{ checkLanguageSession() == 'ar' ? 'ms-4' : 'me-4' }} text-gray-600">
                                        <i class="fa-solid fa-user"></i>
                                     </span> {{ __('messages.user.edit_profile') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item text-gray-900 changePasswordModal {{ checkLanguageSession() == 'ar' ? 'text-end' : '' }}"
                                   href="javascript:void(0)" data-id="{{ getLoggedInUserId() }}">
                                    <span class="dropdown-icon {{ checkLanguageSession() == 'ar' ? 'ms-4' : 'me-4' }} text-gray-600">
                                        <i class="fa-solid fa-lock"></i>
                                    </span> {{ (Str::limit(__('messages.user.change_password'),20,'...')) }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-gray-900 changeLanguageModal {{ checkLanguageSession() == 'ar' ? 'text-end' : '' }}"
                                   href="javascript:void(0)" data-id="{{ getLoggedInUserId() }}">
                                    <span class="dropdown-icon {{ checkLanguageSession() == 'ar' ? 'ms-4' : 'me-4' }} text-gray-600">
                                        <i class="fa-solid fa-globe"></i>
                                    </span> {{ (Str::limit(__('messages.user_language.change_language'),20,'...')) }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-gray-900 {{ checkLanguageSession() == 'ar' ? 'text-end' : '' }}" href="{{ url('logout') }}"
                                   onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();">
                                    <span class="dropdown-icon {{ checkLanguageSession() == 'ar' ? 'ms-4' : 'me-4' }} text-gray-600">
                                        <i class="fa-solid fa-right-from-bracket"></i>
                                    </span> {{ __('messages.user.logout') }}
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            <li class="d-flex align-items-center">
                <button type="button" class="btn px-0 horizontal-menubar d-block d-xl-none text-gray-600">
                    <i class="fa-solid fa-bars fs-1"></i>
                </button>
            </li>
        </ul>
    </div>
</header>
<div class="bg-overlay" id="horizontal-menubar-overly"></div>
