<?php

namespace App\Livewire;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class TestimonialTable extends LivewireTableComponent
{
    protected $model = Testimonial::class;

    public $showButtonOnHeader = true;
    public $showFilterOnHeader = false;
    public $buttonComponent = 'testimonial.table_components.add_button';

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
            if ($columnIndex == '2') {
                return [
                    'class' => 'text-center',
                    'width' => '15%',

                ];
            }
            if ($columnIndex == '1') {
                return [
                    'class' => 'text-center',
                ];
            }

            return [];
        });

        $this->setTableAttributes(
            [
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
            Column::make(__('messages.testimonial.customer_name'), 'customer_name')
                ->sortable()
                ->searchable()
                ->view('testimonial.table_components.customer_name'),

            Column::make(__('messages.common.download'), 'customer_name')
                ->view('testimonial.table_components.download'),

            Column::make(__('messages.common.action'), 'id')
                ->view('testimonial.table_components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        $query = Testimonial::query()->select('testimonials.*');

        return $query;
    }
}
