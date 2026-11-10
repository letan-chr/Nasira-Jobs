<?php

namespace App\Livewire;

use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class JobApplicationTable extends LivewireTableComponent
{
    protected $model = JobApplication::class;

    public $showButtonOnHeader = true;

    public $buttonComponent = 'employer.job_applications.table_components.edit_button';

    public $jobId;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setTableAttributes(
            [
                'default' => false,
                'class' => 'table table-striped',
            ]);

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if (in_array($column->getField(), ['0', '1', '2', '3', '4', '5'])) {
                return [
                    'class' => 'text-center',
                ];
            }

            return [];
        });

        $this->setQueryStringStatus(false);

        $this->setFilterPillsStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.job_application.candidate_name'), 'candidate.user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('candidate.user_id', 'users.id'), $direction);
                })
                ->searchable()
                ->view('employer.job_applications.table_components.candidate_name'),

            Column::make(__('messages.candidate.expected_salary'), 'expected_salary')
                ->sortable()
                ->searchable()
                ->view('employer.job_applications.table_components.expected_salary'),

            Column::make(__('messages.job_application.application_date'), 'created_at')
                ->sortable()
                ->searchable()
                ->view('employer.job_applications.table_components.application_date'),

            Column::make(__('messages.apply_job.resume'), 'candidate.user.last_name')
                ->view('employer.job_applications.table_components.resume'),

            Column::make(__('messages.job_stage.job_stage'), 'job_stage_id')
                ->view('employer.job_applications.table_components.job_stage'),

            Column::make(__('messages.common.status'), 'status')
                ->searchable()
                ->view('employer.job_applications.table_components.status'),

            Column::make(__('messages.common.action'), 'id')
                ->view('employer.job_applications.table_components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        $query = JobApplication::with(['job.currency', 'candidate.user', 'jobStage', 'job'])
            ->where('job_id', $this->jobId)
            ->where('status', '!=', JobApplication::STATUS_DRAFT)
            ->select('job_applications.*');

        return $query;
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('messages.common.status'))
                ->options([
                    '' => __('messages.filter_name.select_status'),
                    //                    0 => __('messages.filter_name.drafted'),
                    1 => __('messages.common.applied'),
                    2 => __('messages.common.declined'),
                    3 => __('messages.common.hired'),
                    4 => __('messages.common.ongoing'),
                ])
                ->filter(
                    function (Builder $builder, string $value) {
                        $builder->where('status', '=', $value);
                    }
                ),
        ];
    }
}
