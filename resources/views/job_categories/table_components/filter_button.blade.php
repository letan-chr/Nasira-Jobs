@if($row->is_featured_label === 'Yes')
    <span class="badge badge-light-success fs-7">{{$row->is_featured_label}}</span>
@elseif($row->is_featured_label === 'No')
    <span class="badge badge-light-danger fs-7">{{$row->is_featured_label}}</span>
@endif
