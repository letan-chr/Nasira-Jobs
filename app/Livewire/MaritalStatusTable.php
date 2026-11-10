<?php

namespace App\Livewire;

use App\Models\MaritalStatus;
use Rappasoft\LaravelLivewireTables\Views\Column;

class MaritalStatusTable extends LivewireTableComponent
{
    /**
     * @var string
     */
    protected $model = MaritalStatus::class;

    /**
     * @var bool
     */
    public $showButtonOnHeader = true;
    public $showFilterOnHeader = false;

    /**
     * @var string
     */
    public $buttonComponent = 'marital_status.table-components.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setThAttributes(function (Column $column) {
            return [
                'class' => 'text-center',
            ];
        });

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '2') {
                return [
                    'class' => 'text-center',
                    'width' => '15%',

                ];
            }

            return [];
        });

        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-striped',
        ]);

        $this->setQueryStringStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.marital_status.marital_status'), 'marital_status')
                ->sortable()
                ->searchable()
                ->view('marital_status.table-components.marital_status'),
            Column::make(__('messages.common.created_date'), 'created_at')
                ->sortable()
                ->view('marital_status.table-components.created_at'),
            Column::make(__('messages.common.action'), 'id')
                ->view('marital_status.table-components.action_button'),
        ];
    }
}
