<div class="ms-auto" wire:ignore>
    <div class="dropdown d-flex align-items-center {{ checkLanguageSession() == 'ar' ? 'ms-4' : 'me-4' }} me-md-2">
        <button class="btn btn btn-icon btn-primary text-white dropdown-toggle hide-arrow ps-2 pe-0" type="button"
            id="countryFilterBtn"data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
            <p class="text-center">
                <i class='fas fa-filter'></i>
            </p>
        </button>
        <div class="dropdown-menu py-0" aria-labelledby="countryFilterBtn">
            <div class="text-start border-bottom py-4 px-7">
                <h3 class="text-gray-900 mb-0">{{ __('messages.common.filter_options') }}</h3>
            </div>
            <div class="p-5">
                <div class="mb-5">
                    <label for="state" class="form-label">{{ __('messages.job.country') }}:</label>
                    {{ Form::select('country',['0' => __('messages.company.select_country')] + getCountries(), null, ['class' => 'form-select io-select2', 'id' => 'country', 'data-control' => 'select2']) }}
                </div>
                <div class="d-flex justify-content-end">
                    <button type="reset" class="btn btn-secondary"
                        id="country-ResetFilter">{{ __('messages.common.reset') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
