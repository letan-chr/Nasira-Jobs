<div id="editSlotModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.job_stage.edit_slot') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'editSlotForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger d-none" id="editSlotValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <input type="hidden" id="editSlotId">
                <div class="add-slot-main-div">
                    <div class="slot-box rounded shadow mb-5">
                        <div class="row p-5">
                            <div class="col-sm-6">
                                <div class="">
                                    <label name="date" class="form-label"><?php echo __(
                                                'messages.job_stage.date'
                                            ).':' ?></label>
                                    <span class="required"></span>
                                    <input type="text"
                                           class="form-control {{(getLoggedInUser()->theme_mode) ? 'bg-light' : 'bg-white'}}"
                                           name="date" id="editDate" required>
                                </div>
                                <div class=" mb-0 mt-3">
                                    <label name="time" class="form-label"><?php echo __(
                                                'messages.job_stage.time'
                                            ).':' ?></label>
                                    <span class="required"></span>
                                    <input type="text"
                                           class="form-control {{(getLoggedInUser()->theme_mode) ? 'bg-light' : 'bg-white'}}"
                                           name="time" id="editTime" required>
                                </div>
                            </div>
                            <div class=" col-sm-6 mb-0">
                                <label name="notes" class="form-label"><?php echo __('messages.company.notes').':' ?>
                                </label>
                                <textarea class="form-control textarea-sizing" name="notes"
                                          id="editNotes" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'editSlotBtnSave','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0" id="editSlotBtnCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
