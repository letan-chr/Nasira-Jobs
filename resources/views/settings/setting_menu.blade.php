<div class="">
    <div class="pt-2 pb-0">
        <div class="d-flex overflow-auto">
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 flex-nowrap">
                <li class="nav-item">
                    <a class="nav-link text-active-primary me-6 {{ (isset($sectionName) && $sectionName == 'general' || Request::is('settings*')) ? 'text-primary' : ''}}"
                       href="{{ route('settings.index', ['section' => 'general']) }}">{{ __('messages.general') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary me-6 {{ (isset($sectionName) && $sectionName == 'front_office_details') ? 'text-primary' : ''}}"
                       href="{{ route('settings.index', ['section' => 'front_office_details']) }}">  {{ __('messages.footer_settings') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary me-6 {{ (isset($sectionName) && $sectionName == 'social_settings') ? 'text-primary' : ''}}"
                       href="{{ route('settings.index', ['section' => 'social_settings']) }}">  {{ __('messages.social_settings') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary me-6 {{ (isset($sectionName) && $sectionName == 'about_us') ? 'text-primary' : ''}}"
                       href="{{ route('settings.index', ['section' => 'about_us']) }}"> {{ __('messages.about_us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary me-6 {{ (isset($sectionName) && $sectionName == 'env_setting') ? 'text-primary' : ''}}"
                       href="{{ route('settings.index', ['section' => 'env_setting']) }}"> {{ __('messages.env') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary me-6 {{ (isset($sectionName) && $sectionName == 'telegram') ? 'text-primary' : ''}}"
                       href="{{ route('settings.index', ['section' => 'telegram']) }}">Telegram</a>
                </li>
            </ul>
        </div>
    </div>
</div>



