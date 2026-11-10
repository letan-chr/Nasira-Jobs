<div class="ms-auto" wire:ignore>
    <div class="dropdown d-flex align-items-center {{ checkLanguageSession() == 'ar' ? 'ms-4' : 'me-4' }} me-md-2">
        <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0" type="button"
            id="jobsFilterBtn"data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <p class="text-center">
                <i class='fas fa-filter'></i>
            </p>
        </button>
        <div class="dropdown-menu py-0" aria-labelledby="jobsFilterBtn">
            <div class="text-start border-bottom py-4 px-7">
                <h3 class="text-gray-900 mb-0">{{ __('messages.common.filter_options') }}</h3>
            </div>
            <div class="p-5">
                <div class="mb-5">
                    <label for="filterBtn" class="form-label">{{ __('messages.front_settings.featured_job') }}:</label>
                    {{ Form::select('featured_job',getTranslatedData(collect($filterHeads[0][0])->sortBy('key')->toArray()),null,['class' => 'form-select io-select2 abc', 'data-control' => 'select2', 'id' => 'jobFeatured']) }}
                </div>
                <div class="mb-5">
                    <label for="filterBtn" class="form-label">{{ __('messages.job.is_suspended') }}:</label>
                    {{ Form::select('is_suspended',getTranslatedData(collect($filterHeads[0][1])->sortBy('key')->toArray()),null,['class' => 'form-select io-select2 abc', 'data-control' => 'select2', 'id' => 'jobSuspended']) }}
                </div>
                <div class="mb-5">
                    <label for="filterBtn" class="form-label">{{ __('messages.job.is_freelance') }}:</label>
                    {{ Form::select('is_freelance',getTranslatedData(collect($filterHeads[0][2])->sortBy('key')->toArray()),null,['class' => 'form-select io-select2 abc', 'data-control' => 'select2', 'id' => 'Jobfreelance']) }}
                </div>
                <div class="mb-5">
                    <label for="filterBtn" class="form-label">{{ __('messages.filter_name.job_status') }}:</label>
                    {{ Form::select('is_freelance',getTranslatedData(collect($filterHeads[0][3])->sortBy('key')->toArray()),null,['class' => 'form-select io-select2 abc', 'data-control' => 'select2', 'id' => 'JobStatus']) }}
                </div>
                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-secondary"
                        id="job-ResetFilter">{{ __('messages.common.reset') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
