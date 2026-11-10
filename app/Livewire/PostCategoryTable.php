<?php

namespace App\Livewire;

use App\Models\PostCategory;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PostCategoryTable extends LivewireTableComponent
{
    protected $model = PostCategory::class;

    public $showButtonOnHeader = true;
    public $showFilterOnHeader = false;

    public $buttonComponent = 'blog_categories.table_components.add_button';

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
            if ($column->isField('description')) {
                return [
                    'width' => '65%',
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
            Column::make(__('messages.post_category.name'), 'name')
                ->sortable()
                ->searchable()
                ->view('blog_categories.table_components.name'),
            Column::make(__('messages.post_category.description'), 'description')
                ->searchable()
                ->view('blog_categories.table_components.description'),
            Column::make(__('messages.common.action'), 'id')
                ->view('blog_categories.table_components.action_button'),
        ];
    }
}
