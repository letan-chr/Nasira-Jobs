<?php

namespace App\Livewire;

use App\Models\RequiredDegreeLevel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class DegreeLevel
 */
class DegreeLevel extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    public $searchByDegreeLevel = '';

    /**
     * @var int
     */
    private $perPage = 16;

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * @var string[]
     */
    protected $listeners = ['refresh' => '$refresh', 'deleteDegree'];

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

    public function deleteDegree($requiredDegreeLevelId)
    {
        $degreeLevel = RequiredDegreeLevel::findOrFail($requiredDegreeLevelId);
        $degreeLevel->delete();
        $this->dispatch('delete');
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $degreeLevels = $this->degreeLevel();

        return view('livewire.degree-level', compact('degreeLevels'));
    }

    public function degreeLevel(): LengthAwarePaginator
    {
        $query = RequiredDegreeLevel::query()->select('required_degree_levels.*');

        $query->when(isset($this->searchByDegreeLevel) && $this->searchByDegreeLevel != '',
            function (Builder $q) {
                $q->where('name', 'like',
                    '%'.strtolower($this->searchByDegreeLevel).'%');
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
