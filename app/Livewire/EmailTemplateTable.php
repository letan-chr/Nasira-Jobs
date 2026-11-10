<?php

namespace App\Livewire;

use App\Models\EmailTemplate;
use Rappasoft\LaravelLivewireTables\Views\Column;

class EmailTemplateTable extends LivewireTableComponent
{
    /**
     * @var string
     */
    protected $model = EmailTemplate::class;
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
            if ($column->isField('template_name')) {
                return [
                    'style' => 'width:85%',
                ];
            }
            if ($column->isField('id')) {
                return [
                    'class' => 'text-center',
                ];
            }

            return[];
        });
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '1') {
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
        return view('livewire_lazy_load/listing-skeleton-no-button')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.email_template.template_name'), 'template_name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.common.action'), 'id')
                ->view('email_templates.table-components.action_button'),
        ];
    }
}
