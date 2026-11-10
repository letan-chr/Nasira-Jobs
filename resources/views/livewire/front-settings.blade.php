<div class="container-fluid">
    <div class="d-flex flex-column">
        @include('flash::message')
        @include('layouts.errors')
        <div class="card">
            <div class="card-body">
                {{ Form::open(['route' => 'front.settings.update','files' => true,]) }}
                @include('front_settings.fields')
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
