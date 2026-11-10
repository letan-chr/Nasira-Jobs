<?php

namespace App\Livewire;

use App\Models\Post;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PostTable extends LivewireTableComponent
{
    protected $model = Post::class;

    public $showButtonOnHeader = true;
    public $showFilterOnHeader = false;

    public $buttonComponent = 'blogs.table_components.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('id')) {
                return [
                    'class' => 'text-center',
                ];
            }

            return [];
        });

        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '1') {
                return [
                    'width' => '65%',
                ];
            }
            if ($columnIndex == '2') {
                return [
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
            Column::make(__('messages.post.title'), 'title')
                ->sortable()
                ->searchable()
                ->view('blogs.table_components.title'),
            Column::make(__('messages.post.description'), 'description')
                ->searchable()
                ->view('blogs.table_components.description'),
            Column::make(__('messages.common.action'), 'id')
                ->view('blogs.table_components.action_button'),

        ];
    }
}
