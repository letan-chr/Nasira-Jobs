<div class="d-flex justify-content-center">
    @if (! $row->featured)
        <button type="button"
            class="btn btn-sm btn-light-primary nasira-feature-btn adminMakeFeatured"
            data-id="{{ $row->id }}">
            {{ __('messages.front_settings.make_feature') }}
        </button>
    @else
        <button type="button"
            class="btn btn-sm btn-success nasira-feature-btn adminUnFeatured"
            data-id="{{ $row->id }}"
            title="{{ __('messages.front_settings.expires_on') }} {{ Carbon\Carbon::parse($row->featured->end_time)->translatedFormat('jS M, Y') }}"
            data-bs-toggle="tooltip">
            {{ __('messages.front_settings.featured') }}
            <i class="far fa-check-circle ms-1"></i>
        </button>
    @endif
</div>
