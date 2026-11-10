<div class="d-flex justify-content-center">
    <label class="form-check form-switch form-switch-sm">
        <input type="checkbox" name="is_featured" class="form-check-input isFeaturedJobCategory" data-id="{{$row->id}}"
                {{($row->is_featured == true) ? 'checked' : ''}}>
    </label>
</div>

