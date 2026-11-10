<div class="nasira-filter dropdown" wire:ignore>
    <button class="btn nasira-filter__btn dropdown-toggle" type="button"
        id="companiesFilterBtn" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
        <i class="fas fa-filter" aria-hidden="true"></i>
        <span>{{ __('messages.common.filter') }}</span>
    </button>
    <div class="dropdown-menu" aria-labelledby="companiesFilterBtn">
        <div class="nasira-filter__head">
            <h3>{{ __('messages.common.filter_options') }}</h3>
        </div>
        <div class="nasira-filter__body">
            <div class="mb-5">
                <label for="featuredCompany" class="form-label">{{ __('messages.filter_name.featured_company') }}</label>
                {{ Form::select('featured', getTranslatedData(collect($filterHeads[0])->sortBy('key')->toArray()), null, ['class' => 'form-select io-select2', 'data-control' => 'select2', 'id' => 'featuredCompany']) }}
            </div>
            <div class="mb-5">
                <label for="companyStatus" class="form-label">{{ __('messages.common.status') }}</label>
                {{ Form::select('employee_status', getTranslatedData(collect($filterHeads[1])->sortBy('key')->toArray()), null, ['class' => 'form-select io-select2', 'data-control' => 'select2', 'id' => 'companyStatus']) }}
            </div>
            <div class="nasira-filter__footer">
                <button type="reset" class="btn btn-secondary btn-sm" id="company-ResetFilter">{{ __('messages.common.reset') }}</button>
            </div>
        </div>
    </div>
</div>
