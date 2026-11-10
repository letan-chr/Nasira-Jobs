<?php

namespace App\Livewire;

use App\ReportedToCandidate;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class ReportedCandidateTable extends LivewireTableComponent
{
    public $showFilterOnHeader = false;
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

        $this->setQueryStringStatus(false);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton-no-button')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.company.candidate_name'), 'candidate.user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(\App\Models\User::select('first_name')->whereColumn('candidate.user_id', 'users.id'),
                        $direction);
                })
                ->searchable(function (Builder $query, $direction) {
                        return $query->whereHas('candidate.user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like ?", ['%'.$direction.'%']);
                        });
                    }
                )
                ->view('candidate.reported_candidate.table-components.candidate_firstname'),
            Column::make(__('messages.company.reported_by'), 'user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(\App\Models\User::select('first_name')->whereColumn('reported_to_candidates.user_id', 'users.id'),
                        $direction);
                })
                ->searchable()
                ->view('candidate.reported_candidate.table-components.user_firstname'),
            Column::make(__('messages.company.reported_on'), 'created_at')
                ->sortable()
                ->searchable()
                ->view('candidate.reported_candidate.table-components.created_at'),
            Column::make(__('messages.common.action'), 'id')
                ->view('candidate.reported_candidate.table-components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        return ReportedToCandidate::with('candidate.user', 'user')
            ->select('reported_to_candidates.*');
    }
}
