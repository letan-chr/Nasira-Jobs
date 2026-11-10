<div class="modal fade" id="reportJobAbuseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.job.add_note') }}</h5>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form name="frm" id="reportJobAbuse">
                <div class="modal-body">
                    <input type="hidden" name="userId"
                           value="{{ (getLoggedInUserId() !== null) ? getLoggedInUserId() : null }}">
                    <input type="hidden" name="jobId" value="{{ $job->id }}">
                    <div class="col-md-12 mb-4">
                        <div class="form-group">
                            <label for=""
                                class="fs-16 text-secondary mb-2">{{ __('web.web_contact.your_message') }}:
                                <span class="text-primary">*</span>
                            </label>
                            <textarea class="form-control fs-14 text-gray br-10" rows="5" id="noteForReportAbuse" name="note"
                                required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-primary"
                            data-bs-dismiss="modal">{{ __('messages.common.close') }}</button>
                    <button type="submit" class="btn btn-primary "
                            data-bs-loading-text="<span class='spinner-border spinner-border-sm'></span> {{__('messages.common.process')}}"
                            id="btnReportJobAbuse">{{ __('web.job_details.report') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
