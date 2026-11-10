<div class="col-xl-4 col-md-6 candidate-card">
    <div class="hover-effect-employee position-relative mb-5 border-hover-primary employee-border">
        <div class="employee-listing-details">
            <div class="d-flex employee-listing-description align-items-center justify-content-center flex-column">
                <div class="w-100">
                    <div class="pl-0 mb-2 employee-avatar mx-auto">
                        <img src="{{ $jobCategory->image_url }}"
                             class="img-responsive users-avatar-img employee-img mr-2">
                    </div>
                    <div class="text-left employee-data text-limit mx-auto d-flex justify-content-center">
                        <span class="text-decoration-none text-color-gray align-items-center text-truncate">
                            <a href="#" class="show-btn"
                               data-id="{{$jobCategory->id}}">{{ Str::limit($jobCategory->name,30) }}</a>
                            </span>
                    </div>
                    <div class="text-left employee-date mt-2">
                        <label class="custom-switch pl-0 job-cat-switch d-flex justify-content-center">
                            <input type="checkbox" name="show_to_staff" class="custom-switch-input isFeatured"
                                   data-id="{{$jobCategory->id}}" {{$jobCategory->is_featured === false ? '' : 'checked'}}>
                            <span class="custom-switch-indicator"></span>
                            <span class="employee-label ml-1 w-auto">{{ __('messages.job_category.is_featured') }}</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="employee-action-btn">
            <a title="{{ __('messages.common.edit') }}" class="btn btn-warning action-btn edit-btn"
               data-id="{{$jobCategory->id}}" href="#">
                <i class="fa fa-edit"></i>
            </a>
            <a title="{{ __('messages.common.delete') }}" class="btn btn-danger action-btn delete-btn"
               data-id="{{$jobCategory->id}}" href="#">
                <i class="fa fa-trash"></i>
            </a>
        </div>
    </div>
</div>
