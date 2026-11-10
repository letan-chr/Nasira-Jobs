
<div class="card">
    <div class="card-body">
        {{ Form::open(['route' => 'candidate.job.alert.update']) }}
        <div
            class="col-lg-12 col-md-6 mb-5 d-flex justify-content-start form-check form-switch">
            <label class="mt-2 me-2">
                <input type="checkbox" name="job_alert" value="1"
                       class="form-check-input" {{ ($data['candidate']->job_alert) ? 'checked' : '' }}>
                <span class=""></span>
            </label>
            <span class="mt-2 fs-6 text-gray-600">{{ __('messages.candidate.job_alert_message') }}</span>
        </div>
        <div class="form-group ms-19">
            <div class="custom-switches-stacked">
                @foreach($data['jobTypes'] as $jobType)
                    <div class="col-lg-12 col-md-6 mb-2 d-flex justify-content-start form-check form-switch">
                        <label
                            class="mt-2 me-2">
                            <input type="checkbox" name="job_types[]" value="{{ $jobType->id }}"
                                   class="form-check-input cursor-pointer" {{ in_array($jobType->id,$data['jobAlerts']) ? 'checked' : '' }}>
                            <span class="custom-switch-indicator"></span>
                        </label>
                        <span
                            class="mt-2 fs-6 text-gray-600">{{ htmlspecialchars_decode($jobType->name) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Submit Field -->
        <div class="separator my-5"></div>
        <div class="d-flex justify-content-end">
            {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3 btnSave',]) }}
        </div>
        {{ Form::close() }}
    </div>
</div>
