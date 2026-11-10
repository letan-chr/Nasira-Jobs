<div class="d-flex justify-content-center">
    @if( ! $row->user->email_verified_at )
        <label class="form-check form-switch form-switch-sm justify-content-center">
            <input type="checkbox" name="Is isActive"
                   class="form-check-input is-email-verified is-candidate-email-verified" data-id="{{ $row->id }}">
        </label>
    @else
        <div>
            <a title="{{ __('messages.common.resend_verification_mail') }}"
               class="btn btn-icon text-primary edit-btn send-email-verification" data-id="{{ $row->id }}">
                <i title="{{ __('messages.common.resend_verification_mail') }}" class="fa fa-sync"></i>
            </a>
        </div>
    @endif
</div>
