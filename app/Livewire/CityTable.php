<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class CityTable extends LivewireTableComponent
{
    /**
     * @var string
     */
    protected $model = City::class;
    public string $tableName = 'cities';

    /**
     * @var bool
     */
    public $showButtonOnHeader = true;
    public $state = City::STATE;

    /**
     * @var string
     */
    public $buttonComponent = 'cities.table-components.add_button';
    public $showFilterOnHeader = true;
    protected $listeners = ['resetPage', 'refreshDatatable' => '$refresh', 'changeStateFilter'];

    public array $filterComponents = ['cities.table-components.filter', City::STATE];


    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('cities.created_at', 'desc');

        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-striped',
        ]);

        $this->setThAttributes(function (Column $column) {
            return [
                'class' => 'text-center',
            ];
        });
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '2') {
                return [
                    'class' => 'text-center',
                    'width' => '14%',

                ];
            }

            return [];
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

        $this->setQueryStringStatus(false);

        $this->setFilterPillsStatus(false);
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.city.city_name'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.city.state_name'), 'state.name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(State::select('name')->whereColumn('state_id', 'states.id'), $direction);
                })
                ->searchable(),
            Column::make(__('messages.common.action'), 'id')
                ->view('cities.table-components.action_button'),
        ];
    }

    public function builder(): Builder
    {
         $query = City::with('state');

         $query->when(!empty($this->state), function($q) {
                  $q->where('state_id', $this->state);
         });

        return $query->select('cities.*');
    }

    public function changeStateFilter($state)
    {
         $this->state = $state;
         $this->setBuilder($this->builder());
         $this->resetPagination();
    }

    public function resetpagination(){
        $this->resetPage('citiesPage');
    }
}
