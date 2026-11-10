<?php

namespace App\Livewire;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ResumeTable extends LivewireTableComponent
{
    protected $model = Candidate::class;
    public $showFilterOnHeader = false;

    public $showButtonOnHeader = true;

    public $buttonComponent = 'candidate.profile.resume_table_components.add_button';

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $this->setDefaultSort('created_at', 'desc');

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('id')) {
                return [
                    'style' => 'width:14%',
                    'class' => 'text-center',
                ];
            }
            if ($column->isField('created_at')) {
                return [
                    'style' => 'width:30%',
                    'class' => 'text-center',
                ];
            }

            return [
                'class' => 'text-center',
            ];
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
            Column::make(__('messages.candidate_profile.title'), 'custom_properties')
                ->sortable()
                ->searchable()
                ->view('candidate.profile.resume_table_components.title'),
            Column::make(__('messages.common.created_date'), 'created_at')
                ->sortable()
                ->view('candidate.profile.resume_table_components.created_at'),
            Column::make(__('messages.common.action'), 'id')
                ->view('candidate.profile.resume_table_components.action_button'),
        ];
    }

    public function builder(): Builder
    {
        return Media::where('collection_name', Candidate::RESUME_PATH)
            ->where('model_type', Candidate::class)
            ->where('model_id', Auth::user()->candidate->id)->select('media.*');
    }
}
