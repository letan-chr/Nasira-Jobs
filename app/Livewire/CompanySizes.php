<?php

namespace App\Livewire;

use App\Models\CompanySize;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class CompanySizes
 */
class CompanySizes extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    public $searchByCompanySize = '';

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * @var string[]
     */
    protected $listeners = ['refresh' => '$refresh', 'deleteCompanySize'];

    /**
     * @var int
     */
    private $perPage = 16;

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

    public function deleteCompanySize($companySizeId)
    {
        $companySize = CompanySize::findOrFail($companySizeId);
        $companySize->delete();
        $this->dispatch('delete');
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $companySizes = $this->companySize();

        return view('livewire.company-size', compact('companySizes'));
    }

    public function companySize(): LengthAwarePaginator
    {
        $query = CompanySize::query()->select('company_sizes.*');

        $query->when(isset($this->searchByCompanySize) && $this->searchByCompanySize != '', function (Builder $q) {
            $q->where('size', 'like',
                '%'.strtolower($this->searchByCompanySize).'%');
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
