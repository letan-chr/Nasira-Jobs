<?php

namespace App\Livewire;

use App\Models\JobType;
use Rappasoft\LaravelLivewireTables\Views\Column;

class JobTypeTable extends LivewireTableComponent
{
    protected $model = JobType::class;

    public $showButtonOnHeader = true;
    public $showFilterOnHeader = false;

    public $buttonComponent = 'job_types.table_components.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setThAttributes(function (Column $column) {
            return [
                'class' => 'text-center',
            ];
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
            Column::make(__('messages.job.job_type'), 'name')
                ->sortable()
                ->searchable()
                ->view('job_types.table_components.name'),
            Column::make(__('messages.common.created_date'), 'created_at')
                ->sortable()
                ->view('job_types.table_components.created_at'),
            Column::make(__('messages.common.action'), 'id')
                ->view('job_types.table_components.action_button'),
        ];
    }
}
