<div class="d-flex justify-content-center">
    @if( !$row->is_trial_plan == 1 )
        <i class="fas fa-times-circle text-danger h3 mt-3"></i>
    @else
        <i class="fas fa-check-circle text-success h3 mt-3"></i>
    @endif
</div>
