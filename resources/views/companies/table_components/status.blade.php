<div class="d-flex justify-content-center">
    <div class="form-check form-switch">
        <input class="form-check-input isEmployerActive" name="Is isActive" type="checkbox" role="switch"
              {{$row->user->is_active == 0 ? '' : 'checked'}}  data-id="{{$row->id}}">
        <span class="custom-switch-indicator"></span>
    </div>
</div>
