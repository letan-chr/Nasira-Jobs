@extends('layouts.app')
@section('title')
    {{ __('messages.email_template.edit_email_template') }}
@endsection
@section('header_toolbar')
    <div class="container-fluid">
        <div class="d-md-flex align-items-center justify-content-between mb-5">
            <h1 class="mb-0">@yield('title')</h1>
            <div class="text-end mt-4 mt-md-0">
                <a href="{!! URL::previous() !!}" class="btn btn-outline-primary">{{ __('messages.common.back') }}</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            <div class="row">
                <div class="col-12">
                    @include('layouts.errors')
                </div>
                {{ Form::model($emailTemplate, ['route' => ['email.template.update', $emailTemplate->id], 'method' => 'put', 'id' => 'editEmailTemplateForm', 'files' => 'true']) }}
                <div class="section-body">
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 mb-5">
                                    {{ Form::label('template_name',__('messages.email_template.template_name').(':'), ['class' => 'form-label']) }}
                                    {{ Form::text('template_name', null, ['id'=>'editEmailTemplate','class' => 'form-control']) }}
                                </div>
                                <div class="col-sm-12 mb-5">
                                    {{ Form::label('subject',__('messages.email_template.subject').(':'), ['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::text('subject', null, ['id'=>'editSubject','class' => 'form-control','required','placeholder' => __('messages.email_template.subject')]) }}
                                </div>
                                <div class="col-sm-12 mb-5">
                                    {{ Form::label('body', __('messages.email_template.body').(':'),['class' => 'form-label']) }}
                                    <span class="required"></span>
                                    {{ Form::hidden('body', null, ['id' => 'editTemplateDescription']) }}
                                    <div id="emailTemplateEditBodyQuillData"> {!! $emailTemplate->body??null !!} </div>
                                </div>
                                <div class="col-sm-12 mb-5">
                                    {{ Form::label('variables',__('messages.email_template.short_code').(':'), ['class' => 'form-label']) }}
                                    {{ Form::text('variables', null, ['class' => 'form-control','readonly']) }}
                                </div>

                                <div class="d-flex justify-content-end mt-5">
                                    {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary me-3']) }}
                                    <a href="{{ route('email.template.index') }}"
                                       class="btn btn-secondary me-2">{{__('messages.common.cancel')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        {{Form::hidden('emailBody',json_encode($emailTemplate->body),['id'=>'editEmailBody'])}}
    </div>
@endsection
