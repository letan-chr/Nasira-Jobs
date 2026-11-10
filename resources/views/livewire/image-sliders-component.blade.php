<div class="d-flex flex-column">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <form method="post" id="searchIsActive" class="d-lg-flex m-6">
                    @csrf
                    <div class="col-lg-6 col-sm-12 mb-5 d-flex align-items-center">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input isFullSlider" type="checkbox"
                                   name="is_active" {{ ($settings['is_full_slider'] == 1) ? 'checked' : '' }}>
                        </div>
                        <label class="form-label fs-5 text-gray-600 me-5 mb-0 mb-1">
                            {{ __('messages.image_slider.slider') }}
                            <span data-bs-toggle="tooltip"
                                  title="{{ __('messages.image_slider.slider_title') }}">
                                <i class="fas fa-question-circle ml-1"></i>
                            </span>

                        </label>
                    </div>
                    <div class="col-lg-6 col-sm-12 mb-5 d-flex align-items-center">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input isSliderActive" type="checkbox"
                                   name="is_active" {{ ($settings['is_slider_active'] == 1) ? 'checked' : '' }}>
                        </div>
                        <label class="form-label fs-5 text-gray-600 me-5 mb-0 mb-1">
                            {{ __('messages.image_slider.slider_active') }}
                            <span data-bs-toggle="tooltip"
                                  title="{{ __('messages.image_slider.slider_active_title') }}">
                                <i class="fas fa-question-circle ml-1"></i></span>
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
