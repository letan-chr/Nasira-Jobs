<div class="d-flex justify-content-start">
    <div class="form-check form-switch">
        <input class="form-check-input changeAdminStatus" wire:click="changeStatus({{$row->id}})" type="checkbox" role="switch"
              {{$row->is_active == 0 ? '' : 'checked'}} >
        <span class="custom-switch-indicator"></span>
    </div>
</div>
