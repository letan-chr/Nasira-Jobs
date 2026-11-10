<?php

namespace App\Livewire;

use App\Models\Candidate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class CandidateSearch extends Component
{
    use WithPagination;

    public $searchByCandidate = '';

    public $gender = 'all';

    public $searchBy = 'byName';

    public $location;

    public $min;

    public $max;

    private $perPage = 8;

    public int $page = 0;

    public function paginationView()
    {
        return 'livewire.custom-pagination-company';
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

    public function updatingSearchByCandidate()
    {
        $this->resetPage();
    }

    public function updatinglocation()
    {
        $this->resetPage();
    }

    public function updatingMin()
    {
        $this->resetPage();
    }

    public function updatingMax()
    {
        $this->resetPage();
    }

    public function render()
    {
        $candidates = $this->searchCandidates();

        return view('livewire.candidate-search', compact('candidates'));
    }

    public function changeFilter($param, $value)
    {
        $this->resetPage();
        $this->$param = $value;
    }

    public function resetFilter()
    {
        $this->location = '';
        $this->min = '';
        $this->max = '';
        $this->searchByCandidate = '';
//        $this->searchBy = 'byJobTitle';
        $this->gender = 'all';
    }

    public function searchCandidates(): LengthAwarePaginator
    {
        /** @var Candidate $query */
        $query = Candidate::with(['user', 'jobApplications', 'industry'])->whereHas('user', function ($q) {
            $q->where('is_active', '=', 1);
        });

        $query->when($this->searchByCandidate != '' && $this->searchBy == 'byName', function (Builder $q) {
            $q->whereHas('user', function (Builder $query) {
                $query->where('first_name', 'like', '%'.strtolower($this->searchByCandidate).'%')
                     ->orWhere('last_name', 'like', '%'.strtolower($this->searchByCandidate).'%');
            });
        });

//        $query->when($this->searchByCandidate != '' && $this->searchBy == 'byJobTitle', function (Builder $q) {
//            $q->whereHas('penddingJobApplications.job', function (Builder $query) {
//                $query->where('jobs.job_title', 'like', '%'.strtolower($this->searchByCandidate).'%');
//            });
//        });

        $query->when($this->location != '', function (Builder $q) {
            $q->whereHas('user', function (Builder $query) {
                $query->WhereHas('country', function (Builder $q) {
                    $q->where('name', 'like', '%'.$this->location.'%');
                });
                $query->orWhereHas('state', function (Builder $q) {
                    $q->where('name', 'like', '%'.$this->location.'%');
                });
                $query->orWhereHas('city', function (Builder $q) {
                    $q->where('name', 'like', '%'.$this->location.'%');
                });
            });
        });

        $query->when($this->gender == 'all', function (Builder $q) {
            $q->whereHas('user', function (Builder $q) {
                $q->whereIn('gender', [0, 1])->orWhereNull('gender');
            });
        });

        $query->when($this->gender == 'male', function (Builder $q) {
            $q->whereHas('user', function (Builder $q) {
                $q->where('gender', '=', 0);
            });
        });

        $query->when($this->gender == 'female', function (Builder $q) {
            $q->whereHas('user', function (Builder $q) {
                $q->where('gender', '=', 1);
            });
        });

        $query->when(! empty($this->min), function (Builder $q) {
            $q->where('expected_salary', '>=', $this->min);
            $q->where('expected_salary', '!=', 0);
        });
        $query->when(! empty($this->max), function (Builder $q) {
            $q->where('expected_salary', '<=', $this->max);
            $q->where('expected_salary', '!=', 0);
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
