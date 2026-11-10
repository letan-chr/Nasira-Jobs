<?php

namespace App\Livewire;

use App\Models\Industry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class Industries
 */
class Industries extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    public $searchByIndustryNames = '';

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * @var string[]
     */
    protected $listeners = ['refresh' => '$refresh', 'deleteIndustry'];

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

    public function deleteIndustry($industryId)
    {
        $industry = Industry::findOrFail($industryId);
        $industry->delete();
        $this->dispatch('delete');
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $industries = $this->industry();

        return view('livewire.industries', compact('industries'));
    }

    public function industry(): LengthAwarePaginator
    {
        $query = Industry::query()->select('industries.*');

        $query->when(isset($this->searchByIndustryNames) && $this->searchByIndustryNames != '', function (Builder $q) {
            $q->where('name', 'like',
                '%'.strtolower($this->searchByIndustryNames).'%');
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
