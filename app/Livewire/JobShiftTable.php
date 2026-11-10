<?php

namespace App\Livewire;

use App\Models\JobShift;
use Rappasoft\LaravelLivewireTables\Views\Column;

class JobShiftTable extends LivewireTableComponent
{
    protected $model = JobShift::class;

    public $showButtonOnHeader = true;
    public $showFilterOnHeader = false;

    public $buttonComponent = 'job_shifts.table_components.add_button';

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

            Column::make(__('messages.job_shift.shift'), 'shift')
                ->sortable()
                ->searchable()
                ->view('job_shifts.table_components.name'),
            Column::make(__('messages.common.created_date'), 'created_at')
                ->sortable()
                ->view('job_shifts.table_components.created_at'),
            Column::make(__('messages.common.action'), 'id')
                ->view('job_shifts.table_components.action_button'),
        ];
    }
}
