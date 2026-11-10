<div class="nasira-filter dropdown" wire:ignore>
    <button class="btn nasira-filter__btn dropdown-toggle" type="button"
        id="selectStateBtn" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
        <i class="fas fa-filter"></i>
        <span>{{ __('messages.common.filter') }}</span>
    </button>
    <div class="dropdown-menu" aria-labelledby="selectStateBtn">
        <div class="nasira-filter__head">
            <h3>{{ __('messages.common.filter_options') }}</h3>
        </div>
        <div class="nasira-filter__body">
            <div class="mb-5">
                <label for="selectState" class="form-label">{{ __('messages.job.city') }}</label>
                {{ Form::select('state', ['0' => __('messages.company.select_state')] + getStateFilter(), null, ['class' => 'form-select', 'id' => 'selectState', 'data-control' => 'select2']) }}
            </div>
            <div class="nasira-filter__footer">
                <button type="reset" class="btn btn-secondary btn-sm" id="state-ResetFilter">{{ __('messages.common.reset') }}</button>
            </div>
        </div>
    </div>
</div>
