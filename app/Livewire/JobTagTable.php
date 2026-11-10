<?php

namespace App\Livewire;

use App\Models\Tag;
use Rappasoft\LaravelLivewireTables\Views\Column;

class JobTagTable extends LivewireTableComponent
{
    protected $model = Tag::class;

    public $showButtonOnHeader = true;
    public $showFilterOnHeader = false;

    public $buttonComponent = 'job_tags.table_components.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('id')) {
                return [
                    'class' => 'text-center',
                ];
            }
            if ($column->isField('description')) {
                return [
                    'width' => '65%',
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
            Column::make(__('messages.job_tag.job_tag'), 'name')
                ->sortable()
                ->searchable()
                ->view('job_tags.table_components.name'),
            Column::make(__('messages.common.description'), 'description')
                ->sortable()
                ->searchable()
                ->view('job_tags.table_components.description'),
            Column::make(__('messages.common.action'), 'id')
                ->view('job_tags.table_components.action_button'),
        ];
    }
}
