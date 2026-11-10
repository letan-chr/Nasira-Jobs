<?php

namespace App\Livewire;

use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Column;

class EmployerTransactionTable extends LivewireTableComponent
{
    protected $model = Transaction::class;
    public $showFilterOnHeader = false;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-striped',
        ]);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('id')) {
                return [
                    'class' => 'd-flex justify-content-center text-center',
                ];
            }
            if ($column->isField('created_at')) {
                return [
                    'style' => 'width:35%',
                ];
            }

            return [];
        });

        $this->setQueryStringStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton-no-button')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.plan.amount'), 'amount')
            ->sortable()
            ->searchable()
            ->view('employer.transactions.table_components.amount'),
            Column::make(__('messages.transaction.transaction_date'), 'created_at')
                ->sortable()
                ->searchable()
                ->view('employer.transactions.table_components.transaction_date'),

            Column::make(__('messages.transaction.invoice'), 'id')
                ->sortable()
                ->view('employer.transactions.table_components.invoice'),

        ];
    }

    public function builder(): Builder
    {
        if (Auth::user()->hasRole('Admin')) {
            $query = Transaction::query();
            if ($query->where('owner_type', Subscription::class)->exists()) {
                $query->with(['type.planCurrency.salaryCurrency', 'user'])->select('transactions.*');
            } else {
                $query->with(['type', 'user'])->select('transactions.*');
            }
        }

        if (Auth::user()->hasRole('Employer')) {
            $query = Transaction::where('user_id', getLoggedInUserId())->select('transactions.*');

            foreach ($query as $row) {
                if ($row->owner_type == Subscription::class) {
                    $row->load('type.planCurrency.salaryCurrency');
                }
            }
        }

        return $query;
    }
}
