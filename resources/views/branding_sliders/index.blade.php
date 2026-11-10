@extends('layouts.app')
@section('title')
    {{ __('messages.branding_sliders') }}
@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('css/header-padding.css') }}">
@endpush
@section('content')
    <div class="container-fluid">
        @include('flash::message')
        <div class="d-flex flex-column ">
            <livewire:branding-sliders-table lazy/>
        </div>
    </div>
    @include('branding_sliders.add_modal')
    @include('branding_sliders.edit_modal')

    {{Form::hidden('default_document_imageUrl',asset('assets/img/infyom-logo.png'),['id' => 'defaultDocumentImageUrl'])}}
    {{Form::hidden('view',__('messages.common.view'), ['id' => 'view'])}}
    {{Form::hidden('branding-extension-message',__('messages.image_slider.image_extension_message'),['id' => 'brandingExtensionMessage'])}}

@endsection
