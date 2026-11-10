<div class="badge bg-light-success">
    {{ currencyFormat($row->amount, $row->salaryCurrency?$row->salaryCurrency->currency_code : "INR") }}
</div>
