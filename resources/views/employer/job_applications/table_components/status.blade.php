<?php

$statusColor = [
    '0' => 'warning',
    '1' => 'primary',
    '2' => 'danger',
    '3' => 'info',
    '4' => 'success',
];

    $statusArray = App\Models\JobApplication::STATUS;
?>

<span class="badge bg-light-{{ $statusColor[$row->status] }}">
    @if($statusArray[$row->status] == 'Drafted')
        {{__('messages.common.drafted')}}
    @elseif($statusArray[$row->status] == 'Applied')
        {{__('messages.common.applied')}}
    @elseif($statusArray[$row->status] == 'Declined')
        {{__('messages.common.declined')}}
    @elseif($statusArray[$row->status] == 'Hired')
        {{__('messages.common.hired')}}
    @else
        {{__('messages.common.ongoing')}}
    @endif
</span>
