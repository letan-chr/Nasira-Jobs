<?php

namespace App\Livewire;

use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class JobTags
 */
class JobTags extends Component
{
    use WithPagination;

    /**
     * @var int
     */
    private $perPage = 16;

    /**
     * @var string
     */
    public $searchByJobTags = '';

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * @var string[]
     */
    protected $listeners = ['refresh' => '$refresh', 'deleteJobTag'];

    public function paginationView(): string
    {
        return 'livewire.custom-pagenation-jobs';
    }

    public function nextPage($lastPage)
    {
        if ($this->page < $lastPage) {
            $this->page = $this->page + 1;
        }
    }

    public function previousPage()
    {
        if ($this->page > 1) {
            $this->page = $this->page - 1;
        }
    }

    public function deleteJobTag(int $jobTagId)
    {
        $jobTag = Tag::findOrFail($jobTagId);
        $jobTag->delete();
        $this->dispatch('delete');
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $jobTags = $this->jobTag();

        return view('livewire.job-tags', compact('jobTags'));
    }

    public function jobTag(): LengthAwarePaginator
    {
        $query = Tag::query()->select('tags.*');

        $query->when(isset($this->searchByJobTags) && $this->searchByJobTags != '', function (Builder $q) {
            $q->where('name', 'like',
                '%'.strtolower($this->searchByJobTags).'%');
        });

        $all = $query->paginate($this->perPage);
        $currentPage = $all->currentPage();
        $lastPage = $all->lastPage();
        if ($currentPage > $lastPage) {
            $this->page = $lastPage;
            $all = $query->paginate($this->perPage);
        }

        return $all;
    }
}
