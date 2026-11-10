@php
    $approved = __('messages.transaction.approved');
    $denied =  __('messages.transaction.denied');
    $selectManualPayment = __('messages.transaction.select_manual_payment');
@endphp

    @if ($row->is_approved == \App\Models\Transaction::PENDING && $row->status == \App\Models\Transaction::MANUALLY)
        <div class="d-flex align-items-center">
            <select class="form-select io-select2 approve-status transaction-approve"
                    data-id="{{$row->id}}" data-control="select2">
                <option selected="selected" value="">{{$selectManualPayment}}</option>
                <option value="{{\App\Models\Transaction::APPROVED}}">{{$approved}}</option>
                <option value="{{\App\Models\Transaction::REJECTED}}">{{$denied}}</option>
            </select>
        </div>
    @elseif ($row->is_approved == \App\Models\Transaction::APPROVED )
        <span class="badge bg-light-success">{{$approved}}</span>
    @elseif ($row->is_approved == \App\Models\Transaction::REJECTED )
        <span class="badge bg-light-danger">{{$denied}}</span>
    @else
        {{ __('messages.n/a') }}
    @endif
