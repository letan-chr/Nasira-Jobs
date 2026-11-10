{{ Form::open(['route' => 'privacy.policy.update', 'id' => 'policyTerms']) }}
<div class="row">
    <div class="my-6">
        {{ Form::label('privacy_policy', __('messages.setting.privacy_policy').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{--        {{ Form::textarea('privacy_policy', $privacyPolicy['privacy_policy'], ['class' => 'form-control h-75', 'id' => 'descriptionPolicy']) }}--}}
        <div id="addPrivacyPolicyDescriptionQuillData"></div>
        {{ Form::hidden('privacy_policy', null, ['id' => 'privacyData']) }}
        <br>
    </div>
</div>
<div class="row">
    <div class="my-6">
        {{ Form::label('terms_conditions', __('messages.setting.terms_conditions').':', ['class' => 'form-label']) }}
        <span class="required"></span>
        {{--        {{ Form::textarea('terms_conditions', $privacyPolicy['terms_conditions'], ['class' => 'form-control h-75', 'id' => 'descriptionTerms']) }}--}}
        <div id="addTermConditionDescriptionQuillData"></div>
        {{ Form::hidden('terms_conditions', null, ['id' => 'termData']) }}
    </div>
</div>
<div class="d-flex justify-content-end">
    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary']) }}
    </div>
{{ Form::close() }}
