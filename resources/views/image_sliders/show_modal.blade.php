<div class="modal fade" tabindex="-1" role="dialog" id="showModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">{{ __('messages.image_slider.image_slider_details') }}</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ Form::open(['id' => 'showForm']) }}
            <div class="modal-body">
                <div class="row details-page">
                    <div class="col-sm-6">
                        {{ Form::label('name',__('messages.image_slider.image').':') }}<br>
                        <img src="" id="documentUrl" class="img-thumbnail thumbnail-preview" alt="image"/>
                        <label id="noDocument">{{ __('messages.n/a') }}</label>
                    </div>
                    <div class="col-sm-6">
                        {{ Form::label('status',__('messages.common.status').':') }}<br>
                        <span id="showStatus"></span>
                    </div>
                    <div class="col-sm-12">
                        {{ Form::label('description',__('messages.common.description').':') }}<br>
                    <div class="reported-note">
                        <span id="showDescription"></span>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>
</div>
