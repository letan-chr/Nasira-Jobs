<?php

namespace App\Livewire;

use App\Models\HeaderSlider;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class HeaderSliderTable extends LivewireTableComponent
{
    protected $model = HeaderSlider::class;
    public string $tableName = 'header-sliders';
    public $status =HeaderSlider::ALL;
    protected $listeners = ['resetPage', 'refreshDatatable' => '$refresh','changeStatusFilter'];
    public $showFilterOnHeader = true;

    public array $filterComponents = ['header_sliders.table_components.filter',HeaderSlider::STATUS];

    public $showButtonOnHeader = true;

    public $buttonComponent = 'header_sliders.table_components.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setSearchStatus(false);

        $this->setDefaultSort('created_at', 'desc');

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('created_at')) {
                return[
                    'style' => 'width:40%',
                ];
            }
            if ($column->isField('is_active')) {
                return[
                    'style' => 'width:20%',
                    'class' => 'text-center',
                ];
            }
            if ($column->isField('id')) {
                return[
                    'style' => 'width:12%',
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

        $this->setFilterPillsStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton-filter')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.image_slider.image'), 'created_at')
                ->view('header_sliders.table_components.image'),

            Column::make(__('messages.image_slider.is_active'), 'is_active')
                ->sortable()
                ->view('header_sliders.table_components.status'),

            Column::make(__('messages.common.action'), 'id')
                ->view('header_sliders.table_components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        $query=  HeaderSlider::query();
        $query->when($this->status != HeaderSlider::ALL, function($q) {
         if($this->status) {
                  $q->where('is_active', 1);
         }else {
                  $q->where('is_active', 0);
         }
});
        return $query->select('header_sliders.*');
    }

//     public function filters(): array
//     {
//         return [

//             SelectFilter::make(__('messages.common.status'))
//                 ->options([
//                     '' => __('messages.filter_name.select_status'),
//                     1 => __('messages.common.active'),
//                     2 => __('messages.common.de_active'),
//                 ])
//                 ->filter(
//                     function (Builder $builder, string $value) {
//                         if ($value == 1) {
//                             $builder->where('is_active', '=', 1);
//                         } else {
//                             $builder->where('is_active', '=', 0);
//                         }
//                     }
//                 ),
//         ];
//     }
    public function changeStatusFilter($status)
    {
            $this->status = $status;
            $this->setBuilder($this->builder());
            $this->resetPagination();
    }

    public function resetPagination() {
        $this->resetPage('header-slidersPage');
    }
}
