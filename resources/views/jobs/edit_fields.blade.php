<div class="row">
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('company_id', __('messages.company.company_name').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::select('company_id', $data['companies'],null, ['id'=>'companyId','class' => 'form-select io-select2','required', 'data-control'=>'select2','placeholder' =>  __('messages.company.select_company')] ) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('job_title', __('messages.job.job_title').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('job_title', null, ['class' => 'form-control','required', 'placeholder' => __('messages.job.job_title')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('job_type_id', __('messages.job.job_type').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        <div class="input-group flex-nowrap">
            {{ Form::select('job_type_id', $data['jobType'],null, ['id'=>'jobTypeId','class' => 'form-select','placeholder' => __('messages.company.select_job_type'),'required', 'data-control'=>'select2']) }}
            <div class="input-group-text  border-0">
                <a href="javascript:void(0)" class="text-gray-500 createJobTypeModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('job_category_id', __('messages.job_category.job_category').':', ['class' => 'form-label ']) }}

        <span class="required"></span>
        <div class="input-group flex-nowrap">
            {{ Form::select('job_category_id', $data['jobCategory'],null, ['id'=>'jobCategoryId','class' => 'form-select io-select2 ','placeholder' => __('messages.company.select_job_category'),'required', 'data-control'=>'select2']) }}
            <div class="input-group-text t border-0">
                <a href="javascript:void(0)" class="text-gray-500 createJobCategoryModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('skill_id', __('messages.job.job_skill').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        <div class="input-group flex-nowrap">
            {{Form::select('jobsSkill[]',$data['jobSkill'], null, ['class' => 'form-select custom-select2','id'=>'SkillId','multiple'=>true,'required','data-control'=>"select2" ])}}
            {{--            <div class="input-group-append">--}}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class="text-gray-500 createSkillModal"><i class="fa fa-plus"></i></a>
            </div>
            {{--            </div>--}}
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('no_preference', __('messages.candidate.gender').':', ['class' => 'form-label']) }}
        {{ Form::select('no_preference', $data['preference'], null, ['id'=>'preferenceId','class' => 'form-select','placeholder' => __('messages.company.select_gender'), 'data-control'=>'select2']) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('job_expiry_date', __('messages.job.job_expiry_date').':', ['class' => 'form-label']) }} <span
                class="required"></span>

        <div class="input-group">
            {{--            <div class="input-group-prepend">--}}
            <div class="input-group-text border-0">
                <i class="fas fa-calendar-alt"></i>
            </div>
            {{--            </div>--}}
            <input type="text" name="job_expiry_date"
                   class="form-control expiryDatepicker {{(getLoggedInUser()->theme_mode) ? 'bg-light' : 'bg-white'}}"
                   autocomplete="off" placeholder="{{__('messages.job.job_expiry_date')}}"
                   value="{{isset($job->job_expiry_date) ? $job->job_expiry_date : null}}" required>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('salary_from', __('messages.job.salary_from').':', ['class' => 'form-label']) }}<span
                class="required"></span>
        {{ Form::text('salary_from', null, ['class' => 'form-control salary', 'id' => 'fromSalary', 'required', 'placeholder' => __('messages.job.salary_from')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('salary_to', __('messages.job.salary_to').':',  ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('salary_to', null, ['class' => 'form-control salary', 'id' => 'toSalary', 'required', 'placeholder' => __('messages.job.salary_to')]) }}
        <span id="salaryToErrorMsg" class="text-danger"></span>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('currency_id', __('messages.job.currency').':',  ['class' => 'form-label ']) }}
        <span class="required"></span>
        {{ Form::select('currency_id', $data['currencies'], null, ['id'=>'currencyId','class' => 'form-select','placeholder' => __('messages.company.select_currency'),'required', 'data-control'=>'select2']) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('salary_period_id', __('messages.job.salary_period').':', ['class' => 'form-label ']) }}
        <span class="required"></span>
        <div class="input-group flex-nowrap">
            {{ Form::select('salary_period_id', $data['salaryPeriods'], null, ['id'=>'salaryPeriodsId','class' => 'form-select','placeholder' =>  __('messages.company.select_salary_period'),'required', 'data-control'=>'select2']) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class=" text-gray-500 createSalaryPeriodModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('country', __('messages.company.country').':',  ['class' => 'form-label ']) }}
        <span class="required"></span>
        <div class="input-group flex-nowrap">
            {{ Form::select('country_id', $data['countries'], null, ['id'=>'countryId','class' => 'form-select','placeholder' => __('messages.company.select_country'),'required', 'data-control'=>'select2']) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class=" text-gray-500 createCountryModal"><i class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('state', __('messages.company.state').':',  ['class' => 'form-label ']) }}
        <span class="required"></span>
        <div class="input-group flex-nowrap">
            {{ Form::select('state_id', (isset($states) && $states!=null?$states:[]), null, ['id'=>'stateId','class' => 'form-select','placeholder' => __('messages.company.select_state'), 'data-control'=>'select2']) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class=" text-gray-500 createStateModal"><i class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('city', __('messages.company.city').':', ['class' => 'form-label ']) }}<span
                class="required"></span>
        <div class="input-group flex-nowrap">
            {{ Form::select('city_id', (isset($cities) && $cities!=null?$cities:[]), null, ['id'=>'cityId','class' => 'form-select','placeholder' => __('messages.company.select_city'),'required', 'data-control'=>'select2']) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class=" text-gray-500 createCityModal"><i class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-55">
        {{ Form::label('career_level_id', __('messages.job.career_level').':', ['class' => 'form-label ']) }}
        <div class="input-group flex-nowrap">
            {{ Form::select('career_level_id', $data['careerLevels'],null, ['id'=>'careerLevelsId','class' => 'form-select','placeholder' => __('messages.company.select_career_level'), 'data-control'=>'select2']) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class=" text-gray-500 createCareerLevelModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('job_shift_id', __('messages.job.job_shift').':', ['class' => 'form-label ']) }}
        <div class="input-group flex-nowrap">
            {{ Form::select('job_shift_id', $data['jobShift'], null, ['id'=>'jobShiftId','class' => 'form-select','placeholder' => __('messages.company.select_job_shift'), 'data-control'=>'select2']) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class=" text-gray-500 createJobShiftModal"><i class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('tagId', __('messages.job_tag.show_job_tag').':', ['class' => 'form-label ']) }}
        <div class="input-group flex-nowrap">
            {{Form::select('jobTag[]',$data['jobTag'], (count($data['jobTags']) > 0)?$data['jobTags']:null, ['class' => 'form-select','id'=>'tagId','multiple'=>true, 'data-control'=>'select2'])}}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class=" text-gray-500 createJobTagModal"><i class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('degree_level_id', __('messages.job.degree_level').':', ['class' => 'form-label ']) }}
        <div class="input-group flex-nowrap">
            {{ Form::select('degree_level_id', $data['requiredDegreeLevel'], null, ['id'=>'requiredDegreeLevelId','class' => 'form-select','placeholder' => __('messages.company.select_degree_level'), 'data-control'=>'select2']) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class=" text-gray-500 createRequiredDegreeLevelTypeModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-55">
        {{ Form::label('functional_area_id', __('messages.job.functional_area').':', ['class' => 'form-label ']) }}
        <span class="required"></span>
        <div class="input-group flex-nowrap">
            {{ Form::select('functional_area_id', $data['functionalArea'], null, ['id'=>'functionalAreaId','class' => 'form-select','placeholder' => __('messages.company.select_functional_area'),'required', 'data-control'=>'select2']) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class=" text-gray-500 createFunctionalAreaModal"><i class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('position', __('messages.job.position').':', ['class' => 'form-label ']) }}
        <span class="required"></span>
        {{ Form::text('position',  null, ['id'=>'positionId','class' => 'form-control','placeholder' =>  __('messages.company.select_position'),'required', 'min' => 0, 'max' => 255, 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
         {{ Form::label('key_responsibilities', __('messages.job.key_responsibilities') . ':', ['class' => 'form-label ']) }}<span
             class="required"></span>
         <div id="editResponse"></div>
         {{ Form::hidden('key_responsibilities', $job->key_responsibilities, ['id' => 'edit_responsibilities']) }}
     </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('description', __('messages.job.description').':', ['class' => 'form-label ']) }}<span
                class="required"></span>
        <div id="editDetails"></div>
        {{ Form::hidden('description', $job->description, ['id' => 'editJobDescription']) }}
        {{--        {{ Form::textarea('description', null, ['class' => 'form-control' , 'id' => 'details', 'rows' => '5']) }}--}}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
         {{ Form::label('experience', __('messages.job_experience.job_experience').':', ['class' => 'form-label ']) }}

         <span class="required"></span>
         {{ Form::text('experience',  null, ['id'=>'experienceId','class' => 'form-control','placeholder' => __('messages.company.enter_experience_year'), 'min' => 0, 'max' => 255, 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
     </div>
    {{--    <div class="form-group col-xl-3 col-md-3 col-sm-12 mb-5">--}}
    {{--        <label>{{ __('messages.job.hide_salary').':' }}</label>--}}
    {{--        <label class="custom-switch pl-0 col-12">--}}
    {{--            <input type="checkbox" name="hide_salary" class="custom-switch-input"--}}
    {{--                   id="salary" value="1" {{$job->hide_salary == 1? 'checked' : ''}}>--}}
    {{--           --}}
    {{--        </label>--}}
{{--    </div>--}}

    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        <label class="form-label ">{{ __('messages.job.hide_salary').':' }}</label>
        <label class="form-check form-switch form-switch-sm">
            <input type="checkbox" name="hide_salary" class="form-check-input"
                   id="salary" value="1" {{$job->hide_salary == 1? 'checked' : ''}}>
        </label>
    </div>
{{--    <div class="form-group col-xl-3 col-md-3 col-sm-12 mb-5">--}}
{{--        <label>{{ __('messages.job.is_freelance').':' }}</label>--}}
{{--        <label class="custom-switch pl-0 col-12">--}}
{{--            <input type="checkbox" name="is_freelance" class="custom-switch-input"--}}
{{--                   id="freelance" value="1" {{$job->is_freelance == 1? 'checked' : ''}}>--}}
{{--            <span class="custom-switch-indicator"></span>--}}
{{--        </label>--}}
{{--    </div>--}}
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        <label class="form-label">{{ __('messages.job.is_freelance').':' }}</label>
        <label class="form-check form-switch form-switch-sm">
            <input type="checkbox" name="is_freelance" class="form-check-input"
                   id="freelance" value="1" {{$job->is_freelance == 1? 'checked' : ''}}>
        </label>
    </div>

    <!-- Submit Field -->
    <div class="d-flex justify-content-end">
        {{--        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3','name' => 'save', 'id' => 'saveJob']) }}--}}
        {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary me-3','id' => 'editJobsSaveBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
        <a href="{{ route('admin.jobs.index') }}"
           class="btn btn-secondary me-2">{{__('messages.common.cancel')}}</a>
    </div>
</div>
