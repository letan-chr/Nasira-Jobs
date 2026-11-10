<?php

namespace App\Livewire;

use App\Models\FavouriteCompany;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class FavouriteCompanyTable extends LivewireTableComponent
{
    protected $model = FavouriteCompany::class;
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

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '4') {
                return [
                    'class' => 'text-center',
                    'width' => '14%',
                ];
            }

            return [];
        });

//        $this->setTableAttributes([
//            'default' => false,
//            'class' => 'table table-default',
//        ]);

        $this->setQueryStringStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton-no-button')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.company.name'), 'company.user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('company.user_id', 'users.id'), $direction);
                })
                ->searchable()
                ->view('candidate.favourite_companies.table_components.name'),

            Column::make(__('messages.company.offices'), 'company.no_of_offices')
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('no_of_offices', $direction);
                })
                ->searchable()
                ->view('candidate.favourite_companies.table_components.offices'),

            Column::make(__('messages.user.phone'), 'company.user.phone')
                ->sortable(function (Builder $builder, $direction) {
                    return $builder->orderBy('phone', $direction);
                })
                ->searchable()
                ->view('candidate.favourite_companies.table_components.phone'),

            Column::make(__('messages.company.industry'), 'company.industry.name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(Industry::select('name')->whereColumn('company.industry_id', 'industries.id'), $direction);
                })
                ->searchable()
                ->view('candidate.favourite_companies.table_components.industry'),

            Column::make(__('messages.common.action'), 'id')
                ->view('candidate.favourite_companies.table_components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        $query = FavouriteCompany::with(['company.user', 'company.industry'])->where('favourite_companies.user_id',
            getLoggedInUserId())->select('favourite_companies.*');

        return $query;
    }
}
