<div class="d-flex justify-content-center">
    @if( ! $row->user->email_verified_at)
        <label class="form-check form-switch form-check-custom form-check-solid form-switch-sm justify-content-center">
            <input type="checkbox" name="Is isActive"
                   class="form-check-input is-employer-email-verified" data-id="{{ $row->id }}">
            <span class="custom-switch-indicator"></span>
        </label>
    @else
        <div>
            <a title="{{ __('messages.common.resend_verification_mail') }}"
               class="btn btn-icon text-primary edit-btn send-email-company-verification"
               data-id="{{ $row->id }}">
                <i title="{{ __('messages.common.resend_verification_mail') }}" class="fa fa-sync"></i>
            </a>
        </div>
    @endif
</div>
