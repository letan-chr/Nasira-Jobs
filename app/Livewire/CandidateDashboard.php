<?php

namespace App\Livewire;

use App\Models\Candidate;
use App\Repositories\DashboardRepository;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CandidateDashboard extends Component
{
    public $user;
    public $candidate;
    public $resumes;
    public $followings;

    public function mount()
    {
        $this->user = Auth::user();
        $this->candidate = Candidate::findOrFail($this->user->owner_id);
        $this->resumes = $this->candidate->getMedia(Candidate::RESUME_PATH)->count();
        $this->followings = $this->user->followings()->count();
    }

    public function placeholder()
    {
        return view('livewire_lazy_load.candidate_dashboard');
    }

    public function render()
    {
        return view('livewire.candidate-dashboard');
    }
}
