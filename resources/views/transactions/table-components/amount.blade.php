{{ currencyFormat($row->amount, $row->salaryCurrency?$row->salaryCurrency->currency_code : "INR") }}

