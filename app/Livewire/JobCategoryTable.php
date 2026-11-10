<?php

namespace App\Livewire;

use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class JobCategoryTable extends LivewireTableComponent
{
    protected $model = JobCategory::class;
    public string $tableName = 'job-categories';
    protected $listeners = ['resetPage', 'refreshDatatable' => '$refresh', 'changeFeaturedFilter'];
    public $featured = JobCategory::ALL;

    public $showButtonOnHeader = true;
    public $showFilterOnHeader = true;

    public array $filterComponents = ['job_categories.table_components.filter', JobCategory::FEATURED];
    public $buttonComponent = 'job_categories.table_components.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('is_featured')) {
                return [
                    'class' => 'd-flex justify-content-center',
                ];
            }

            if ($column->isField('id')) {
                return [
                    'class' => 'text-center p-5',
                ];
            }

            return [];
        });

        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-striped',
        ]);

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
            Column::make(__('messages.job_category.job_category'), 'name')
                ->sortable()
                ->searchable()
                ->view('job_categories.table_components.name'),
            Column::make(__('messages.job_category.is_featured'), 'is_featured')
                ->sortable()
                ->view('job_categories.table_components.is_featured'),
            Column::make(__('messages.common.created_on'), 'created_at')
                ->sortable()
                ->view('job_categories.table_components.created_at'),
            Column::make(__('messages.common.action'), 'id')
                ->view('job_categories.table_components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        $query = JobCategory::query()

        ->when($this->getAppliedFilterWithValue('job_categories.is_featured'), function ($query, $type) {
            return $query->where('job_categories.is_featured', $type);
        });
        $query->when($this->featured != JobCategory::ALL, function($q) {
         $q->where('job_categories.is_featured', $this->featured);
});

        return $query ->select('job_categories.*');
    }

    public function filters(): array
    {
        $jobCategoryMethod = JobCategory::FEATURED;

        return [
            SelectFilter::make(__('messages.common.status'))
                ->options($jobCategoryMethod)
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('job_categories.is_featured', '=', $value);
                }),
        ];
    }
    public function changeFeaturedFilter($featured)
    {
         $this->featured = $featured;
         $this->setBuilder($this->builder());
         $this->resetpagination();
    }
    public function resetPagination() {
        $this->resetPage('job-categoriesPage');
    }
}
