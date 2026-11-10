<div id="scheduleInterviewModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.job_stage.add_slots') }}</h3>
                <button type="button" class="add-slot btn btn-primary">
                    {{ __('messages.job_stage.add_slots') }}
                </button>
            </div>
            {{ Form::open(['id'=>'scheduleInterviewForm']) }}

            <div class="modal-body">
                <div class="alert alert-danger d-none" id="rejectSlotValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>

                <div class="slot-main-div">
                    <div class="slot-box rounded shadow mb-5">
                        <div class="row p-5">
                            <div class="col-sm-6">
                                <div class="">
                                    <label name="date"
                                           class="form-label"><?php echo __('messages.job_stage.date').':' ?></label>
                                    <span class="required"></span>
                                    {{--                                    <input type="text" class="form-control form-control-solid" name="date" id="date" required>--}}
                                    <input type="text"
                                           class="form-control scheduleInterviewDate {{(getLoggedInUser()->theme_mode) ? 'bg-light' : 'bg-white'}}"
                                           name="date[1]"
                                           id="date[1]" required>
                                </div>
                                <div class=" mb-0 mt-3">
                                    <label name="time" class="form-label"><?php echo __(
                                                'messages.job_stage.time'
                                            ).':' ?></label>
                                    <span class="required"></span>
                                    {{--                                    <input type="text" class="form-control" name="date" id="date" required>--}}
                                    <input type="text"
                                           class="form-control scheduleInterviewTime {{(getLoggedInUser()->theme_mode) ? 'bg-light' : 'bg-white'}}"
                                           name="time[1]"
                                           id="time[1]" required>
                                </div>
                            </div>
                            <div class=" col-sm-6 mb-0 mt-25">
                                <label name="notes" class="form-label"><?php echo __('messages.company.notes').':' ?>
                                </label>
                                <textarea class="form-control textarea-sizing" name="notes[1]"
                                          rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="historyMainDiv" class="d-none">
                    <h3>{{ __('messages.job_stage.history') }}</h3>
                    <div id="historyDiv">

                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'batchSlotBtnSave','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0" id="batchSlotBtnCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
