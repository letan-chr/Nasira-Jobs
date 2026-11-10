<div class="row">
    <div class="col-sm-4 mb-5">
        {{ Form::label('about_title_one', __('messages.cms_about.about_title_one').(':'), ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('about_title_one', $cmsServices['about_title_one'], ['class' => 'form-control','required','onkeypress' => 'return avoidSpace(event);','placeholder' => __('messages.cms_about.about_title_one')]) }}
    </div>


    <div class="col-sm-4 mb-5">
        {{ Form::label('about_title_two',__('messages.cms_about.about_title_two').(':'), ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('about_title_two', $cmsServices['about_title_two'], ['class' => 'form-control','required','onkeypress' => 'return avoidSpace(event);','placeholder' => __('messages.cms_about.about_title_two')]) }}

    </div>
    <div class="col-sm-4 mb-5">
        {{ Form::label('home_title_three', __('messages.cms_about.about_title_three').(':'), ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('about_title_three', $cmsServices['about_title_three'], ['class' => 'form-control','required','onkeypress' => 'return avoidSpace(event);','placeholder' => __('messages.cms_about.about_title_three')]) }}
    </div>
</div>
<div class="row">
    <div class="col-sm-4 my-0 mb-5">
        {{ Form::label('about_description_title', __('messages.cms_about.about_desc_one').(':'), ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::textarea('about_description_one', $cmsServices['about_description_one'], ['class' => 'form-control','required','onkeypress' => 'return avoidSpace(event);', 'placeholder' => __('messages.cms_about.about_desc_one')]) }}

    </div>
    <div class="col-sm-4 mb-5">
        {{ Form::label('about_description_title',  __('messages.cms_about.about_desc_two').(':'), ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::textarea('about_description_two', $cmsServices['about_description_two'], ['class' => 'form-control','required','onkeypress' => 'return avoidSpace(event);','placeholder' => __('messages.cms_about.about_desc_two')]) }}
    </div>
    <div class="col-sm-4 mb-5">
        {{ Form::label('about_description_three',  __('messages.cms_about.about_desc_three').(':'), ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::textarea('about_description_three', $cmsServices['about_description_three'], ['class' => 'form-control','required','onkeypress' => 'return avoidSpace(event);','placeholder' => __('messages.cms_about.about_desc_three')]) }}
    </div>
</div>
<div class="row">

    <div class="col-sm-4 mb-5" io-image-input="true">
        <label for="home_banner" class="form-label">
            {{__('messages.cms_about.about_image_one').':'}}
            <span class="required"></span>
            <span data-bs-toggle="tooltip"
                  data-placement="top"
                  data-bs-original-title="{{  __('messages.setting.image_validation') }}">
        <i class="fas fa-question-circle ml-1  general-question-mark"></i>
</span>
        </label>
        <div class="d-block">
            <div class="image-picker">
                <div class="image previewImage" id="aboutImagePreviewOne"
                     style="background-image: url({{ ($cmsServices['about_image_one']) ? "'".asset($cmsServices['about_image_one'])."'" : asset('front_web/images/register.png')}})">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small"
                      data-bs-toggle="tooltip"
                      data-placement="top" data-bs-original-title="{{__('messages.tooltip.change_image')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        {{ Form::file('about_image_one',['class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                    </label>
                </span>
            </div>
        </div>
    </div>
    <div class="col-sm-4 mb-5" io-image-input="true">
        <label for="about_image_two" class="form-label">
            {{ __('messages.cms_about.about_image_two').':'}}
            <span class="required"></span>
           <span data-bs-toggle="tooltip"
                              data-placement="top"
                              data-bs-original-title="{{  __('messages.setting.image_validation') }}">
        <i class="fas fa-question-circle ml-1  general-question-mark"></i>
</span>
        </label>
        <div class="d-block">
            <div class="image-picker">
                <div class="image previewImage" id="aboutImagePreviewTwo"
                     style="background-image: url({{ ($cmsServices['about_image_two']) ? "'".asset($cmsServices['about_image_two'])."'" : asset('front_web/images/resume.png')}})">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small"
                      data-bs-toggle="tooltip"
                      data-placement="top" data-bs-original-title="{{__('messages.tooltip.change_image')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        {{ Form::file('about_image_two',['class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                    </label>
                </span>
            </div>
        </div>
    </div>
    <div class="col-sm-4 mb-5" io-image-input="true">
        <label for="about_image_three" class="form-label">
            {{ __('messages.cms_about.about_image_three').':'}}
            <span class="required"></span>
           <span data-bs-toggle="tooltip"
                              data-placement="top"
                              data-bs-original-title="{{  __('messages.setting.image_validation') }}">
        <i class="fas fa-question-circle ml-1  general-question-mark"></i>
</span>
        </label>
        <div class="d-block">
            <div class="image-picker">
                <div class="image previewImage" id="aboutImagePreviewThree"
                     style="background-image: url({{ ($cmsServices['about_image_three']) ? "'".asset($cmsServices['about_image_three'])."'" : asset('front_web/images/working.png')}})">
                </div>
                <span class="picker-edit rounded-circle text-gray-500 fs-small"
                      data-bs-toggle="tooltip"
                      data-placement="top" data-bs-original-title="{{__('messages.tooltip.change_image')}}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        {{ Form::file('about_image_three',['class' => 'image-upload d-none', 'accept' => '.png, .jpg, .jpeg']) }}
                    </label>
                </span>
            </div>
        </div>
    </div>

</div>
<!-- Submit Field -->
<div class="d-flex justify-content-end mt-5">
    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
</div>

