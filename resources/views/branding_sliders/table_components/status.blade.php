<div class="d-flex justify-content-center">
    @if($row->is_active == 0)
        <label class="form-check form-switch form-switch-sm justify-content-center">
            <input type="checkbox" name="Is isActive" class="form-check-input isActiveBrandingSlider" data-id="{{$row->id}}">
            <span class=""></span>
        </label>
    @else
        <label class="form-check form-switch form-switch-sm justify-content-center">
            <input type="checkbox" name="Is isActive" class="form-check-input isActiveBrandingSlider" data-id="{{$row->id}}"
                   checked>
            <span class=""></span>
        </label>
    @endif
</div>
