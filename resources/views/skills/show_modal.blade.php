<div id="showSkillsModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.skill.skill_detail') }}</h3>
                <button type="button" aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>
            {{ Form::open(['id' => 'showForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none" id="skillValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                    <div class="mb-5">
                        {{ Form::label('name',__('messages.skill.name').':', ['class' => 'form-label']) }}
                        <p id="showSkillName" class="text-gray-600"></p>
                    </div>
                    <div class="mb-5">
                        {{ Form::label('description', __('messages.skill.description').(':'),['class' => 'form-label']) }}
                        <p id="showSkillDescription" class="text-gray-600"></p>
                    </div>

                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

