@extends('layouts.app')
@section('title')
    {{ __('messages.image_sliders') }}
@endsection
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <livewire:image-sliders-component lazy/>

        <div class="d-flex flex-column ">
            <livewire:image-slider-table lazy/>
        </div>

    </div>
    @include('image_sliders.add_modal')
    @include('image_sliders.edit_modal')
    @include('image_sliders.show_modal')

    {{Form::hidden('default_document_imageUrl',asset('assets/img/infyom-logo.png'),['id' => 'defaultDocumentImageUrl'])}}
    {{Form::hidden('view',__('messages.common.view'), ['id' => 'view'])}}
    {{Form::hidden('header-size-message',__('messages.image_slider.image_size_message'),['id' => 'imageSizeMessage'])}}
    {{Form::hidden('header-extension-message',__('messages.image_slider.image_extension_message'),['id' => 'imageExtensionMessage'])}}
@endsection
{{--@push('scripts')--}}
{{--    <script src="{{mix('assets/js/image_slider/image_slider.js')}}"></script>--}}
{{--@endpush--}}
