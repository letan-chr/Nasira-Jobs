@extends('settings.index')
@section('title')
    {{ __('messages.setting.about_us') }}
@endsection
@section('section')
    {{ Form::open(['route' => 'settings.update', 'id' => 'aboutUsForm']) }}
    {{ Form::hidden('sectionName', $sectionName) }}
    <div class="row mt-3">
        <div class="col-sm-12 my-0">
            {{ Form::label('about_us', __('messages.about_us').':', ['class' => 'form-label']) }}
            <span class="required"></span>
            {{--            {{ Form::textarea('about_us', $setting['about_us'], ['class' => 'form-control h-75', 'id' => 'aboutUs', 'rows' => '5']) }}--}}
            <div id="aboutUs"></div>
            {{ Form::hidden('about_us', $setting['about_us'], ['id' => 'aboutUsData']) }}
        </div>
    </div>
    <div class="mt-4 mb-5">
        <div class="d-flex justify-content-end">
            {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary me-3','id' => 'btnAboutUs']) }}
            <a href="{{ route('settings.index', ['section' => 'about_us']) }}"
               class="btn btn-secondary me-2">{{__('messages.common.cancel')}}</a>
        </div>
    </div>
    {{ Form::close() }}
@endsection
@push('scripts')
    <script>
        let aboutUsData = `{{$setting['about_us']}}`;
    </script>
@endpush
