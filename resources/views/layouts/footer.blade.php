<footer class="border-top w-100 pt-4 mt-7 d-flex justify-content-lg-between">
    <p class="fs-6 text-gray-600">{{ __('messages.all_rights_reserved') }} &copy;{{ date('Y') }}
        <a href="{{ getSettingValue('company_url') }}"
           class="text-decoration-none">{{ html_entity_decode(getSettingValue('application_name')) }}</a>
    </p>
    <p class="fs-6 text-gray-600">
        {{ getCurrentVersion() }}
    </p>
</footer>
