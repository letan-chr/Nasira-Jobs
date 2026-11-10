<?php

namespace App\Livewire;

use App\Models\ReportedToCompany;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ReportedEmployerTable extends LivewireTableComponent
{
    protected $model = ReportedToCompany::class;
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
        return view('livewire_lazy_load.listing-skeleton-no-button')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.company.employer_name'), 'company.user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('company.user_id', 'users.id'), $direction);
                })
                ->searchable()
                ->view('employer.companies.reported_company_table_components.employer_name'),

            Column::make(__('messages.company.reported_by'), 'user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('reported_to_companies.user_id', 'users.id'), $direction);
                })
                ->searchable()
                ->view('employer.companies.reported_company_table_components.reported_by'),

            Column::make(__('messages.company.reported_on'), 'created_at')
                ->sortable()
                ->view('employer.companies.reported_company_table_components.reported_on'),

            Column::make(__('messages.common.action'), 'id')
                ->view('employer.companies.reported_company_table_components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        $query = ReportedToCompany::with('user', 'company.user')->select('reported_to_companies.*');

        return $query;
    }
}
