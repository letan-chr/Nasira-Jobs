@if($row->invoice_id != null)
    <div class=" d-flex justify-content-center">
        <a class="invoice btn px-1 text-info fs-3 admin-invoice-btn
            {{ $row->amount != 0 ? 'admin-view-invoice' : __('messages.n/a')}}"
           data-bs-toggle="tooltip"
           id="invoiceShow"
           title="{{__('messages.common.show')}}"
           data-invoice-id="{{ $row->invoice_id }}"
           href="javascript:void(0)">
            <i class="fas fa-eye"></i>
        </a>
    </div>
@else
        {{ __('messages.n/a') }}
@endif
