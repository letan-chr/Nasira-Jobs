<?php

namespace App\Livewire;

use App\Models\JobApplication;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class AppliedJobs extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    public $searchByAppliedJob = '';

    public $jobApplicationStatus = '';

    protected $paginationTheme = 'bootstrap';
    public $value;

    protected $listeners = ['removeAppliedJob', 'changeFilter', 'resetFilter'];

    /**
     * @var int
     */
    private $perPage = 6;

    public function paginationView(): string
    {
        return 'livewire.custom-pagenation-jobs';
    }

    public function nextPage($lastPage)
    {
        if ($this->page < $lastPage) {
            $this->page = $this->page + 1;
            $this->setPage($this->page);
        }
    }

    public function previousPage()
    {
        if ($this->page > 1) {
            $this->page = $this->page - 1;
            $this->setPage($this->page);
        }
    }

    public function changeFilter($value)
    {
        $this->value = $value;
        $this->resetPage();
    }

    public function resetFilter()
    {
        $this->reset();
    }

    public function removeAppliedJob($id)
    {
        $appliedJob = JobApplication::with('applicationSchedule')->findOrFail($id);

        $candidateId = getLoggedInUser()->candidate->id;
        $jobApplicationIds = JobApplication::whereCandidateId($candidateId)->pluck('id')->toArray();

        if (! in_array($id, $jobApplicationIds)) {
            $this->dispatch('appliedJob:error');

            if ($appliedJob->applicationSchedule->count() > 0) {
                $this->dispatch('notDeleted');
            }
        } else {
            $appliedJob->delete();
            $this->dispatch('deleted');
        }

//        $appliedJob = JobApplication::with('applicationSchedule')->findOrFail($id);
//        if ($appliedJob->applicationSchedule->count() > 0) {
//            $this->dispatchBrowserEvent('notDeleted');
//        } else {
//            $appliedJob->delete($id);
//            $this->dispatchBrowserEvent('deleted');
//        }
    }

    public function updatingsearchByAppliedJob()
    {
        $this->resetPage();
    }

    /**
     * @return Factory|View
     */
    public function render()
    {
        $appliedJobs = $this->searchAppliedJob();
        $jobApplicationStatusArr = JobApplication::STATUS;
        return view('livewire.applied-jobs', compact('appliedJobs', 'jobApplicationStatusArr'));
    }

    public function searchAppliedJob(): LengthAwarePaginator
    {
        $query = JobApplication::with(['candidate.user', 'job.currency', 'jobStage'])->where('candidate_id',
            getLoggedInUser()->owner_id)->orderByDesc('created_at');

        if ($this->value != '') {
            $query->where('status', $this->value);
        }

        $query->when($this->searchByAppliedJob != '', function (Builder $query) {
            $query->where(function (Builder $query) {
                $query->whereHas('job', function (Builder $query) {
                    $query->where('job_title', 'like', '%'.strtolower($this->searchByAppliedJob).'%');
                });

                $query->orWhere('created_at', 'like', '%'.strtolower($this->searchByAppliedJob).'%');
                $query->orWhere('expected_salary', 'like', '%'.strtolower($this->searchByAppliedJob).'%');
            });
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
