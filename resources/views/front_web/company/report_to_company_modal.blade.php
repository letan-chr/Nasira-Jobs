<div class="modal fade" id="reportToCompanyModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('messages.job.add_note')</h5>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form name="frm" id="reportToCompany">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12 mb-4">
                        <div class="form-group">
                            <input type="hidden" name="userId"
                                value="{{ getLoggedInUserId() !== null ? getLoggedInUserId() : null }}">
                            <input type="hidden" name="companyId" value="{{ $companyDetail->id }}">
                            <label for=""
                                class="fs-16 text-secondary mb-2">{{ __('web.web_contact.your_message') }}:
                                <span class="text-primary">*</span>
                            </label>
                            <textarea class="form-control fs-14 text-gray br-10" rows="5" id="noteForReportToCompany" name="note" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary " name="log-in"
                        id="btnSave">@lang('messages.common.report')</button>
                </div>
            </form>
        </div>
    </div>
</div>
