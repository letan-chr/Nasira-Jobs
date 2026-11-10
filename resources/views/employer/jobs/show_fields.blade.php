<div class="row">
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('job_title', __('messages.job.job_title').':') }}--}}
        {{ Form::label('job_title',  __('messages.job.job_title').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->job_title }}</p><b></b>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('job_title', __('messages.job.job_skill').':') }}--}}
        {{ Form::label('job_title',  __('messages.job.job_skill').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

    @if($job->jobsSkill->isNotEmpty())
            <td  class="fw-bolder fs-6 text-gray-800">{{ $job->jobsSkill->pluck('name')->implode(', ') }}</td>
        @endif
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('job_title', __('messages.job_tag.show_job_tag').':') }}--}}
        {{ Form::label('job_title',  __('messages.job_tag.show_job_tag').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

    @if($job->jobsTag->isNotEmpty())
            <td  class="fw-bolder fs-6 text-gray-800">{{ $job->jobsTag->pluck('name')->implode(', ') }}</td>
        @endif
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('job_type_id', __('messages.job.job_type').':') }}--}}
        {{ Form::label('job_type_id',   __('messages.job.job_type').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->jobType->name }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('job_category_id', __('messages.job_category.job_category').':') }}--}}
        {{ Form::label('job_category_id',  __('messages.job_category.job_category').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->jobCategory->name }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        {{ Form::label('career_level_id', __('messages.job.career_level').':') }}
        {{ Form::label('career_level_id', __('messages.job.career_level').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->careerLevel->level_name }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        {{ Form::label('job_shift_id', __('messages.job.job_shift').':') }}
        {{ Form::label('job_shift_id', __('messages.job.job_shift').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->jobShift->shift }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('currency_id', __('messages.job.currency').':') }}--}}
        {{ Form::label('currency_id', __('messages.job.currency').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->currency->currency_name }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        {{ Form::label('salary_period_id', __('messages.job.salary_period').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}
{{--        {{ Form::label('salary_period_id', __('messages.job.salary_period').':') }}--}}
        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->salaryPeriod->period }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('functional_area_id', __('messages.job.functional_area').':') }}--}}
        {{ Form::label('functional_area_id',  __('messages.job.functional_area').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->functionalArea->name }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('degree_level_id', __('messages.job.degree_level').':') }}--}}
        {{ Form::label('degree_level_id',  __('messages.job.degree_level').(':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->degreeLevel->name }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('position', __('messages.job.position').':') }}--}}
        {{ Form::label('position',  __('messages.job.position').':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->position }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('country', __('messages.job.country').':') }}--}}
        {{ Form::label('country', __('messages.job.country').':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ !empty($job->country_id) ?$job->country_name:__('messages.n/a') }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('state', __('messages.job.state').':') }}--}}
        {{ Form::label('state', __('messages.job.state').':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ !empty($job->state_id) ?$job->state_name:__('messages.n/a') }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('city', __('messages.job.city').':') }}--}}
        {{ Form::label('city', __('messages.job.city').':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ !empty($job->city_id) ?$job->city_name:__('messages.n/a') }}</p>
    </div>
    <div class="form-group col-xl-12 col-md-12 col-sm-12">
{{--        {{ Form::label('description', __('messages.job.description').':') }}--}}
        {{ Form::label('description', __('messages.job.description').':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

    @if($job->description)
            <p  class="fw-bolder fs-6 text-gray-800">{!! nl2br(e($job->description)) !!} </p>
        @else
            <p  class="fw-bolder fs-6 text-gray-800"> {{ __('messages.n/a') }}</p>
        @endif
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('salary_from', __('messages.job.salary_from').':') }}--}}
        {{ Form::label('salary_from', __('messages.job.salary_from').':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->salary_from }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
{{--        {{ Form::label('salary_to', __('messages.job.salary_to').':') }}--}}
        {{ Form::label('salary_to', __('messages.job.salary_to').':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->salary_to }}</p>
    </div>
    <div class="form-group col-xl-3 col-md-3 col-sm-12">
{{--        {{ Form::label('is_freelance', __('messages.job.is_freelance').':') }}--}}
        {{ Form::label('is_freelance', __('messages.job.is_freelance').':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->is_freelance == 1 ? __('messages.common.yes') : __('messages.common.no') }}</p>
    </div>
    <div class="form-group col-xl-3 col-md-3 col-sm-12">
{{--        {{ Form::label('hide_salary', __('messages.job.hide_salary').':') }}--}}
        {{ Form::label('hide_salary',__('messages.job.hide_salary').':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ $job->hide_salary == 1 ? __('messages.common.yes') : __('messages.common.no') }}</p>
    </div>
    <div class="form-group col-xl-3 col-md-3 col-sm-12">
{{--        {{ Form::label('job_expiry_date', __('messages.job.job_expiry_date')) }}--}}
        {{ Form::label('job_expiry_date', __('messages.job.job_expiry_date').':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800">{{ Carbon\Carbon::parse($job->job_expiry_date)->translatedFormat('jS M, Y') }}</p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        {{ Form::label('created_at', __('messages.common.created_on').':') }}
        {{ Form::label('created_at', __('messages.common.created_on').':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800"><span data-toggle="tooltip" data-placement="right"
                 title="{{ date('jS M, Y', strtotime($job->created_at)) }}">{{ $job->created_at->diffForHumans() }}</span>
        </p>
    </div>
    <div class="form-group col-xl-6 col-md-6 col-sm-12">
        {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
        {{ Form::label('updated_at', __('messages.common.last_updated').':'), ['class' => 'form-label fs-6 fw-bolder text-gray-700 mb-3']) }}

        <p  class="fw-bolder fs-6 text-gray-800"><span data-toggle="tooltip" data-placement="right"
                 title="{{ date('jS M, Y', strtotime($job->updated_at)) }}">{{ $job->updated_at->diffForHumans() }}</span>
        </p>
    </div>
</div>
