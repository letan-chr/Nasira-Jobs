<?php

namespace App\Livewire;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SubscriptionTable extends LivewireTableComponent
{
    protected $model = Plan::class;

    public $showButtonOnHeader = true;
    public $showFilterOnHeader = false;

    public $buttonComponent = 'plans.table-components.add_button';

    protected $listeners = ['refresh' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-striped',
        ]);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('is_trial_plan')) {
                return [
                    'class' => 'd-flex justify-content-center',
                ];
            }
            if ($column->isField('name')) {
                return [
                    'style' => 'width:15%',
                ];
            }
            if ($column->isField('amount')) {
                return [
                    'style' => 'display: flex; justify-content: flex-end',
                ];
            }

            return[
                'class' => 'text-center',
            ];
        });
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '5') {
                return [
                    'class' => 'text-center',
                    'width' => '15%',

                ];
            }
            if ($columnIndex == '2') {
                return [
                    'style' => 'text-align: end',
                ];
            }

            return [];
        });

        $this->setQueryStringStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.skill.name'), 'name')
                ->sortable()
                ->searchable(),

            Column::make(__('messages.plan.allowed_jobs'), 'allowed_jobs')
                ->sortable()
                ->searchable()
                ->view('plans.table-components.allowed_jobs'),

            Column::make(__('messages.plan.amount'), 'amount')
                ->sortable()
                ->searchable()
                ->view('plans.table-components.amount'),

            Column::make(__('messages.plan.active_subscription'), 'id')
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('active_subscription', $direction);
                })
                ->view('plans.table-components.active_subscription'),

            Column::make(__('messages.plan.is_trial_plan'), 'is_trial_plan')
                ->sortable()
                ->view('plans.table-components.trial_plan'),

            Column::make(__('messages.common.action'), 'id')
                ->view('plans.table-components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        return Plan::with('salaryCurrency')->withCount('activeSubscriptions as active_subscription');
    }
}
