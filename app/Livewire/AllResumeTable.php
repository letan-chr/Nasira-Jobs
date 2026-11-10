<?php

namespace App\Livewire;

use App\Models\Candidate;
use App\Models\CustomMedia;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AllResumeTable extends LivewireTableComponent
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
            if ($column->isField('first_name')) {
                return [
                    'width' => '76%',
                ];
            }
            if ($column->isField('id')) {
                return [
                    'width' => '13%',
                ];
            }

            return [];
        });

        $this->setQueryStringStatus(false);

        $this->setSearchStatus(true);
    }
    public function placeholder(): string
    {
        return view('livewire_lazy_load/listing-skeleton-no-button')->render();
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.job_application.candidate_name'), 'candidate.user.first_name')
                ->sortable(function (Builder $query, $direction) {
                    return $query->orderBy(User::select('first_name')->whereColumn('candidates.user_id', 'users.id'), $direction);
                })
                ->searchable(function (Builder $query, $direction) {
                        return $query->whereHas('candidate.user', function (Builder $q) use ($direction) {
                            $q->whereRaw("TRIM(CONCAT(first_name,' ',last_name,' ')) like ?", ['%'.$direction.'%']);
                        });
                    }
                )
                ->view('resumes.table-components.candidate_name'),
            Column::make(__('messages.candidate_profile.title'), 'id')
                ->searchable()
                ->sortable()
                ->view('resumes.table-components.title'),
            Column::make(__('messages.common.download'), 'id')
                ->view('resumes.table-components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        return CustomMedia::query()->where('model_type', Candidate::class)->where('collection_name',
            Candidate::RESUME_PATH)->select('media.*')
            ->join('candidates', 'media.model_id', '=', 'candidates.id')
            ->join('users', 'candidates.user_id', '=', 'users.id')->with('candidate.user');
    }
}
