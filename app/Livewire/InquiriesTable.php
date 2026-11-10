<?php

namespace App\Livewire;

use App\Models\Inquiry;
use Rappasoft\LaravelLivewireTables\Views\Column;

class InquiriesTable extends LivewireTableComponent
{
    protected $model = Inquiry::class;
    public $showFilterOnHeader = false;

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
            if ($column->isField('id')) {
                return [
                    'class' => 'd-flex justify-content-center',
                ];
            }

            return [
                'style' => 'width:30%',
            ];
        });

        $this->setQueryStringStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton-no-button')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.inquiry.name'), 'name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.inquiry.email'), 'email')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.inquiry.inquiry_date'), 'created_at')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.common.action'), 'id')
                ->view('inquires.table-components.action_buttons'),
        ];
    }
}
