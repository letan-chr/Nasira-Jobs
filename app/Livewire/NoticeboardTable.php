<?php

namespace App\Livewire;

use App\Models\Noticeboard;
use Rappasoft\LaravelLivewireTables\Views\Column;

class NoticeboardTable extends LivewireTableComponent
{
    protected $model = Noticeboard::class;
    public $showFilterOnHeader = false;

    public $showButtonOnHeader = true;

    public $buttonComponent = 'noticeboards.table-components.add_button';

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
            if ($column->isField('is_active')) {
                return [
                    'class' => 'd-flex justify-content-center',
                ];
            }
            if ($column->isField('title')) {
                return[
                    'style' => 'width:25%',
                    'class' => 'text-start',
                ];
            }
            if ($column->isField('description')) {
                return[
                    'style' => 'width:40%',
                    'class' => 'text-start',
                ];
            }

            return[
                'class' => 'min-w-100px text-center p-5',
            ];
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
            Column::make(__('messages.noticeboard.title'), 'title')
                ->sortable()
                ->searchable()
                ->view('noticeboards.table-components.title'),
            Column::make(__('messages.noticeboard.description'), 'description')
                ->searchable()
                ->view('noticeboards.table-components.description'),
            Column::make(__('messages.common.status'), 'is_active')
                ->sortable()
                ->view('noticeboards.table-components.status'),
            Column::make(__('messages.common.action'), 'id')
                ->view('noticeboards.table-components.action_button'),
        ];
    }
}
