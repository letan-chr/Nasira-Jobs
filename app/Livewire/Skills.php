<?php

namespace App\Livewire;

use App\Models\Skill;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class Skills
 */
class Skills extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    public $searchBySkills = '';

    /**
     * @var string[]
     */
    protected $listeners = ['refresh' => '$refresh', 'deleteSkill'];

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

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

    public function deleteSkill($skillId)
    {
        $skill = Skill::findOrFail($skillId);
        $skill->delete();
        $this->dispatch('delete');
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $skills = $this->skill();

        return view('livewire.skills', compact('skills'));
    }

    public function skill(): LengthAwarePaginator
    {
        $query = Skill::query()->select('skills.*');
        $query->when(isset($this->searchBySkills) && $this->searchBySkills != '', function (Builder $q) {
            $q->where('name', 'like',
                '%'.strtolower($this->searchBySkills).'%');
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
