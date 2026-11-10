<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;

class AdminTable extends LivewireTableComponent
{
    protected $model = User::class;

    public $showButtonOnHeader = true;
    public $showFilterOnHeader = false;

    public $isSuperAdmin = false;

    public $buttonComponent = 'admins.table_components.add_button';

    protected $listeners = ['refresh' => '$refresh', 'changeStatus'];

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
        $this->setThAttributes(function (Column $column) {
            if ($column->isField('first_name')) {
                return [
                    'class' => 'text-start',
                ];
            }
            // if ($column->isField('id')) {
            //     return [
            //         'class' => 'text-start',
            //     ];
            // }

            return [];
        });
        $this->setFilterPillsStatus(false);

        $this->setQueryStringStatus(false);
    }

    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton')->render();
    }
    public function columns(): array
    {
        $this->isSuperAdmin = getSuperAdmin()->id == getLoggedInUserId();
        if ($this->isSuperAdmin) {
            $columnsArr = [
                Column::make(__('messages.common.name'), 'first_name')
                    ->sortable()
                    ->searchable(function (Builder $query, $direction) {
                    $query->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like ?", ['%'.$direction.'%']);
                    })
                    ->view('admins.table_components.name_email'),
                Column::make(__('messages.company.email'), 'email')
                ->hideIf('email')
                ->searchable(),
                Column::make(__('messages.setting.phone'), 'phone')
                    ->sortable()
                    ->searchable()
                    ->view('admins.table_components.phone'),
                Column::make(__('messages.common.status'), 'is_active')
                    ->sortable()
                    ->view('admins.table_components.status'),
                Column::make(__('messages.common.action'), 'id')
                    ->view('admins.table_components.action_button'),
            ];
        } else {
            $columnsArr = [
                Column::make(__('messages.common.admin_name'), 'first_name')
                    ->sortable()
                    ->searchable()
                    ->view('admins.table_components.name_email'),
                Column::make(__('messages.setting.phone'), 'phone')
                    ->sortable()
                    ->searchable()
                    ->view('admins.table_components.phone'),
            ];
        }

        return $columnsArr;
    }

    public function builder(): Builder
    {
        return User::where('id', '!=', Auth::user()->id)->whereHas('roles', function ($q) {
            $q->where('name', 'Admin');
        })->select('users.*');
    }

    public function changeStatus($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_active' => ! (bool) $user->is_active,
        ]);
    }
}
