<?php

namespace App\Livewire;

use App\Models\FAQ;
use Rappasoft\LaravelLivewireTables\Views\Column;

class FAQTable extends LivewireTableComponent
{
    protected $model = FAQ::class;

    public $showButtonOnHeader = true;
    public $showFilterOnHeader = false;

    public $buttonComponent = 'faqs.table-components.add_button';

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

        $this->setQueryStringStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.faq.title'), 'title')
                ->sortable()
                ->searchable()
                ->view('faqs.table-components.title'),
            Column::make(__('messages.common.created_date'), 'created_at')
                ->sortable()
                ->searchable()
                ->view('faqs.table-components.created_at'),
            Column::make(__('messages.common.action'), 'id')
                ->view('faqs.table-components.action_button'),
        ];
    }
}
