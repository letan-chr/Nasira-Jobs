<div class="d-flex flex-column">
    <div class="col-lg-9 mt-5">
        <form method="post" id="searchIsActiveHeaderSlider">
            @csrf
            <div class="mb-5 d-flex align-items-center">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input searchIsActiveHeaderSlider" type="checkbox"
                           name="is_active" {{ ($settings['slider_is_active'] == 1) ? 'checked' : '' }}>
                </div>
                <label class="form-label fs-5 text-gray-600 me-5 mb-0 mb-1">
                    {{ __('messages.image_slider.message') }}
                    <span data-bs-toggle="tooltip"
                          data-bs-original-title="{{ __('messages.image_slider.message_title') }}"><i
                                class="fas fa-question-circle ml-1"></i>
                        </span>
                </label>
            </div>
        </form>
    </div>
</div>
