@extends('layouts.app')
@section('title')
    {{ __('messages.roles') }}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column">
            @include('flash::message')
            <livewire:role-table lazy/>
        </div>
    </div>
    {{ Form::hidden('rolesData', true, ['id' => 'indexRolesData']) }}
@endsection
@section('page_scripts')
    <script>
        listenClick('.roles-delete-btn', function (event) {
            let roleId = $(event.currentTarget).attr('data-id');
            deleteItem(route('roles.destroy', roleId), 'Role');
        });
    </script>
@endsection
