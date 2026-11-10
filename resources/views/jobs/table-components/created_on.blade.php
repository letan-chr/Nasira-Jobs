<div class="d-flex">
    <span class="badge bg-secondary">
        {{ \Carbon\Carbon::parse($row->created_at)->translatedFormat('jS M, Y') }}
    </span>
</div>
