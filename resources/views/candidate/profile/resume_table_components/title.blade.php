@if (!empty($row->custom_properties) && $row->custom_properties['is_default'])
<div class="text-primary py-2">{{$row->custom_properties['title']. '(Default)'}}</div>
@else
    <div class="py-2 text-primary" >{{ !empty($row->custom_properties) ? $row->custom_properties['title'] : __('messages.n/a') }}</div>
@endif
