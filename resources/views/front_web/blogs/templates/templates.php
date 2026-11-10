<script id="blogTemplate" type="text/x-jsrender">

<div class="comment-card card py-20 mb-40">
    <div class="d-flex flex-sm-row justify-content-between align-items-start">
        <div class="d-flex align-items-center me-2">
            <div class="card-img me-4">
                <img class="card-img" src="{{:image}}" alt="user-image">
            </div>
            <div class="">
                <div class="card-body p-0">
                    <h5 class="card-title w-100 fs-16 text-secondary text-break">
                    {{:commentName}}
                    </h5>
                    <p class="fs-16 text-gray mb-0 text-break"
                        id="comment-{{ $commentRecord->id }}">
                        {{:comment}}
                    </p>
                </div>
            </div>
        </div>
        {{if user}}
        <div class="">
            <div class="d-inline-flex ms-2 mt-2">
                <a href="javascript:void(0)" title="{{ __('messages.common.edit') }}"
                        class="edit-comment-btn action-btn" data-id="{{:id}}">
                    <div class="badge text-primary py-2 ms-1" data-text="Edit Comment">
                        <span class="fa fa-pencil"></span>
                    </div>
                </a>
                <a href="javascript:void(0)" title="{{ __('messages.common.delete') }}"
                        class="action-btn delete-comment-btn float-right"
                        data-id="{{:id}}">
                    <div class="badge text-danger py-2 ms-1" data-text="Delete Comment">
                        <span class="fa fa-trash"></span>
                    </div>
                </a>
            </div>
        </div>
        {{/if}}
    </div>
    <div class="text-end text-nowrap">
        <span class="fs-14 text-gray">{{:commentCreated}}</span>
    </div>
</div>

</script>
