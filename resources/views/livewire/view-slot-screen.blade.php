<div>
    @if(count($jobSchedules) > 0)
        @foreach($jobSchedules as $batch => $jobSchedule)
            <div class="slot-box-inner mb-3">
                <div class="slot-box-inner-heading p-5 d-flex justify-content-between align-items-center">
                    <h1>{{__('messages.job_stage.batch')}} {{$batch}}</h1>
                    @if($jobApplication->job_stage_id==$jobSchedule[0]->stage_id)
                        {{--                        <a href="javascript:void(0)" class="btn btn-primary form-btn btn-sm float-right batch-slot"--}}
                        {{--                           data-batch="{{ $batch }}">--}}
                        {{--                            <i class="fas fa-plus"></i> {{ __('messages.common.add') }}--}}
                        {{--                        </a>--}}
                        <div class="d-flex align-items-center me-4 me-md-5 form-btn float-right">
                            <a href="javascript:void(0)"
                               class="btn btn-primary  batch-slot ms-2" data-batch="{{ $batch }}">
                                {{ __('messages.common.add') }}
                            </a>
                        </div>
                    @endif
                </div>
                @foreach($jobSchedule as $key => $value)
                    <div
                            class="slot-data mb-5">
                        <input type="hidden"
                               class="{{$value->status == \App\Models\JobApplicationSchedule::STATUS_REJECTED ? 'slot-bg-danger' : ''}}{{$value->status == \App\Models\JobApplicationSchedule::STATUS_SEND ? 'slot-bg-success' : ''}}"
                               value="{{$value->id}}">
                        <div
                                class="row shadow-sm py-9 px-5 rounded {{$value->status == \App\Models\JobApplicationSchedule::STATUS_REJECTED ? 'slot-bg-danger' : ''}}{{$value->status == \App\Models\JobApplicationSchedule::STATUS_SEND ? 'slot-bg-success' : ''}}">
                            <div class="col-sm-1 d-flex justify-content-center align-items-center">
                                <h6>{{$loop->iteration}}.</h6>
                            </div>
                            <div class="col-sm-5 mb-3">
                                <div class="">
                                    <label name="date"
                                           class="form-label">{{ __('messages.job_stage.date').':' }}</label>
                                    <span class="required"></span>
                                    <div class="mt-2">
                                        <input type="text" class="form-control" name=""
                                               value="{{ $value->date }}" disabled required>
                                    </div>
                                </div>
                                <div class=" mt-2">
                                    <label name="time"
                                           class="form-label">{{ __('messages.job_stage.time').':' }}</label>
                                    <span class="required"></span>
                                    <input type="text" class="form-control" name=""
                                           value="{{ $value->time }}" disabled required>
                                </div>
                            </div>
                            <div class=" col-sm-6 mt-0">
                                <label name="notes"
                                       class="form-label d-flex justify-content-between m-0">{{ __('messages.job.notes').':' }}
                                    <div class="h-100" style="margin-top: -10px;">
                                        @if($jobApplication->job_stage_id==$jobSchedule[0]->stage_id)
                                            @if(!($value->status == \App\Models\JobApplicationSchedule::STATUS_SEND) && !($value->status == \App\Models\JobApplicationSchedule::STATUS_REJECTED))
                                                <a title="{{ __('messages.common.edit') }}"
                                                   class="btn px-2 text-primary fs-3 ps-0 edit-slot-btn"
                                                   href="javascript:void(0)" data-id="{{$value->id}}"
                                                   data-bs-toggle="tooltip">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                            @endif
                                        @endif
                                        <a title="{{ __('messages.common.delete') }}"
                                           class="btn px-2 text-danger fs-3 ps-0 action-btn delete-btn"
                                           data-id="{{$value->id}}" href="javascript:void(0)" data-bs-toggle="tooltip">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </label>
                                <textarea class="form-control textarea-sizing" name=""
                                          disabled rows="5">{{ $value->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div
                            class="row shadow rounded mb-5 p-5 choose-slot-textarea {{ ($value->status == \App\Models\JobApplicationSchedule::STATUS_SEND) ? '' : 'd-none' }}">
                        {{ Form::label('candidate_slot', __('messages.job_stage.candidate_note').':',['class'=>'form-label']) }}
                        <textarea name="choose_slot_notes" class="textarea-sizing form-control"
                                  readonly
                                  placeholder="{{__('messages.flash.enter_notes')}}">{{ $value->rejected_slot_notes }}</textarea>
                        @if($isLastRecordStage == $value->stage_id)
                            <label>{{ Form::label('candidate_slot', __('messages.job_stage.your_note').':', ['class' => 'form-label mt-3']) }}
                                <span class="required"></span></label>
                            <textarea name="cancel_slot_notes"
                                      class="textarea-sizing form-control cancel-slot-notes" required
                                      placeholder="{{__('messages.flash.enter_cancel_reason')}}"></textarea>
                            <div class="text-center">
                                <a href="javascript:void(0)"
                                   class="btn btn-danger form-btn float-right cancel-slot mt-4 mx-auto"
                                   data-schedule="{{$value->id}}">{{ __('messages.job_stage.cancel_slot') }}</a>
                            </div>
                        @endif
                    </div>
                @endforeach

                <?php
                $candidateRejectedSlot = $jobSchedule->where('status',
                    App\Models\JobApplicationSchedule::STATUS_REJECTED)
                    ->where('employer_cancel_slot_notes', '==', null)->count();
                $employerRejectedSlot = $jobSchedule->where('status',
                    App\Models\JobApplicationSchedule::STATUS_REJECTED)
                    ->where('employer_cancel_slot_notes', '!=', null)->count();
                ?>
                @if($candidateRejectedSlot > 0)
                    <div class="row shadow-sm py-5 choose-slot-textarea
                                {{ ($value->status == \App\Models\JobApplicationSchedule::STATUS_REJECTED && empty($value->employer_cancel_slot_notes)) ? '' : 'd-none' }}">
                        <div class="col-sm-12 d-flex flex-column">
                            <span><b>{{__('messages.common.reason')}}:-</b> {{ $value->rejected_slot_notes }}</span>
                            <span name="choose_slot_notes">
                                {{ $value->jobApplication->candidate->user->full_name .' '. __('messages.job_stage.cancel_this_slot') }}
                            </span>
                        </div>
                    </div>
                @endif
                @if($employerRejectedSlot > 0 && !empty($value->rejected_slot_notes))
                    <div class="row shadow-sm py-5 choose-slot-textarea
{{ ($value->status == \App\Models\JobApplicationSchedule::STATUS_REJECTED && !empty($value->employer_cancel_slot_notes)) ? '' : 'd-none' }}">
                        <div class="col-sm-12 d-flex flex-column">
                            <span><b>{{__('messages.common.reason')}}:-</b> {{ $value->employer_cancel_slot_notes }}</span>
                            <span name="choose_slot_notes">
                                {{__('messages.common.you_cancel_slot_date')}}:- {{ $value->date }} {{__('messages.common.and_time')}}:- {{ $value->time }}
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="col-lg-12 col-md-12 d-flex justify-content-center">
            <h5 class="text-gray-600">{{ __('messages.job_stage.no_slot_available') }} </h5>
        </div>
    @endif
</div>
