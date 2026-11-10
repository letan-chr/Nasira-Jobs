<div class="nasira-filter dropdown" wire:ignore>
    <button class="btn nasira-filter__btn dropdown-toggle" type="button"
        id="selectedCandidateFilterBtn" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
        <i class="fas fa-filter"></i>
        <span>{{ __('messages.common.filter') }}</span>
    </button>
    <div class="dropdown-menu" aria-labelledby="selectedCandidateFilterBtn">
        <div class="nasira-filter__head">
            <h3>{{ __('messages.common.filter_options') }}</h3>
        </div>
        <div class="nasira-filter__body">
            <div class="mb-5">
                <label for="selectedCandidateStatus" class="form-label">{{ __('messages.common.status') }}</label>
                {{ Form::select('status', getTranslatedData(collect($filterHeads[0])->sortBy('key')->toArray()), null, ['class' => 'form-select io-select2', 'data-control' => 'select2', 'id' => 'selectedCandidateStatus']) }}
            </div>
            <div class="nasira-filter__footer">
                <button type="reset" class="btn btn-secondary btn-sm" id="selectedCandidate-ResetFilter">{{ __('messages.common.reset') }}</button>
            </div>
        </div>
    </div>
</div>
