@extends('layouts.app')
@section('title')
    {{ __('messages.header_sliders') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
    @include('flash::message')
    <div class="container-fluid">
        @include('flash::message')
        <livewire:header-sliders-component lazy :settings="$settings"/>

        <div class="d-flex flex-column ">
            <livewire:header-slider-table lazy/>
        </div>
        @include('header_sliders.add_modal')
        @include('header_sliders.edit_modal')

                {{Form::hidden('default_document_imageUrl',asset('assets/img/infyom-logo.png'),['id' => 'defaultDocumentImageUrl'])}}
                {{Form::hidden('view',__('messages.common.view'), ['id' => 'view'])}}
                {{Form::hidden('header-size-message',__('messages.header_slider.image_size_message'),['id' => 'headerSizeMessage'])}}
                {{Form::hidden('header-extension-message',__('messages.image_slider.image_extension_message'),['id' => 'headerExtensionMessage'])}}

            </div>
@endsection
{{--@push('scripts')--}}
{{--    <script src="{{mix('assets/js/header_sliders/header_sliders.js')}}"></script>--}}
{{--@endpush--}}
