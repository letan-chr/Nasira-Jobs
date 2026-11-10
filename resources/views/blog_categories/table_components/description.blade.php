@if(is_null($row->description))
    {{__('messages.n/a')}}
@else
    {!! nl2br( \Illuminate\Support\Str::limit($row->description,200) ) !!}
@endif

