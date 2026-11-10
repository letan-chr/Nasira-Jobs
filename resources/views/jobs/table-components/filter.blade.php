<div class="nasira-filter dropdown" wire:ignore>
    <button class="btn nasira-filter__btn dropdown-toggle" type="button"
        id="jobsFilterBtn" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
        <i class="fas fa-filter"></i>
        <span>{{ __('messages.common.filter') }}</span>
    </button>
    <div class="dropdown-menu" aria-labelledby="jobsFilterBtn">
        <div class="nasira-filter__head">
            <h3>{{ __('messages.common.filter_options') }}</h3>
        </div>
        <div class="nasira-filter__body">
            <div class="mb-5">
                <label for="jobFeatured" class="form-label">{{ __('messages.front_settings.featured_job') }}</label>
                {{ Form::select('featured_job', getTranslatedData(collect($filterHeads[0][0])->sortBy('key')->toArray()), null, ['class' => 'form-select io-select2', 'data-control' => 'select2', 'id' => 'jobFeatured']) }}
            </div>
            <div class="mb-5">
                <label for="jobSuspended" class="form-label">{{ __('messages.job.is_suspended') }}</label>
                {{ Form::select('is_suspended', getTranslatedData(collect($filterHeads[0][1])->sortBy('key')->toArray()), null, ['class' => 'form-select io-select2', 'data-control' => 'select2', 'id' => 'jobSuspended']) }}
            </div>
            <div class="mb-5">
                <label for="Jobfreelance" class="form-label">{{ __('messages.job.is_freelance') }}</label>
                {{ Form::select('is_freelance', getTranslatedData(collect($filterHeads[0][2])->sortBy('key')->toArray()), null, ['class' => 'form-select io-select2', 'data-control' => 'select2', 'id' => 'Jobfreelance']) }}
            </div>
            <div class="mb-5">
                <label for="JobStatus" class="form-label">{{ __('messages.filter_name.job_status') }}</label>
                {{ Form::select('is_freelance', getTranslatedData(collect($filterHeads[0][3])->sortBy('key')->toArray()), null, ['class' => 'form-select io-select2', 'data-control' => 'select2', 'id' => 'JobStatus']) }}
            </div>
            <div class="nasira-filter__footer">
                <button type="reset" class="btn btn-secondary btn-sm" id="job-ResetFilter">{{ __('messages.common.reset') }}</button>
            </div>
        </div>
    </div>
</div>
