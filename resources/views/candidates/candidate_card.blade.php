<div class="col-xl-4 col-md-6 candidate-card">
    <div class="hover-effect-employee position-relative mb-5 border-hover-primary employee-border fix-candidate-height">
        <div class="employee-listing-details">
            <div class="d-flex employee-listing-description align-items-center justify-content-center flex-column">
                <div class="pl-0 mb-2 employee-avatar">
                    <img src="{{ $candidate['candidate_url'] }}"
                         class="img-responsive users-avatar-img employee-img mr-2">
                </div>
                <div class="mb-auto w-100">
                    <div class="d-flex justify-content-center align-items-center w-100">
                        <div>
                            <a href="{{ route('candidates.index') }}/{{ $candidate['id'] }}"
                               class="employee-listing-title text-decoration-none">{{ $candidate['user']['first_name'] }}</a>
                        </div>
                    </div>
                    <div class="text-center">
                        <label class="text-decoration-none text-color-gray">{{ $candidate['user']['email'] }}</label>
                    </div>
                    <div class="text-center">
                        <span class="badge text-uppercase text-black available-badge"> {{ $candidate['immediate_available'] == 0 ? {{ __('messages.not_immediate_available') }}:{{ __('messages.immediate_available') }} }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-0 pb-3 d-flex justify-content-around">
            <div>
                <label class="custom-switch pl-0">
                    <input type="checkbox" name="Is Active"
                           class="custom-switch-input isCandidateActive"
                           data-id="{{ $candidate['id'] }}" {{ $candidate['user']['is_active']==0?'':'checked' }}>
                    <span class="custom-switch-indicator"></span>
                    <span class="employee-label ml-1">{{ __('messages.common.status') }}</span>
                </label>
            </div>
            @if($candidate['user']['email_verified_at'] == null)
                <div>
                    <label class="custom-switch pl-0">
                        <input type="checkbox" name="Is Active" data-id="{{ $candidate['id'] }}"
                               class="custom-switch-input is-candidate-email-verified">
                        <span class="custom-switch-indicator"></span>
                        <span class="employee-label ml-1">{{ __('messages.candidate.email_verified') }}</span>
                    </label>
                </div>
            @else
                <div>
                    <a title="{{ __('messages.common.resend_verification_mail') }}"
                       class="btn btn-primary action-btn send-email-verification" data-id="{{ $candidate['id'] }}"
                       href="#">
                        <i class="fa fa-sync"></i>
                    </a>
                    <span class="employee-label ml-1">{{ __('messages.common.resend_verification_mail') }}</span>
                </div>
            @endif
        </div>

        <div class="employee-action-btn">
            <a title="{{ __('messages.common.edit') }}"
               class="btn btn-warning action-btn edit-action-btn edit-btn"
               href="{{ route('candidates.index') }}/{{ $candidate['id'] }}/edit">
                <i class="fa fa-edit"></i>
            </a>
            <a title="{{ __('messages.common.delete') }}"
               class="btn btn-danger action-btn delete-action-btn delete-btn" data-id="{{ $candidate['id'] }}"
               href="#">
                <i class="fa fa-trash"></i>
            </a>
        </div>
    </div>
</div>
