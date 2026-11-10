<div class="row details-page">
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('company', __('messages.company.company_name').(':'), ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{  html_entity_decode($job->company->user->full_name) }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('job_title', __('messages.job.job_title').':',['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ html_entity_decode($job->job_title) }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('job_title', __('messages.job.job_skill').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        @if($job->jobsSkill->isNotEmpty())
            <p class="fs-5 text-gray-800">{{ html_entity_decode($job->jobsSkill->pluck('name')->implode(', ')) }}</p>
        @else
            <p class="fs-5 text-gray-800">{{ __('messages.n/a') }}</p>
        @endif
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('job_title', __('messages.job_tag.show_job_tag').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        @if($job->jobsTag->isNotEmpty())
            <p class="fs-5 text-gray-800">{{ html_entity_decode($job->jobsTag->pluck('name')->implode(', ')) }}</p>
        @else
            <p class="fs-5 text-gray-800">{{ __('messages.n/a') }}</p>
        @endif
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('job_type_id', __('messages.job.job_type').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ html_entity_decode($job->jobType->name) }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('job_category_id', __('messages.job_category.job_category').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ html_entity_decode($job->jobCategory->name) }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('career_level_id', __('messages.job.career_level').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ (!empty($job->careerLevel)) ? html_entity_decode($job->careerLevel->level_name) : __('messages.n/a') }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('job_shift_id', __('messages.job.job_shift').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ (!empty($job->jobShift)) ? html_entity_decode($job->jobShift->shift) : __('messages.n/a') }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('currency_id', __('messages.job.currency').':', ['class' => 'pb-2 fs-5 text-gray-6003']) }}
        <p class="fs-5 text-gray-800">{{ $job->currency->currency_name }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('salary_period_id', __('messages.job.salary_period').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ html_entity_decode($job->salaryPeriod->period) }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('functional_area_id', __('messages.job.functional_area').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ html_entity_decode($job->functionalArea->name) }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('degree_level_id', __('messages.job.degree_level').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ (!empty($job->degreeLevel)) ? html_entity_decode($job->degreeLevel->name) : __('messages.n/a') }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('position', __('messages.job.position').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ $job->position }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('position', __('messages.job_experience.job_experience').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ $job->experience .' '. __('messages.candidate_profile.year') }} </p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('country', __('messages.job.country').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ !empty($job->country_id) ?$job->country_name:__('messages.n/a') }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('state', __('messages.job.state').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ !empty($job->state_id)? $job->state_name:__('messages.n/a') }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('city', __('messages.job.city').':',['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ !empty($job->city_id) ?$job->city_name:__('messages.n/a') }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('salary_from', __('messages.job.salary_from').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ numberFormatShort($job->salary_from) }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('salary_to', __('messages.job.salary_to').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ numberFormatShort($job->salary_to) }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('is_freelance', __('messages.job.is_freelance').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ $job->is_freelance == 1 ? __('messages.common.yes') : __('messages.common.no') }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('hide_salary', __('messages.job.hide_salary').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ $job->hide_salary == 1 ? __('messages.common.yes') : __('messages.common.no') }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('job_expiry_date', __('messages.job.job_expiry_date').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800">{{ Carbon\Carbon::parse($job->job_expiry_date)->format('jS M, Y') }}</p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('created_at', __('messages.common.created_on').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800"><span data-toggle="tooltip" data-placement="right"
                                            title="{{ date('jS M, Y', strtotime($job->created_at)) }}">{{ $job->created_at->diffForHumans() }}</span>
        </p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('updated_at', __('messages.common.last_updated').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        <p class="fs-5 text-gray-800"><span data-toggle="tooltip" data-placement="right"
                                            title="{{ date('jS M, Y', strtotime($job->updated_at)) }}">{{ $job->updated_at->diffForHumans() }}</span>
        </p>
    </div>
    <div class="col-sm-6 d-flex flex-column mb-md-10 mb-5">
        {{ Form::label('description', __('messages.job.description').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
        @if($job->description)
            <p class="fs-5 text-gray-800"> {!! nl2br(e($job->description)) !!}</p>
        @else
            <p class="fs-5 text-gray-800">{{ __('messages.n/a') }}</p>
        @endif
    </div>
</div>
