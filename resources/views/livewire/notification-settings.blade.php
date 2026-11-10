<div class="row">
    @foreach($notificationSetting as $type => $settings)
        <div class="col-md-12 col-lg-4 col-sm-12">
            <h5>{{ __('messages.notification_settings.'.$type) }}</h5>
            <div class="separator my-3"></div>
            <div class="ml-sm-0 mt-4 notification-setting">
                <div class="">
                    @foreach($settings as $key => $value)
                        <div
                                class="col-lg-12 col-md-6 mb-5 d-flex justify-content-start form-check form-switch">
                            <label class="mt-2 me-2">
                                <input type="checkbox" name="{{ $value->key }}"
                                       class="form-check-input"
                                       {{ ($value->value == 1) ? 'checked' : '' }} value="{{ $value->key }}">
                                <span class=""></span>
                            </label>
                            <span class="mt-2 fs-5 text-gray-600">{{ __('messages.notification_settings.'.$value->key) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
@endforeach
<!-- Submit Field -->
    <div class="separator my-5"></div>
    <div class="d-flex justify-content-end">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3','id' => 'jobsSaveBtn']) }}
        <a href="{{ route('notification.settings.index') }}"
           class="btn btn-secondary me-2">{{__('messages.common.cancel')}}</a>
    </div>
</div>
