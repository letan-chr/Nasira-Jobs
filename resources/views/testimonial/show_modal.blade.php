<div class="modal fade" tabindex="-1" role="dialog" id="showTestimonialModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.testimonial.testimonial_detail') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id' => 'showForm']) }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 mb-5">
                        {{ Form::label('name', __('messages.testimonial.customer_name').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
                        <br>
                        <span id="showCustomerName" class="fs-5 text-gray-800"></span>
                    </div>
                    <div class="col-sm-12 mb-5">
                        {{ Form::label('customer_image', __('messages.testimonial.customer_image').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
                        <br>
                        {{--                        <a href="#" id="documentUrl" target="_blank"></a>--}}
                        <div class="image image-medium">
                            <img src="" id="documentUrl" class="testimonial-modal-img"
                                 style="">
                        </div>
                        <label id="noDocument">{{ __('messages.common.n/a') }}</label>
                    </div>
                    <div class="col-sm-12 mb-5">
                        {{ Form::label('description',__('messages.testimonial.description').':', ['class' => 'pb-2 fs-5 text-gray-600']) }}
                        <br>
                        <div class="reported-note">
                            <span id="showTestimonialDescription" class="fs-5 text-gray-800"></span>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
