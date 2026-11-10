<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class CompanySearch extends Component
{
    use WithPagination;

    public int $page = 0;

    public $searchByCompany = '';

    public $searchByCity = '';

    public $searchByIndustry = '';

    protected $isFeatured = '';

    private $perPage = 12;

    public function mount($isFeatured)
    {
        $this->isFeatured = $isFeatured;
    }

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

    public function resetFilter()
    {
        $this->searchByCompany = '';
        $this->searchByCity = '';
        $this->searchByIndustry = '';
    }

//    public function updatingSearchByCompany()
//    {
//        $this->resetPage();
//    }

    public function render()
    {
        $companies = $this->companies();

        return view('livewire.company-search', compact('companies'));
    }

    public function companies()
    {
        /** @var User $user */
        $query = Company::with(['user.media', 'jobs', 'activeFeatured', 'industry', 'user.city']);
        $query->whereHas('user', function (Builder $q) {
            $q->where('first_name', 'like', '%'.strtolower($this->searchByCompany).'%')
            ->orWhere('last_name', 'like', '%'.strtolower($this->searchByCompany).'%')
            ->where('is_active', '=',
                1);
        });

        $query->when(! empty($this->searchByCity), function (Builder $q) {
            $q->where('location', 'like', '%'.strtolower($this->searchByCity).'%');
            $q->orWhere('location2', 'like', '%'.strtolower($this->searchByCity).'%');
        });

        $query->whereHas('industry', function (Builder $q) {
            $q->where('name', 'like', '%'.strtolower($this->searchByIndustry).'%');
        });
        $query->when(! empty($this->isFeatured), function (Builder $query) {
            $query->has('activeFeatured');
        });
        $query->withCount([
            'jobs' => function (Builder $q) {
                $q->where('status', '!=', Job::STATUS_DRAFT);
                $q->where('status', '!=', Job::STATUS_CLOSED);
                $q->where('job_expiry_date', '>=', Carbon::now()->toDateString());
            },
        ]);

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
