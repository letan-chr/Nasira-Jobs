<div id="addBlogCategoryModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.post_category.new_post_category') }}</h3>
                <button type="button" aria-label="Close" class="btn-close m-0"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id'=>'addPostCategoryForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none"
                     id="validationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="mb-5">
                    {{ Form::label('name',__('messages.post_category.name').(':'), ['class' => 'form-label']) }}
                    <span class="required"></span>
                    {{ Form::text('name', null, ['id'=>'name','class' => 'form-control','required', 'placeholder' =>__('messages.post_category.name') ]) }}
                </div>
                <div class="mb-5">
                    {{ Form::label('description', __('messages.post_category.description').(':'),['class' => 'form-label']) }}
                    <span class="required"></span>
                    <div id="addBlogCategoryDescriptionQuillData"></div>
                    {{ Form::hidden('description', null, ['id' => 'post_category_desc']) }}
                </div>
            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type' => 'submit','class' => 'btn btn-primary m-0','id' => 'addBlogCategorySaveBtn','data-loading-text' => "<span class='spinner-border spinner-border-sm'></span> ".__('messages.common.process')]) }}
                <button type="button" class="btn btn-secondary my-0 {{ checkLanguageSession() == 'ar' ? 'me-5' : 'ms-5' }} me-0"
                        id="btnCancel"
                        data-bs-dismiss="modal">{{ __('messages.common.cancel') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

