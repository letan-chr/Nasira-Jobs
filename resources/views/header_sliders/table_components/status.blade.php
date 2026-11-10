@if($row->is_active == 0)
    <label class="form-check form-switch form-switch-sm {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}">
        <input type="checkbox" name="Is Active" class="form-check-input isHeaderActive" data-id="{{$row->id}}">
        <span class=""></span>
    </label>
@else
    <label class="form-check form-switch form-switch-sm {{ checkLanguageSession() == 'ar' ? 'float-end' : 'float-start' }}">
        <input type="checkbox" name="Is Active" class="form-check-input isHeaderActive" data-id="{{$row->id}}"
               checked>
        <span class=""></span>
    </label>
@endif

