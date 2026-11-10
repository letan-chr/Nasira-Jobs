<?php

namespace App\Livewire;

use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class SelectedCandidateTable extends LivewireTableComponent
{
    protected $model = JobApplication::class;
    public string $tableName = 'selected-candidates';
    public $status = JobApplication::SELECT_STATUS;
    public $showFilterOnHeader = true;
    protected $listeners = ['resetPage', 'refreshDatatable' => '$refresh', 'changeStatusFilter'];

    public array $filterComponents = ['selected_candidate.table-components.filter',JobApplication::FILTER];
    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-striped',
        ]);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('status')) {
                return [
                    'class' => 'd-flex justify-content-center',
                ];
            }

            return [
                'class' => 'text-center',
            ];
        });

        $this->setQueryStringStatus(false);

        $this->setFilterPillsStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton-only-filter')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.company.candidate_name'), 'candidate.user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('candidate.user_id', 'users.id'), $direction);
                })
                ->searchable(function (Builder $query, $direction) {
                        return $query->whereHas('candidate.user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like ?", ['%'.$direction.'%']);
                        });
                    }
                )
                ->view('selected_candidate.table-components.candidate_first_name'),
            Column::make(__('messages.company.employer_name'), 'job.company.user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('candidate.user_id', 'users.id'), $direction);
                })
                ->searchable()
                ->view('selected_candidate.table-components.employer_first_name'),
            Column::make(__('messages.common.status'), 'status')
                ->sortable()
                ->view('selected_candidate.table-components.status'),
            Column::make(__('messages.job.job_details'), 'id')
                ->view('selected_candidate.table-components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        $query = JobApplication::with('job.company.user', 'candidate')
            ->whereIn('job_applications.status', [JobApplication::SHORT_LIST, JobApplication::COMPLETE]);
            $query->when($this->status != JobApplication::SELECT_STATUS, function($q) {
                  $q->where('job_applications.status', $this->status);
         });
            return $query->select('job_applications.*');
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('messages.common.status'))
                ->options([
                    '' => (__('messages.filter_name.select_status')),
                    1 => 'Hired',
                    2 => 'Ongoing',
                ])
                ->filter(
                    function (Builder $builder, string $value) {
                        if ($value == 1) {
                            $builder->where('job_applications.status', '=', 3);
                        } else {
                            $builder->where('job_applications.status', '=', 4);
                        }
                    }
                ),
        ];
    }
    public function changeStatusFilter($status)
    {
         $this->status = $status;
         $this->setBuilder($this->builder());
         $this->resetPagination();
    }
    public function resetPagination()
    {
        $this->resetPage('selected-candidatesPage');
    }
}
