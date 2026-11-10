<div class="card">
    <div class="card-body">
        {{ Form::open(['route' => 'cms.services.update','files' => true]) }}
        <div class="row">
            <div class="col-sm-12 mb-5">
                {{ Form::label('home_title', __('messages.cms_service.home_title') . ':', ['class' => 'form-label']) }}
                <span class="required"></span>
                {{ Form::text('home_title', $cmsServices['home_title'], ['class' => 'form-control', 'required', 'placeholder' => __('messages.cms_service.home_title')]) }}
            </div>
            <div class="col-sm-12 mb-5">
                {{ Form::label('home_description', __('messages.cms_service.home_description') . ':', ['class' => 'form-label']) }}
                {{ Form::textarea('home_description', $cmsServices['home_description'], ['class' => 'form-control', 'required', 'placeholder' => __('messages.cms_service.home_description')]) }}
            </div>
        </div>
        <div class="col-sm-12 mb-5" io-image-input="true">
            <label for="home_banner" class="form-label">
                {{ __('messages.cms_service.home_banner') . ':' }}
                <span class="required"></span>
                <span data-bs-toggle="tooltip" data-placement="top"
                    data-bs-original-title="{{ __('messages.setting.image_validation') }}">
                    <i class="fas fa-question-circle ml-1  general-question-mark"></i>
                </span>
            </label>
            <div class="d-block">
                <div class="image-picker">
                    <div class="image previewImage" id="homeBannerPreview"
                        style="background-image: url({{ $cmsServices['home_banner'] ? asset($cmsServices['home_banner']) : asset('assets/img/infyom-logo.png') }})">
                    </div>
                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip"
                        data-placement="top" data-bs-original-title="{{ __('messages.tooltip.change_home_banner') }}">
                        <label>
                            <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                            {{ Form::file('home_banner', ['id' => 'home_banner', 'class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                        </label>
                    </span>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <!-- Submit Field -->
            <div class="d-flex justify-content-end">
                {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
                {{--            <a class="btn btn-light btn-active-light-primary me-2">{{__('messages.common.cancel')}}</a> --}}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
