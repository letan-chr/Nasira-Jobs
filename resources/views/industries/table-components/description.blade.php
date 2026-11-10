{{-- {{ strip_tags($row->description) }} --}}
{!! nl2br( \Illuminate\Support\Str::limit($row->description,200) ) !!}
