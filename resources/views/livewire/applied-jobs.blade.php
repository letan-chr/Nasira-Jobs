<div class="col-lg-12 col-md-12">
{{--    @if(session()->has('message'))--}}
{{--        <div class="alert alert-success">--}}
{{--            {{ session('message') }}--}}
{{--        </div>  --}}
{{--    @endif--}}
    {{-- @if(count($appliedJobs) > 0 || $searchByAppliedJob != '' || $jobApplicationStatus != '') --}}
        <div class="row mb-3 justify-content-end" wire:ignore>
            <div class="col-md-3">
                {{ Form::select('job-application-status', $jobApplicationStatusArr, null, ['class' => 'form-control','id'=>'jobApplicationStatus','placeholder' => __('messages.common.all'), 'wire:model' => "jobApplicationStatus"]) }}
            </div>
            <div class="col-md-3">
                <input wire:model.debounce.100ms.live="searchByAppliedJob" type="search"
                       id="searchByAppliedJob"
                       placeholder="{{ __('web.job_menu.search_applied_job') }}"
                       class="form-control search-box-placeholder">
            </div>
        </div>
    {{-- @endif --}}
    @if(count($appliedJobs) > 0)
        <div class="content1 with-padding">
            <div class="row mt-5 position-relative">
                @foreach($appliedJobs as $appliedJob)
                   <div class="col-12 col-sm-6 col-md-6 col-xl-6 mb-4">
                       <div class="h-100 shadow rounded card">
                           <div class="card-body p-5">
                               <div class="d-flex justify-content-end">
                                   <div class="dropdown">
                                       <button type="button" title="{{__('messages.common.action')}}"
                                               class="dropdown-toggle hide-arrow btn text-primary p-0"
                                               id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                               data-bs-boundary="viewport" aria-expanded="false">
                                           <i class="fa-solid fa-ellipsis-vertical"></i>
                                       </button>
                                       <ul class="dropdown-menu min-width-220 customDropdown"
                                           aria-labelledby="dropdownMenuButton1" style="">
                                           <li><a class="dropdown-item apply-job-note"
                                                  href="javascript:void(0)"
                                                  data-id="{{ $appliedJob->id }}">{{ __('messages.common.view') }}</a>
                                            </li>
                                            @if(\App\Models\JobApplicationSchedule::whereJobApplicationId($appliedJob->id)->exists() && !($appliedJob->status == \App\Models\JobApplication::REJECTED) && !($appliedJob->status == \App\Models\JobApplication::STATUS_APPLIED) && !($appliedJob->status == \App\Models\JobApplication::COMPLETE))
                                                <li><a class="dropdown-item schedule-slot-book" href="javascript:void(0)"   data-id="{{ $appliedJob->id }}">{{ __('messages.job_stage.slots') }}</a></li>
                                            @endif
                                            <li><a class="dropdown-item delete-btn remove-applied-jobs" href="javascript:void(0)" data-id="{{ $appliedJob->id }}">{{ __('messages.common.delete') }}</a></li>
                                        </ul>

                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="mb-auto">
                                        <h4>
                                            <i class="fas fa-briefcase fs-3 me-1 text-muted"></i> &nbsp;<a
                                                    href="{{ route('front.job.details',$appliedJob->job->job_id) }}"
                                                    target="_blank" class="text-decoration-none">{{ Str::limit($appliedJob->job->job_title,25,'...') }}</a>
                                            <div
                                                    class="ms-2 badge bg-light-{{ \App\Models\JobApplication::STATUS_COLOR[$appliedJob->status] }}">
                                                @if(\App\Models\JobApplication::STATUS[$appliedJob->status] == 'Drafted')
                                                    {{__('messages.common.drafted')}}
                                                @elseif(\App\Models\JobApplication::STATUS[$appliedJob->status] == 'Applied')
                                                    {{__('messages.common.applied')}}
                                                @elseif(\App\Models\JobApplication::STATUS[$appliedJob->status] == 'Declined')
                                                    {{__('messages.common.declined')}}
                                                @elseif(\App\Models\JobApplication::STATUS[$appliedJob->status] == 'Hired')
                                                    {{__('messages.common.hired')}}
                                                @else
                                                    {{__('messages.common.ongoing')}}
                                                @endif

                                            </div>
                                        </h4>
                                        <h4>
                                            <i class="far fa-clock fs-3 me-1 text-muted"></i>
                                            &nbsp;<label
                                                    class="text-muted mb-3">{{ __('messages.common.applied_on') }}
                                                :</label>
                                            {{ (!empty($appliedJob->created_at)) ? \Carbon\Carbon::parse($appliedJob->created_at)->translatedFormat('dS M, Y')  : __('messages.n/a') }}
                                        </h4>
                                        <h4>
                                            <i class="fas fa-money-check-alt fs-3 me-1 text-muted"></i>
                                            &nbsp;{{ (!empty($appliedJob->expected_salary)) ? number_format($appliedJob->expected_salary)   : __('messages.n/a') }} {{ $appliedJob->job->currency->currency_icon }}
                                        </h4>
                                        @isset($appliedJob->jobStage->name)
                                            <h4>
                                                <i class="fab fa-usps fs-3 me-1 text-muted"></i>
                                                &nbsp;{{ $appliedJob->jobStage->name }}
                                            </h4>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                   </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center my-2">
                @if($appliedJobs->count() > 0)
                    {{ $appliedJobs->links() }}
                @endif
            </div>
        </div>
    @else
        @if($searchByAppliedJob == null || empty($searchByAppliedJob))
        <div class="col-lg-12 col-md-12 d-flex justify-content-center my-9 job-titile">
            <h5>{{ __('messages.job.no_applied_job_found') }} </h5>
        </div>
        @else
        <div class="col-lg-12 col-md-12 d-flex justify-content-center my-9 job-titile">
            <h5>{{ __('messages.job.applies_job_not_found') }} </h5>
        </div>
        @endif
    @endif
</div>
