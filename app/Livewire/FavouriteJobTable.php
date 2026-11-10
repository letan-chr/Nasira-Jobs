<?php

namespace App\Livewire;

use App\Models\FavouriteJob;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class FavouriteJobTable extends LivewireTableComponent
{
    protected $model = FavouriteJob::class;
    public $showFilterOnHeader = false;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setSearchStatus(false);

        $this->setDefaultSort('created_at', 'desc');

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('id')) {
                return [
                    'class' => 'text-center p-5',
                ];
            }

            return [
                'class' => 'text-center',
            ];
        });

//        $this->setTableAttributes([
//            'default' => false,
//            'class' => 'table table-default',
//        ]);
        $this->setQueryStringStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load.listing-skeleton-filter-no-button-search')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.job.job_title'), 'job.job_title')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(Job::select('job_title')->whereColumn('favourite_jobs.job_id', 'jobs.id'), $direction);
                })
                ->view('candidate.favourite_jobs.table_components.job_title'),
            Column::make(__('messages.common.action'), 'job.company.user.first_name')->hideIf('job.company.user.first_name'),
            Column::make(__('messages.user.name'), 'job.company.user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('job.company.user.user_id', 'users.id'), $direction);
                })
                ->view('candidate.favourite_jobs.table_components.name'),
            Column::make(__('messages.job.created_at'), 'created_at')
                ->sortable()
                ->view('candidate.favourite_jobs.table_components.created_at'),
            Column::make(__('messages.job.job_expiry_date'), 'job.job_expiry_date')
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('job_expiry_date', $direction);
                })
                ->view('candidate.favourite_jobs.table_components.job_expiry_date'),
            Column::make(__('messages.common.action'), 'id')
                ->view('candidate.favourite_jobs.table_components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        $query = FavouriteJob::with(['job.company.user', 'job', 'user'])
            ->where('favourite_jobs.user_id', getLoggedInUserId())->select('favourite_jobs.*');

        return $query;
    }
}
