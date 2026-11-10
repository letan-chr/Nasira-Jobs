<?php

namespace App\Livewire;

use App\Models\OwnerShipType;
use Rappasoft\LaravelLivewireTables\Views\Column;

class OwnershipTypeTable extends LivewireTableComponent
{
    /**
     * @var string
     */
    protected $model = OwnerShipType::class;

    /**
     * @var bool
     */
    public $showButtonOnHeader = true;

    /**
     * @var string
     */
    public $buttonComponent = 'ownership_types.table-components.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-striped',
        ]);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('name') || $column->isField('created_at')) {
                return [
                    'style' => 'width: 15%; font-size: 13px',
                ];
            }
            if ($column->isField('id')) {
                return [
                    'class' => 'text-center',
                ];
            }

            return [
                'style' => 'font-size: 13px',
            ];
        });

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '3') {
                return [
                    'class' => 'text-center',
                    'width' => '15%',
                ];
            }

            return [];
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
            Column::make(__('messages.ownership_types'), 'name')
                ->sortable()
                ->searchable()
                ->view('ownership_types.table-components.name'),
            Column::make(__('messages.common.description'), 'description')
                ->view('ownership_types.table-components.description'),
            Column::make(__('messages.common.created_date'), 'created_at')
                ->sortable()
                ->searchable()
                ->view('ownership_types.table-components.created_at'),
            Column::make(__('messages.common.action'), 'id')
                ->view('ownership_types.table-components.action_button'),
        ];
    }
}
