<?php

namespace App\Livewire;

use App\Models\Candidate;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class CandidateTable extends LivewireTableComponent
{
protected $listeners = ['resetPage', 'refreshDatatable' => '$refresh', 'changeStatusFilter','changeImmediateFilter'];

    protected $model = Candidate::class;
    public string $tableName = 'candidates';

    /**
     * @var bool
     */
    public $showButtonOnHeader = true;
    public $showFilterOnHeader = true;


    /**
     * @var string
     */
    public $buttonComponent = 'candidates.table-components.add_button';

    public array $filterComponents = ['candidates.table-components.filter', Candidate::STATUS,Candidate::IMMEDIATE];

    public $status = Candidate::ALL;
    public $immediate = Candidate::ALL;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setTableAttributes([
            'default' => false,
            'class' => 'table table-striped',
        ]);

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('is_active')) {
                return [
                    'class' => 'd-flex justify-content-center',
                ];
            }

            return [
                'class' => 'text-center',
            ];
        });
        $this->setTdAttributes(function (Column $column, $row, $columnIndex, $rowIndex) {
            if ($columnIndex == '4') {
                return [
                    'class' => 'text-center',
                    'width' => '15%',

                ];
            }

            return [];
        });

        $this->setFilterPillsStatus(false);

        $this->setQueryStringStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load.listing-skeleton-tow-botton-filter')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.company.candidate_name'), 'user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('candidates.user_id', 'users.id'), $direction);
                })
                ->searchable(function (Builder $query, $direction) {
                    $query->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like ?", ['%'.$direction.'%']);
                })
                ->view('candidates.table-components.name_email'),
            Column::make(__('messages.company.email'), 'user.email')
                ->hideIf('user.email')
                ->searchable(),
            Column::make(__('messages.candidate.available_at'), 'immediate_available')
                ->view('candidates.table-components.available'),
            Column::make(__('messages.company.email_verified'), 'user.email_verified_at')
                ->sortable()
                ->view('candidates.table-components.email_verified'),
            Column::make(__('messages.common.status'), 'user.is_active')
                ->sortable()
                ->view('candidates.table-components.status'),
            Column::make(__('messages.common.last_change_by'), 'last_change')
                ->sortable()
                ->view('candidates.table-components.last_change'),
            Column::make(__('messages.common.action'), 'id')
                ->view('candidates.table-components.action_button'),
        ];
    }

    public function builder(): Builder
    {
         $query = Candidate::with('user.candidateSkill', 'admin');

         $query->when($this->status != Candidate::ALL, function($q) {
                  if($this->status) {
                           $q->where('user.is_active', 1);
                  }else {
                           $q->where('user.is_active', 0);
                  }
         });
         $query->when($this->immediate != Candidate::ALL, function($q) {
                  if($this->immediate) {
                           $q->where('immediate_available', 1);
                  }else {
                           $q->where('immediate_available', 0);
                  }
         });

         return $query->select('candidates.*');;
    }

//     public function filters(): array
//     {
//         return [
//                        MultiSelectFilter::make('Skills')
//                                    ->options(
//                                        Skill::query()
//                                            ->orderBy('name')
//                                            ->get()
//                                            ->keyBy('id')
//                                            ->map(
//                                                function ($skill) {
//                                                    return $skill->name;
//                                                }
//                                            )
//                                            ->toArray()
//                                    )
//                                    ->filter(
//                                        function ($value) {
//                                            Skill::whereHas('candidate', function ($query) use ($value) {
//                                                dd($query->where('users.id', $value)->get());
//                                            });
//             //                                dd($builder->where('user_id','=', 'user.candidateSkill.pivot.user_id')->get());
//             //                                return $builder->where('user_id', 'user.candidateSkill.user_id')->get();
//                                        },
//                                    ),
//             SelectFilter::make(__('messages.filter_name.immediate'))
//                 ->options([
//                     '' => (__('messages.filter_name.select_immediate')),
//                     1 => (__('messages.candidate.immediate_available')),
//                     2 => (__('messages.candidate.not_immediate_available')),
//                 ])
//                 ->filter(
//                     function (Builder $builder, string $value) {
//                         if ($value == 1) {
//                             $builder->where('immediate_available', '=', 1);
//                         } else {
//                             $builder->where('immediate_available', '=', 0);
//                         }
//                     }
//                 ),

//             SelectFilter::make(__('messages.common.status'))
//                 ->options([
//                     '' => (__('messages.filter_name.select_status')),
//                     1 => (__('messages.common.active')),
//                     2 => (__('messages.common.de_active')),
//                 ])
//                 ->filter(
//                     function (Builder $builder, string $value) {
//                         if ($value == 1) {
//                             $builder->where('users.is_active', '=', 1);
//                         } else {
//                             $builder->where('users.is_active', '=', 0);
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
    public function changeImmediateFilter($immediate)
    {
         $this->immediate = $immediate;
         $this->setBuilder($this->builder());
         $this->resetPagination();
    }
    public function resetPagination()
    {
        $this->resetPage('candidatesPage');
    }
}
