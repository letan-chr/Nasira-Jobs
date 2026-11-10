<?php

namespace App\Livewire;

use App\Models\CareerLevel;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CareerLevelTable extends LivewireTableComponent
{
    protected $model = CareerLevel::class;

    public $showButtonOnHeader = true;

    public $buttonComponent = 'career_levels.table-components.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-striped',
        ]);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('level_name')) {
                return[
                    'style' => 'width:70%',
                    'class' => 'text-start',
                ];
            }

            return[
                'class' => 'min-w-100px text-center',
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
            Column::make(__('messages.career_level.level_name'), 'level_name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.common.created_date'), 'created_at')
                ->sortable()
                ->searchable()
                ->view('career_levels.table-components.created_at'),
            Column::make(__('messages.common.action'), 'id')
                ->view('career_levels.table-components.action_button'),
        ];
    }
}
