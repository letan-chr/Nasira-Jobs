<?php

namespace App\Livewire;

use App\Models\City;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class Cities
 */
class Cities extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    public $searchByCity = '';

    public $filterState = '';

    /**
     * @var int
     */
    private $perPage = 8;

    /**
     * @var string[]
     */
    protected $listeners = ['changeFilter', 'refresh' => '$refresh', 'deleteCity'];

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

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

    public function changeFilter($param, $value)
    {
        $this->resetPage();
        $this->$param = $value;
    }

    public function deleteCity(int $cityId)
    {
        $city = City::with('users')->findOrFail($cityId);
        if ($city->users()->count() > 0) {
            $this->dispatch('NotDeleted');
        } else {
            $city->delete();
            $this->dispatch('delete');
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $cities = $this->city();

        return view('livewire.cities', compact('cities'));
    }

    public function city(): LengthAwarePaginator
    {
        $query = City::with('state')->select('cities.*');

        $query->when(isset($this->filterState) && $this->filterState != '', function (Builder $q) {
            $q->where('cities.state_id', '=', $this->filterState);
        });

        $query->when(isset($this->searchByCity) && $this->searchByCity != '', function (Builder $q) {
            $q->Where('name', 'like',
                '%'.strtolower($this->searchByCity).'%');
            $q->whereHas('state', function (Builder $q) {
                $q->orWhere('name', 'like',
                    '%'.strtolower($this->searchByCity).'%');
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
