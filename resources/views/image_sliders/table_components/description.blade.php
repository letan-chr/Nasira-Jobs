@if(strip_tags($row->description) == "")
    {{__('messages.n/a')}}
@else
    {!! nl2br( \Illuminate\Support\Str::limit($row->description, 190) ) !!}
@endif
