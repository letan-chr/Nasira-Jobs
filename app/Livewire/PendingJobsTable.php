<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PendingJobsTable extends LivewireTableComponent
{
    protected $model = Job::class;


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
            return [];
        });

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
                ->view('jobs.table-components.job_title'),
            Column::make(__('messages.common.created_on'), 'created_at')
                ->sortable()
                ->searchable()
                ->view('jobs.table-components.created_on'),
            Column::make(__('messages.job.job_expiry_date'), 'job_expiry_date')
                ->sortable()
                ->view('jobs.table-components.expired_at'),
            Column::make(__('messages.pending_jobs.employer_name'), 'company.user.first_name')
                ->sortable()
                ->searchable()
                ->view('pending_jobs.table-components.employer_name'),
            Column::make(__('messages.common.action'), 'id')
                ->view('pending_jobs.table-components.action_buttons'),
        ];
    }

    public function builder(): Builder
    {
        return Job::where('status', job::SELECT_PANDING)->whereNot('is_suspended','1')->with('company.user')->select('jobs.*');
    }
}
