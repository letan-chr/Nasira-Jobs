<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class EmployerJobTable extends LivewireTableComponent
{
    protected $model = Job::class;
    public string $tableName = 'jobs';
    public $showButtonOnHeader = true;
    public $showFilterOnHeader = true;
    public $featured = Job::SELECT_FEATURD;
    public $employeeJobStatus = Job::SELECT_STATUS;
    protected $listeners = ['resetPage', 'refreshDatatable' => '$refresh', 'changeFeaturedFilter','employeeJobStatus'];


    public $buttonComponent = 'employer.jobs.job_table_components.add_button';
    public array $filterComponents = ['employer.jobs.job_table_components.filter', Job::IS_FEATURED,Job::STATUS];

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setTableAttributes(
            [
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

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '5') {
                return [
                    'class' => 'text-center',
                    'width' => '14%',
                ];
            }
            if ($columnIndex == 'job_title') {
                return [
                    'width' => '20%',
                ];
            }

            if (in_array($column->getField(), ['hide_salary', 'status'])) {
                return [
                    'class' => 'text-center',
                ];
            }

            return [];
        });

        $this->setQueryStringStatus(false);

        $this->setFilterPillsStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton-filter')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.job.job_title'), 'job_title')
                ->sortable()
                ->searchable()
                ->view('employer.jobs.job_table_components.job_title'),

            Column::make(__('messages.employer_menu.expires_on'), 'job_expiry_date')
                ->sortable()
                ->searchable()
                ->view('employer.jobs.job_table_components.expires_on'),

            Column::make(__('messages.job_applications'), 'id')
                ->sortable(
                    function (Builder $builder, $direction) {
                        return $builder->orderBy('total_applied_jobs', $direction);
                    }
                )
                ->view('employer.jobs.job_table_components.job_applications'),

            Column::make(__('messages.front_settings.featured_job'), 'hide_salary')
                ->view('employer.jobs.job_table_components.featured_job'),

            Column::make(__('messages.common.status'), 'status')
                ->sortable()
                ->view('employer.jobs.job_table_components.status'),

            Column::make(__('messages.common.action'), 'id')
                ->view('employer.jobs.job_table_components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        /** @var Job $query */
        $query = Job::with(
            [
                'appliedJobs' => function ($query) {
                    $query->where('status', '!=', JobApplication::STATUS_DRAFT);
                },
            ],
            'activeFeatured',
            'featured',
            'company',
            'jobCategory',
            'jobType',
            'jobShift'
        )
            ->where('company_id', Auth::user()->owner_id);
            $query->when($this->featured != Job::SELECT_FEATURD, function($q) {
                  $q->Has('activeFeatured', $this->featured);
                 });
            $query->when($this->employeeJobStatus != Job::SELECT_STATUS, function($q) {
                  $q->where('status', $this->employeeJobStatus);
                 });
                 $query->select('jobs.*');

        return $query->withCount('appliedJobs as total_applied_jobs');
    }

    public function filters(): array
    {
        return [
            SelectFilter::make(__('messages.filter_name.featured_job'))
                ->options([
                    '' => __('messages.filter_name.select_featured_company'),
                    'yes' => __('messages.common.yes'),
                    'no' => __('messages.common.no'),
                ])
                ->filter(
                    function (Builder $builder, string $value) {
                        if ($value == 'yes') {
                            $builder->has('activeFeatured');
                        } else {
                            $builder->doesnthave('activeFeatured');
                        }
                    }
                ),
            SelectFilter::make(__('messages.common.status'))
                ->options([
                    '' => __('messages.filter_name.select_status'),
                    0 => __('messages.filter_name.drafted'),
                    1 => __('messages.filter_name.live'),
                    2 => __('messages.filter_name.closed'),
                    3 => __('messages.filter_name.paused'),
                ])
                ->filter(
                    function (Builder $builder, string $value) {
                        $builder->where('status', '=', $value);
                    }
                ),
        ];
    }
    public function changeFeaturedFilter($featured)
    {
         $this->featured = $featured;
         $this->setBuilder($this->builder());
         $this->resetPagination();
    }
    public function employeeJobStatus($employeeJobStatus)
    {
         $this->employeeJobStatus = $employeeJobStatus;
         $this->setBuilder($this->builder());
         $this->resetPagination();
    }

    public function resetPagination(){
        $this->resetPage('jobsPage');
    }
}
