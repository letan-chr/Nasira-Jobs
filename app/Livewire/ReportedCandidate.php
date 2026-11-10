<?php

namespace App\Livewire;

use App\ReportedToCandidate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ReportedCandidate
 */
class ReportedCandidate extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    public $searchByCandidate = '';

    public $filterByReportedDate = '';

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * @var string[]
     */
    protected $listeners = ['deleteReportedCandidate', 'changeFilter'];

    /**
     * @var int
     */
    private $perPage = 8;

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

    public function deleteReportedCandidate($reportedCandidateId)
    {
        $candidate = ReportedToCandidate::findOrFail($reportedCandidateId);
        $candidate->delete();
        $this->dispatch('delete');
    }

    public function changeFilter($param, $value)
    {
        $this->resetPage();
        $this->$param = $value;
    }

    public function updatingsearchByCandidate()
    {
        $this->resetPage();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $reportedCandidates = $this->reportedCandidate();

        return view('livewire.reported-candidate', compact('reportedCandidates'));
    }

    public function reportedCandidate(): LengthAwarePaginator
    {
        $query = ReportedToCandidate::with(['user' => function ($query) {
            $query->without(['state', 'city', 'country']);
        }, 'candidate.user'])->select('reported_to_candidates.*');

        $query->when(isset($this->filterByReportedDate) && $this->filterByReportedDate != '', function (Builder $q) {
            $q->whereMonth('reported_to_candidates.created_at', $this->filterByReportedDate);
        });
        $query->when(isset($this->searchByCandidate) && $this->searchByCandidate != '', function (Builder $q) {
            if ($this->filterByReportedDate == '') {
                $q->whereHas('candidate.user', function (Builder $q) {
                    $q->where('first_name', 'like',
                        '%'.strtolower($this->searchByCandidate).'%');
                })
                    ->orWhereHas('user', function (Builder $q) {
                        $q->where('first_name', 'like', '%'.$this->searchByCandidate.'%');
                    });
            } else {
                $q->whereHas('candidate.user', function (Builder $q) {
                    $q->where('first_name', 'like',
                        '%'.strtolower($this->searchByCandidate).'%')->whereMonth('reported_to_candidates.created_at',
                            $this->filterByReportedDate);
                })
                    ->orWhereHas('user', function (Builder $q) {
                        $q->where('first_name', 'like',
                            '%'.$this->searchByCandidate.'%')->whereMonth('reported_to_candidates.created_at',
                                $this->filterByReportedDate);
                    });
            }
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
