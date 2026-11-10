<?php

namespace App\Livewire;

use App\Repositories\DashboardRepository;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $dashboardData;
    public $registerCandidatesData;
    public $registerEmployersData;
    public $recentJobsData;

    public function mount(DashboardRepository $dashboardRepository)
    {
        $this->dashboardData = $dashboardRepository->getDashboardAssociatedData();
        $this->registerCandidatesData = $dashboardRepository->getRegisteredCandidatesData();
        $this->registerEmployersData = $dashboardRepository->getRegisteredEmployersData();
        $this->recentJobsData = $dashboardRepository->getRecentJobsData();
    }

    public function placeholder()
    {
        return view('livewire_lazy_load.admin_dashboard');
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
