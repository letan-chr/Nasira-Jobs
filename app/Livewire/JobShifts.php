<?php

namespace App\Livewire;

use App\Models\JobShift;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class JobShifts
 */
class JobShifts extends Component
{
    use WithPagination;

    /**
     * @var string
     */
    public $searchByJobShifts = '';

    /**
     * @var string
     */
    protected $paginationTheme = 'bootstrap';

    /**
     * @var string[]
     */
    protected $listeners = ['refresh' => '$refresh', 'deleteJobShift'];

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

    public function deleteJobShift(int $jobShiftId)
    {
        $jobShift = JobShift::findOrFail($jobShiftId);
        $jobShift->delete();
        $this->dispatch('delete');
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $jobShifts = $this->jobShift();

        return view('livewire.job-shifts', compact('jobShifts'));
    }

    public function jobShift(): LengthAwarePaginator
    {
        $query = JobShift::query()->select('job_shifts.*');

        $query->when(isset($this->searchByJobShifts) && $this->searchByJobShifts != '', function (Builder $q) {
            $q->where('shift', 'like',
                '%'.strtolower($this->searchByJobShifts).'%');
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
