<?php

namespace App\Livewire;

use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class JobExpiredTable extends LivewireTableComponent
{
    protected $model = Job::class;
    public $showFilterOnHeader = false;

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
        return view('livewire_lazy_load/listing-skeleton-no-button')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.job.job_title'), 'job_title')
                ->sortable()
                ->searchable()
                ->view('job_expired.table_components.name'),
            Column::make(__('messages.common.created_on'), 'created_at')
                ->sortable()
                ->view('job_expired.table_components.created_at'),
            Column::make(__('messages.job.job_expiry_date'), 'job_expiry_date')
                ->sortable()
                ->view('job_expired.table_components.expired_date'),
            Column::make(__('messages.common.action'), 'id')
                ->view('job_expired.table_components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        $query = Job::where('job_expiry_date', '<', Carbon::now()->toDateString());

        return $query;
    }
}
