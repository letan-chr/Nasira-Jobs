<div class="d-flex">
    @if(\Carbon\Carbon::now() > $row->job_expiry_date)
        <span class="badge bg-light-danger">
            {{ \Carbon\Carbon::parse($row->job_expiry_date)->translatedFormat('jS M, Y') }}
        </span>
    @else
        <span class="badge bg-light-info">
            {{ \Carbon\Carbon::parse($row->job_expiry_date)->translatedFormat('jS M, Y') }}
        </span>
    @endif
</div>
