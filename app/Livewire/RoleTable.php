<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\Permission\Models\Role;

class RoleTable extends LivewireTableComponent
{
    protected $model = Role::class;

    public $showButtonOnHeader = true;

    public $showFilterOnHeader = false;

    public $buttonComponent = 'roles.table-components.add_button';

    public function builder(): Builder
    {
        return Role::query()->withCount('permissions');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
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
            if (in_array($columnIndex, [1, 2, 3], true)) {
                return [
                    'class' => 'text-center',
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
            Column::make(__('messages.role.name'), 'name')
                ->sortable()
                ->searchable()
                ->view('roles.table-components.name'),
            Column::make(__('messages.role.permissions'), 'id')
                ->view('roles.table-components.permissions'),
            Column::make(__('messages.common.created_date'), 'created_at')
                ->sortable()
                ->view('roles.table-components.created_at'),
            Column::make(__('messages.common.action'), 'id')
                ->view('roles.table-components.action_button'),
        ];
    }
}
