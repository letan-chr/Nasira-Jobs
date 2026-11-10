<?php

namespace App\Livewire;

use App\Models\Country;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CountryTable extends LivewireTableComponent
{
    /**
     * @var string
     */
    protected $model = Country::class;
    public $showFilterOnHeader = false;

    /**
     * @var bool
     */
    public $showButtonOnHeader = true;

    /**
     * @var string
     */
    public $buttonComponent = 'countries.table-components.add_button';

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
            if ($columnIndex == '3') {
                return [
                    'class' => 'text-center',
                    'width' => '14%',

                ];
            }

            return [];
        });

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '3') {
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
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.country.country_name'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.country.short_code'), 'short_code')
                ->sortable()
                ->searchable()
                ->view('countries.table-components.short_code'),
            Column::make(__('messages.country.phone_code'), 'phone_code')
                ->sortable()
                ->searchable()
                ->view('countries.table-components.phone_code'),
            Column::make(__('messages.common.action'), 'id')
                ->view('countries.table-components.action_button'),
        ];
    }
}
