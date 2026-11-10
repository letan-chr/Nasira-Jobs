@extends('candidate.profile.index')
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/inttel/css/intlTelInput.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css') }}">
@endpush
@section('section')
    <div class="card">
        <div class="card-body">
            {{ Form::model($user, ['route' => 'candidate-profile.update', 'files' => true, 'id' => 'candidateProfileUpdate', 'method' => 'put']) }}
            <div class="mt-5">
                <div class="alert alert-danger d-none" id="validationErrors">
                    <i class='fa-solid fa-face-frown me-4'></i>
                </div>
                <div class="row mb-5">
                    {{ Form::hidden('isEdit', true, ['id' => 'isEdit']) }}
                    <div class="col-xl-6 col-md-6 col-sm-6 mb-5">
                        {{ Form::label('first_name', __('messages.candidate.first_name') . ':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('first_name', $user->first_name, ['class' => 'form-control', 'required', 'placeholder' => __('messages.candidate.first_name')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-6 mb-5">
                        {{ Form::label('last_name', __('messages.candidate.last_name') . ':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('last_name', $user->last_name, ['class' => 'form-control ', 'required', 'placeholder' => __('messages.candidate.last_name')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6  col-sm-6  mb-5">
                        {{ Form::label('email', __('messages.company.email') . ':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::email('email', isset($user) ? $user->email : null, ['class' => 'form-control ', 'required', 'placeholder' => __('messages.company.email')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-6 mb-5">
                        {{ Form::label('father_name', __('messages.candidate.father_name') . ':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::text('father_name', $user->candidate->father_name, ['class' => 'form-control', 'required', 'placeholder' => __('messages.candidate.father_name')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-6 mb-5">
                        {{ Form::label('dob', __('messages.candidate.birth_date') . ':', ['class' => 'form-label']) }}
                        <input type="text" name="dob" id="birthDate"
                            class="form-control {{ getLoggedInUser()->theme_mode ? 'bg-light' : 'bg-white' }}"
                            autocomplete="off" placeholder="{{ __('messages.candidate.birth_date') }}"
                            value="{{ $user->dob }}">
                    </div>
                    <div class="col-sm-6 mb-5">
                        {{ Form::label('gender', __('messages.candidate.gender') . ':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        <br>
                        <span class="form-check is-valid form-check-sm">
                            <label
                                class="form-label {{ checkLanguageSession() == 'ar' ? 'me-8' : '' }}">{{ __('messages.common.male') }}</label>&nbsp;&nbsp;
                            {{ Form::radio('gender', '0', isset($user->gender) ? $user->gender == 0 : true, ['class' => 'form-check-input' . (checkLanguageSession() == 'ar' ? ' float-end' : ''), 'id' => 'male']) }}
                            &nbsp;
                            <br>
                            <label
                                class="form-label {{ checkLanguageSession() == 'ar' ? 'me-8' : '' }}">{{ __('messages.common.female') }}</label>
                            {{ Form::radio('gender', '1', isset($user->gender) ? $user->gender == 1 : true, ['class' => 'form-check-input' . (checkLanguageSession() == 'ar' ? ' float-end' : ''), 'id' => 'female']) }}
                        </span>

                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('skill_id', __('messages.candidate.candidate_skill') . ':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::select('candidateSkills[]', $data['skills'], count($candidateSkills) > 0 ? $candidateSkills : null, ['id' => 'skillId', 'class' => 'form-select ', 'multiple' => true, 'required']) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('language_id', __('messages.candidate.candidate_language') . ':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::select('candidateLanguage[]', $data['language'], count($candidateLanguage) > 0 ? $candidateLanguage : null, ['class' => 'form-select ', 'id' => 'languageId', 'multiple' => true, 'required']) }}
                    </div>

                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('marital_status', __('messages.candidate.marital_status') . ':', ['class' => 'form-label']) }}
                        <span class="required"></span>
                        {{ Form::select('marital_status_id', $data['maritalStatus'], isset($user->candidate->marital_status_id) ? $user->candidate->marital_status_id : null, ['class' => 'form-select ', 'id' => 'maritalStatusId', 'required']) }}

                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('nationality', __('messages.candidate.nationality') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('nationality', isset($user->candidate->nationality) ? $user->candidate->nationality : null, ['class' => 'form-control ', 'placeholder' => __('messages.candidate.nationality')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('national_id_card', __('messages.candidate.national_id_card') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('national_id_card', isset($user->candidate->national_id_card) ? $user->candidate->national_id_card : null, ['class' => 'form-control ', 'placeholder' => __('messages.candidate.national_id_card')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('country', __('messages.company.country') . ':', ['class' => 'form-label']) }}
                        {{ Form::select('country_id', $data['countries'], null, ['class' => 'form-select ', 'id' => 'countryId', 'placeholder' => __('messages.company.select_country')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('state', __('messages.company.state') . ':', ['class' => 'form-label']) }}
                        {{ Form::select('state_id', isset($states) && $states != null ? $states : [], null, ['id' => 'stateId', 'class' => 'form-select', 'placeholder' => __('messages.company.select_state')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('city', __('messages.company.city') . ':', ['class' => 'form-label']) }}
                        {{ Form::select('city_id', isset($cities) && $cities != null ? $cities : [], null, ['class' => 'form-select ', 'id' => 'cityId', 'placeholder' => __('messages.company.select_city')]) }}
                    </div>
                    <div class="col-sm-6 mb-5 mobile-itel-width">
                        {{ Form::label('phone', __('messages.candidate.phone') . ':', ['class' => 'form-label']) }}
                        <div class="col-sm-12 mb-5">
                            {{ Form::tel('phone', isset($user->phone) ? $user->phone : null, ['class' => 'form-control', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")', 'id' => 'phoneNumber']) }}
                        </div>
                        {{ Form::hidden('region_code', null, ['id' => 'prefix_code']) }}
                        <span id="valid-msg"
                            class="text-success d-block fw-400 fs-small mt-2 d-none">{{ __('messages.phone.valid_number') }}</span>
                        <span id="error-msg" class="text-danger d-block fw-400 fs-small mt-2 d-none"></span>
                    </div>

                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('experience', __('messages.candidate.experience') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('experience', isset($user->candidate->experience) ? $user->candidate->experience : null, ['class' => 'form-control', 'min' => '0', 'max' => '15', 'placeholder' => __('messages.candidate.experience'), 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('career_level', __('messages.candidate.career_level') . ':', ['class' => 'form-label']) }}
                        {{ Form::select('career_level_id', $data['careerLevel'], isset($user->candidate->career_level_id) ? $user->candidate->career_level_id : null, ['class' => 'form-select', 'id' => 'careerLevelId', 'placeholder' => __('messages.company.select_career_level')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('industry', __('messages.candidate.industry') . ':', ['class' => 'form-label']) }}
                        {{ Form::select('industry_id', $data['industry'], isset($user->candidate->industry_id) ? $user->candidate->industry_id : null, ['class' => 'form-select', 'id' => 'industryId', 'placeholder' => __('messages.company.select_industry')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('functional_area', __('messages.candidate.functional_area') . ':', ['class' => 'form-label']) }}
                        {{ Form::select('functional_area_id', $data['functionalArea'], isset($user->candidate->functional_area_id) ? $user->candidate->functional_area_id : null, ['class' => 'form-select', 'id' => 'functionalAreaId', 'placeholder' => __('messages.company.select_functional_area')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('current_salary', __('messages.candidate.current_salary') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('current_salary', isset($user->candidate->current_salary) ? $user->candidate->current_salary : null, ['class' => 'form-control', 'placeholder' => __('messages.candidate.current_salary')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('expected_salary', __('messages.candidate.expected_salary') . ':', ['class' => 'form-label']) }}
                        {{ Form::text('expected_salary', isset($user->candidate->expected_salary) ? $user->candidate->expected_salary : null, ['class' => 'form-control', 'placeholder' => __('messages.candidate.expected_salary')]) }}
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('salary_currency', __('messages.candidate.salary_currency') . ':', ['class' => 'form-label']) }}
                        {{ Form::select('salary_currency', $data['currency'], isset($user->candidate->salary_currency) ? $user->candidate->salary_currency : null, ['class' => 'form-select', 'id' => 'salaryCurrencyId', 'placeholder' => __('messages.company.select_currency')]) }}
                    </div>

                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('immediate_available', __('messages.candidate.immediate_available') . ':', ['class' => 'form-label']) }}
                        <br>
                        <span class="form-check is-valid form-check-sm">
                            <label
                                class="form-label {{ checkLanguageSession() == 'ar' ? 'me-8' : '' }}">{{ __('messages.candidate.immediate_available') }}</label>&nbsp;&nbsp;
                            {{ Form::radio('immediate_available', '1', isset($user->candidate->immediate_available) ? $user->candidate->immediate_available == 1 : true, ['class' => 'form-check-input' . (checkLanguageSession() == 'ar' ? ' float-end' : ''), 'id' => 'available']) }}
                            &nbsp;
                            <br>
                            <label
                                class="form-label {{ checkLanguageSession() == 'ar' ? 'me-8' : '' }}">{{ __('messages.candidate.not_immediate_available') }}</label>
                            {{ Form::radio('immediate_available', '0', isset($user->candidate->immediate_available) ? $user->candidate->immediate_available == 0 : true, ['class' => 'form-check-input' . (checkLanguageSession() == 'ar' ? ' float-end' : ''), 'id' => 'not_available']) }}
                        </span>


                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5 available-at">
                        {{ Form::label('available_at', __('messages.candidate.available_at') . ':', ['class' => 'form-label  mb-3']) }}
                        <input type="text" name="available_at" id="availableAt"
                            class="form-control {{ getLoggedInUser()->theme_mode ? 'bg-light' : 'bg-white' }}"
                            placeholder="{{ __('messages.candidate.available_at') }}"
                            value="{{ isset($user->candidate->available_at) ? $user->candidate->available_at : null }}">
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('facebook_url', __('messages.company.facebook_url') . ':', ['class' => 'form-label']) }}
                        <div class="input-group">
                            <div class="input-group-text border-0">
                                <i class="fab fa-facebook-f facebook-fa-icon text-primary"></i>
                            </div>
                            {{ Form::text('facebook_url', $user->facebook_url, ['class' => 'form-control', 'id' => 'facebookUrl', 'placeholder' => 'https://www.facebook.com']) }}
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('twitter_url', __('messages.company.twitter_url') . ':', ['class' => 'form-label']) }}
                        <div class="input-group">
                            <div class="input-group-text border-0">
                                <i class="fab fa-twitter twitter-fa-icon text-primary"></i>
                            </div>
                            {{ Form::text('twitter_url', $user->twitter_url, ['class' => 'form-control', 'id' => 'twitterUrl', 'placeholder' => 'https://www.twitter.com']) }}
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('linkedin_url', __('messages.company.linkedin_url') . ':', ['class' => 'form-label']) }}
                        <div class="input-group">
                            <div class="input-group-text border-0">
                                <i class="fab fa-linkedin-in linkedin-fa-icon text-primary"></i>
                            </div>
                            {{ Form::text('linkedin_url', $user->linkedin_url, ['class' => 'form-control', 'id' => 'linkedInUrl', 'placeholder' => 'https://www.linkedin.com']) }}
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('google_plus_url', __('messages.company.google_plus_url') . ':', ['class' => 'form-label']) }}
                        <div class="input-group">
                            <div class="input-group-text border-0">
                                <i class="fab fa-google-plus-g google-plus-fa-icon text-danger"></i>
                            </div>
                            {{ Form::text('google_plus_url', $user->google_plus_url, ['class' => 'form-control', 'id' => 'googlePlusUrl', 'placeholder' => 'https://www.plus.google.com']) }}
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('pinterest_url', __('messages.company.pinterest_url') . ':', ['class' => 'form-label']) }}
                        <div class="input-group">
                            <div class="input-group-text border-0">
                                <i class="fab fa-pinterest-p pinterest-fa-icon text-danger"></i>
                            </div>
                            {{ Form::text('pinterest_url', $user->pinterest_url, ['class' => 'form-control', 'id' => 'pinterestUrl', 'placeholder' => 'https://www.pinterest.com']) }}
                        </div>
                    </div>
                    <div class="col-sm-6 mb-5">
                        <div class="mb-3" io-image-input="true">
                            <label for="exampleInputImage" class="form-label">
                                {{ __('messages.candidate.profile') }}:</label>
                            <span data-bs-toggle="tooltip" data-placement="top"
                                data-bs-original-title="{{ __('messages.setting.image_validation') }}">
                                <i class="fas fa-question-circle ml-1 general-question-mark"></i>
                            </span>
                            <div class="d-block">
                                <div class="image-picker">
                                    <div class="image previewImage" id="exampleInputImage"
                                        style="background-image: url({{ !empty($user->media[0]) ? $user->media[0]->getFullUrl() : asset('assets/img/infyom-logo.png') }})">
                                    </div>
                                    <span class="picker-edit rounded-circle text-gray-500 fs-small"
                                        data-bs-toggle="tooltip" data-placement="top"
                                        data-bs-original-title="{{ __('messages.tooltip.change_profile') }}">
                                        <label>
                                            <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                                            <input type="file" name="image" class="image-upload d-none"
                                                accept="image/*" />
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-md-6 col-sm-12 mb-5">
                        {{ Form::label('address', __('messages.candidate.address') . ':', ['class' => 'form-label']) }}
                        {{ Form::textarea('address', isset($user->candidate->address) ? $user->candidate->address : null, ['class' => 'form-control', 'rows' => '5', 'placeholder' => __('messages.candidate.address')]) }}
                    </div>

                    <!-- Submit Field -->
                    <div class="d-flex justify-content-end">
                        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3 btnSave']) }}
                        {{--                <a href="" --}}
                        {{--               class="btn btn-light btn-active-light-primary me-2">{{__('messages.common.cancel')}}</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
@push('scripts')
    <script>
        var phoneNo = "{{ old('region_code') . old('phone') }}";
    </script>
    {{--    <script src="{{mix('assets/js/custom/input_price_format.js')}}"></script> --}}
    {{--    <script src="{{mix('assets/js/candidate-profile/candidate-general.js')}}"></script> --}}
    {{--    <script src="{{ mix('assets/js/custom/phone-number-country-code.js') }}"></script> --}}
@endpush
