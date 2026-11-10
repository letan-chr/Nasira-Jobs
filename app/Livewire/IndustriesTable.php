<?php

namespace App\Livewire;

use App\Models\Industry;
use Rappasoft\LaravelLivewireTables\Views\Column;

class IndustriesTable extends LivewireTableComponent
{
    /**
     * @var string
     */
    protected $model = Industry::class;

    /**
     * @var bool
     */
    public $showButtonOnHeader = true;
    public $showFilterOnHeader = false;

    /**
     * @var string
     */
    public $buttonComponent = 'industries.table-components.add_button';

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
                    'class' => 'text-center',
                ];
            }

            return [];
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

        $this->setQueryStringStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.industry.name'), 'name')
                ->sortable()
                ->searchable()
                ->view('industries.table-components.name'),
            Column::make(__('messages.industry.description'), 'description')
                ->searchable()
                ->view('industries.table-components.description'),
            Column::make(__('messages.common.action'), 'id')
                ->view('industries.table-components.action_button'),
        ];
    }
}
