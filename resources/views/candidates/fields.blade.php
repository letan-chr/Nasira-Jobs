<div class="row">
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('first_name',__('messages.candidate.first_name').':', ['class' => 'form-label ']) }}
        <span class="required"></span>
        {{ Form::text('first_name', null, ['class' => 'form-control','required', 'placeholder' => __('messages.candidate.first_name')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('last_name',__('messages.candidate.last_name').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('last_name', null, ['class' => 'form-control','required', 'placeholder' => __('messages.candidate.last_name')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('email',__('messages.candidate.email').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{ Form::text('email', null, ['class' => 'form-control','required', 'placeholder' => __('messages.candidate.email')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('father_name',__('messages.candidate.father_name').':', ['class' => 'form-label fs-6']) }}
        {{ Form::text('father_name', null, ['class' => 'form-control ', 'placeholder' => __('messages.candidate.father_name')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('password',__('messages.candidate.password').':', ['class' => 'form-label ']) }}
        <span class="required"></span>
        {{ Form::password('password', ['class' => 'form-control ','required','min' => '6','max' => '10', 'placeholder' => __('messages.candidate.password')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('password_confirmation',__('messages.candidate.conform_password').':', ['class' => 'form-label ']) }}
        <span class="required"></span>
        {{ Form::password('password_confirmation', ['class' => 'form-control ','required','min' => '6','max' => '10', 'placeholder' => __('messages.candidate.conform_password')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('dob', __('messages.candidate.birth_date').':', ['class' => 'form-label  ']) }}
        <input type="text" name="dob" id="birthDate"
               class="form-control {{(getLoggedInUser()->theme_mode) ? 'bg-light' : 'bg-white'}}" autocomplete="off"
               placeholder="{{__('messages.candidate.birth_date')}}">
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('gender', __('messages.candidate.gender').':', ['class' => 'form-label ']) }}
        <span class="required"></span>
        <br>
        <span class="form-check is-valid form-check-sm {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}">
                <label class="form-label ">{{ __('messages.common.male') }}</label>&nbsp;&nbsp;
                {{ Form::radio('gender', '0', true, ['class' => 'form-check-input']) }} &nbsp;
                <br>
                <label class="form-label ">{{ __('messages.common.female') }}</label>
                {{ Form::radio('gender', '1', false, ['class' => 'form-check-input']) }}
            </span>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('skill_id', __('messages.candidate.candidate_skill').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        <div class="input-group flex-nowrap">
            {{Form::select('candidateSkills[]',$data['skills'], null, ['class' => 'form-select custom-select2','id'=>'skillId','multiple'=>true,'required'])}}
            <div class="input-group-text border-0 justify-content-center">
                <a href="javascript:void(0)" class="text-gray-500 createCandidateSkillModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('language_id', __('messages.candidate.candidate_language').':', ['class' => 'form-label ']) }}
        <span class="required"></span>
        <div class="input-group flex-nowrap">
            {{Form::select('candidateLanguage[]',$data['language'], null, ['class' => 'form-select custom-select2','id'=>'languageId','multiple'=>true,'required'])}}
            <div class="input-group-text border-0 justify-content-center">
                <a href="javascript:void(0)" class="text-gray-500 createCandidateLanguageModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('marital_status', __('messages.candidate.marital_status').':', ['class' => 'form-label ']) }}
        <span class="required"></span>
        <div class="input-group flex-nowrap">
            {{ Form::select('marital_status_id', $data['maritalStatus'], null, ['class' => 'form-select','required','id' => 'maritalStatusId','placeholder'=> __('messages.company.select_marital_status')]) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class="text-gray-500 createCandidateMaritalStatusModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('nationality', __('messages.candidate.nationality').':', ['class' => 'form-label']) }}
        {{ Form::text('nationality', null, ['class' => 'form-control ', 'placeholder' => __('messages.candidate.nationality')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('national_id_card', __('messages.candidate.national_id_card').':', ['class' => 'form-label ']) }}
        {{ Form::text('national_id_card', null, ['class' => 'form-control ', 'placeholder' => __('messages.candidate.national_id_card')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('country', __('messages.company.country').':', ['class' => 'form-label ']) }}
        <div class="input-group flex-nowrap">
            {{ Form::select('country_id', $data['countries'], null, ['id'=>'countryId','class' => 'form-select ','placeholder' => __('messages.company.select_country')]) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class="text-gray-500 createCandidateCountryModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('state', __('messages.company.state').':', ['class' => 'form-label ']) }}
        <div class="input-group flex-nowrap">
            {{ Form::select('state_id', [], null, ['id'=>'stateId','class' => 'form-select ','placeholder' => __('messages.company.select_state')]) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class="text-gray-500 createCandidateStateModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('city', __('messages.company.city').':', ['class' => 'form-label ']) }}
        <div class="input-group flex-nowrap">
            {{ Form::select('city_id', [], null, ['id'=>'cityId','class' => 'form-select ','placeholder' => __('messages.company.select_city')]) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class="text-gray-500 createCandidateCityModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-55 mobile-itel-width">
        {{ Form::label('phone', __('messages.candidate.phone').':', ['class' => 'form-label ']) }}
        <br>
        {{ Form::tel('phone', null, ['class' => 'form-control d', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','id'=>'phoneNumber','placeholder' => __('messages.inquiry.phone_no')])}}
        {{ Form::hidden('region_code',null,['id'=>'prefix_code']) }}
        <p id="valid-msg" class="text-success d-none fw-400 fs-small mt-2">{{__('messages.phone.valid_number')}}</p>
        <p id="error-msg" class="text-danger d-none fw-400 fs-small mt-2">{{__('messages.phone.invalid_number')}}</p>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('experience', __('messages.candidate.experience').':', ['class' => 'form-label ']) }}
        <span>({{ __('messages.candidate.in_years') }})</span>
        {{ Form::text('experience', null, ['class' => 'form-control ','min' => '0', 'max' => '15','oninput'=>"validity.valid||(value='');", 'placeholder' => __('messages.candidate.experience'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('career_level', __('messages.candidate.career_level').':', ['class' => 'form-label ']) }}
        <div class="input-group flex-nowrap">
            {{ Form::select('career_level_id', $data['careerLevel'], null, ['class' => 'form-select ','id' => 'careerLevelId','placeholder'=> __('messages.company.select_career_level')]) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class="text-gray-500 createCandidateCareerLevelModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-55">
        {{ Form::label('industry', __('messages.candidate.industry').':', ['class' => 'form-label ']) }}
        <div class="input-group flex-nowrap">
            {{ Form::select('industry_id', $data['industry'], null, ['class' => 'form-select ','id' => 'industryId','placeholder'=> __('messages.company.select_industry')]) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class="text-gray-500 createCandidateIndustryModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('functional_area', __('messages.candidate.functional_area').':', ['class' => 'form-label ']) }}
        <div class="input-group flex-nowrap">
            {{ Form::select('functional_area_id', $data['functionalArea'], null, ['class' => 'form-select ','id' => 'functionalAreaId','placeholder'=> __('messages.company.select_functional_area')]) }}
            <div class="input-group-text border-0">
                <a href="javascript:void(0)" class="text-gray-500 createCandidateFunctionalAreaModal"><i
                            class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('current_salary', __('messages.candidate.current_salary').':', ['class' => 'form-label ']) }}
        {{ Form::text('current_salary', null, ['class' => 'form-control price-input', 'min' => 0, 'max' => 999999999, 'placeholder' => __('messages.candidate.current_salary')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('expected_salary', __('messages.candidate.expected_salary').':', ['class' => 'form-label ']) }}
        {{ Form::text('expected_salary', null, ['class' => 'form-control price-input', 'min' => 0, 'max' => 999999999,'placeholder' => __('messages.candidate.expected_salary')]) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('salary_currency', __('messages.candidate.salary_currency').':', ['class' => 'form-label ']) }}
        {{ Form::select('salary_currency', $data['currency'],null, ['class' => 'form-select ', 'id' => 'salaryCurrencyId']) }}
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('facebook_url', __('messages.company.facebook_url').':', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text border-0">
                <i class="fab fa-facebook-f facebook-fa-icon text-primary"></i>
            </div>
            {{ Form::text('facebook_url',null, ['class' => 'form-control d','id'=>'facebookUrl','placeholder'=>'https://www.facebook.com']) }}
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('twitter_url', __('messages.company.twitter_url').':', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text border-0">
                <i class="fab fa-twitter twitter-fa-icon text-primary"></i>
            </div>
            {{ Form::text('twitter_url', null, ['class' => 'form-control','id'=>'twitterUrl','placeholder'=>'https://www.twitter.com']) }}
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('linkedin_url', __('messages.company.linkedin_url').':', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text border-0">
                <i class="fab fa-linkedin-in linkedin-fa-icon text-primary"></i>
            </div>
            {{ Form::text('linkedin_url', null, ['class' => 'form-control','id'=>'linkedInUrl','placeholder'=>'https://www.linkedin.com']) }}
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('google_plus_url', __('messages.company.google_plus_url').':', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text border-0">
                <i class="fab fa-google-plus-g google-plus-fa-icon text-danger"></i>
            </div>
            {{ Form::text('google_plus_url', null, ['class' => 'form-control ','id'=>'googlePlusUrl','placeholder'=>'https://www.plus.google.com']) }}
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('pinterest_url', __('messages.company.pinterest_url').':', ['class' => 'form-label']) }}
        <div class="input-group">
            <div class="input-group-text border-0">
                <i class="fab fa-pinterest-p pinterest-fa-icon text-danger"></i>
            </div>
            {{ Form::text('pinterest_url', null, ['class' => 'form-control','id'=>'pinterestUrl','placeholder'=>'https://www.pinterest.com']) }}
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                {{ Form::label('immediate_available', __('messages.candidate.immediate_available').':', ['class' => 'form-label']) }}
                <br>
                {{ Form::radio('immediate_available', '1', true, ['class' => 'form-check-input']) }}
                <label class="form-label">{{ __('messages.candidate.immediate_available') }}</label>
                <br>
                {{ Form::radio('immediate_available', '0', false,['class' => 'form-check-input']) }}
                <label class="form-label">{{ __('messages.candidate.not_immediate_available') }}</label>
            </div>

            <div class="col-md-6 col-sm-6">
                <div class="row">
                    <div class="col-md-4 col-sm-12 mb-0 pt-1">
                        <label class='form-label'>{{ __('messages.common.status').':' }}</label><br>
                        <label class="form-check form-switch form-switch-sm {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}">
                            <input type="checkbox" name="is_active" class="form-check-input isActive"
                                   value="1" id="active" checked>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-0 pt-1">
                        <label class='form-label'>{{ __('messages.candidate.is_verified').':' }}</label><br>
                        <label class="form-check form-switch form-switch-sm {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}">
                            <input type="checkbox" name="is_verified" class="form-check-input isActive"
                                   value="1" id="verified" checked>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('available_at', __('messages.candidate.available_at').':', ['class' => 'form-label']) }}
        <input type="text" name="available_at" id="availableAt"
               class="form-control {{(getLoggedInUser()->theme_mode) ? 'bg-light' : 'bg-white'}}" autocomplete="off"
               placeholder="{{__('messages.candidate.available_at')}}">
    </div>
    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
        {{ Form::label('address', __('messages.candidate.address').':', ['class' => 'form-label ']) }}
        {{ Form::textarea('address', null, ['class' => 'form-control address-height', 'rows' => '5','placeholder' => __('messages.candidate.address')]) }}
    </div>
    <div class="d-flex justify-content-end mt-5">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
        <a href="{{ route('candidates.index') }}"
           class="btn btn-secondary me-2">{{__('messages.common.cancel')}}</a>
    </div>
</div>
