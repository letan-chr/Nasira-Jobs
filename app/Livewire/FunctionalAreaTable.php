<?php

namespace App\Livewire;

use App\Models\FunctionalArea;
use Rappasoft\LaravelLivewireTables\Views\Column;

class FunctionalAreaTable extends LivewireTableComponent
{
    /**
     * @var string
     */
    protected $model = FunctionalArea::class;

    /**
     * @var bool
     */
    public $showButtonOnHeader = true;

    /**
     * @var string
     */
    public $buttonComponent = 'functional_areas.table-components.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-striped',
        ]);

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

        $this->setQueryStringStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.functional_area.name'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.common.created_date'), 'created_at')
                ->sortable()
                ->searchable()
                ->view('functional_areas.table-components.created_at'),
            Column::make(__('messages.common.action'), 'id')
                ->view('functional_areas.table-components.action_button'),
        ];
    }
}
