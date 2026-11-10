<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class StateTable extends LivewireTableComponent
{
    /**
     * @var string
     */
    protected $model = State::class;
    public string $tableName = 'states';

    /**
     * @var bool
     */
    public $showButtonOnHeader = true;
    public $showFilterOnHeader = true;
    public $country = State::COUNTIES;


    /**
     * @var string
     */
    public $buttonComponent = 'states.table-components.add_button';
    protected $listeners = ['resetPage', 'refreshDatatable' => '$refresh', 'changeCountryFilter'];

    public array $filterComponents = ['states.table-components.filter',State::COUNTIES];

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('id', 'desc');

        $this->setThAttributes(function (Column $column) {
            return [
                'class' => 'text-center',
            ];
        });

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '2') {
                return [
                    'class' => 'text-center',
                    'width' => '15%',

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

    public function columns(): array
    {
        return [
            Column::make(__('messages.state.state_name'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.state.country_name'), 'country.name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(Country::select('name')->whereColumn('country_id', 'countries.id'), $direction);
                })
                ->searchable(),
            Column::make(__('messages.common.action'), 'id')
                ->view('states.table-components.action_button'),
        ];
    }

    public function builder(): Builder
    {
         $query = State::with('country');

         $query->when(!empty($this->country), function($q) {
                  $q->where('country_id', $this->country);
         });
        return $query->select('states.*');
    }

//     public function filters(): array
//     {
//         return [
//             SelectFilter::make(__('messages.filter_name.country'))
//                 ->options(
//                     Country::query()
//                         ->orderBy('name')
//                         ->get()
//                         ->keyBy('id')
//                         ->map(
//                             function ($country) {
//                                 return $country->name;
//                             }
//                         )
//                         ->toArray()
//                 )
//                 ->filter(function (Builder $builder, $value) {
//                     return $builder->where('country_id', $value);
//                 }),
//         ];
//     }
    public function changeCountryFilter($country)
    {
         $this->country = $country;
         $this->setBuilder($this->builder());
         $this->resetpagination();
    }

    public function resetPagination() {
        $this->resetPage('statesPage');
    }
}
