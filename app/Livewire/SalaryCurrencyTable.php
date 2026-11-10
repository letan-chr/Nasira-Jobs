<?php

namespace App\Livewire;

use App\Models\SalaryCurrency;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SalaryCurrencyTable extends LivewireTableComponent
{
    /**
     * @var string
     */
    protected $model = SalaryCurrency::class;

    public $showButtonOnHeader = true;

    /**
     * @var string
     */
    public $buttonComponent = 'salary_currencies.table-components.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-striped',
        ]);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('currency_name')) {
                return [
                    'style' => 'width: 50%',
                ];
            }

            return [
                'style' => 'width: 10%',
                'class' => 'text-center',
            ];
        });

        $this->setQueryStringStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.salary_currency.currency_name'), 'currency_name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.salary_currency.currency_code'), 'currency_code')
                ->sortable()
                ->searchable()
                ->view('salary_currencies.table-components.currency_code'),
            Column::make(__('messages.salary_currency.currency_icon'), 'currency_icon')
                ->sortable()
                ->searchable()
                ->view('salary_currencies.table-components.currency_icon'),
            Column::make(__('messages.common.action'), 'id')
                ->view('salary_currencies.table-components.action_button'),
        ];
    }
}
