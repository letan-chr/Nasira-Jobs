<?php

namespace App\Livewire;

use App\Models\ReportedToCompany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ReportedEmployee
 */
class ReportedEmployee extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    public $searchByEmployee = '';

    public $filterReportedDate = '';

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * @var string[]
     */
    protected $listeners = ['deleteReportedEmployee', 'changeFilter'];

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

    public function deleteReportedEmployee($reportedCompanyId)
    {
        $company = ReportedToCompany::findOrFail($reportedCompanyId);
        $company->delete();
        $this->dispatch('delete');
    }

    public function changeFilter($param, $value)
    {
        $this->resetPage();
        $this->$param = $value;
    }

    public function updatingsearchByEmployee()
    {
        $this->resetPage();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $reportedEmployers = $this->reportedEmployee();

        return view('livewire.reported-employee', compact('reportedEmployers'));
    }

    public function reportedEmployee(): LengthAwarePaginator
    {
        $query = ReportedToCompany::with(['user' => function ($query) {
            $query->without(['state', 'city']);
        }, 'company.user'])->select('reported_to_companies.*');

        $query->when(isset($this->filterReportedDate) && $this->filterReportedDate != '', function (Builder $q) {
            $q->whereMonth('reported_to_companies.created_at', $this->filterReportedDate);
        });
        $query->when(isset($this->searchByEmployee) && $this->searchByEmployee != '', function (Builder $q) {
            if ($this->filterReportedDate == '') {
                $q->whereHas('company.user', function (Builder $q) {
                    $q->where('first_name', 'like',
                        '%'.strtolower($this->searchByEmployee).'%');
                })
                    ->orWhereHas('user', function (Builder $q) {
                        $q->where('first_name', 'like', '%'.$this->searchByEmployee.'%');
                    });
            } else {
                $q->whereHas('company.user', function (Builder $q) {
                    $q->where('first_name', 'like',
                        '%'.strtolower($this->searchByEmployee).'%')->whereMonth('reported_to_companies.created_at',
                            $this->filterReportedDate);
                })
                    ->orWhereHas('user', function (Builder $q) {
                        $q->where('first_name', 'like',
                            '%'.$this->searchByEmployee.'%')->whereMonth('reported_to_companies.created_at',
                                $this->filterReportedDate);
                    });
            }
        });

        $query->when(isset($this->filterReportedDate) && $this->filterReportedDate != '', function (Builder $q) {
            $q->whereMonth('created_at', $this->filterReportedDate);
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
