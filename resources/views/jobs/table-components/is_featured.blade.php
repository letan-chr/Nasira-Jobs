<div class="d-flex justify-content-start">
    @if (! $row->featured)
        <button type="button"
            class="btn btn-sm btn-light-primary nasira-feature-btn adminJobMakeFeatured"
            data-id="{{ $row->id }}">
            {{ __('messages.front_settings.make_feature') }}
        </button>
    @else
        <button type="button"
            class="btn btn-sm btn-success nasira-feature-btn adminJobUnFeatured"
            data-id="{{ $row->id }}"
            title="Expires On {{ Carbon\Carbon::parse($row->featured->end_time)->translatedFormat('jS M, Y') }}"
            data-bs-toggle="tooltip">
            {{ __('messages.front_settings.featured') }}
            <i class="far fa-check-circle ms-1"></i>
        </button>
    @endif
</div>
