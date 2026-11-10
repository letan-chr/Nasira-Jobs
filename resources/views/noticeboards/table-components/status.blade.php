<div class="d-flex justify-content-center">
    <label class="form-check form-switch">
        <input name="Is Active" data-id="{{ $row->id }}" class="form-check-input isActiveNoticeboard" type="checkbox"
               value="1"
                {{ $row->is_active == 0 ? '' : 'checked' }}>
    </label>
</div>
