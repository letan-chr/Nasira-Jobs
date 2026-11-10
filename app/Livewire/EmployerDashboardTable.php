<?php

namespace App\Livewire;

use App\Models\Job;
use App\Repositories\DashboardRepository;
use Livewire\Component;

class EmployerDashboardTable extends Component
{
    public $data;
    public $recentJobs;
    public $recentFollowers;
    public $jobStatus;
    public $gender;

    public function mount(DashboardRepository $dashboardRepositor)
    {
        $this->data = $dashboardRepositor->getEmployerDashboardData();
        $this->recentJobs = $dashboardRepositor->getEmployerRecentJobsData();
        $this->recentFollowers = $dashboardRepositor->getEmployerRecentFollowerData();
        $this->jobStatus = Job::whereCompanyId(getLoggedInUser()->owner_id)->pluck('job_title', 'id');
        $this->gender = Job::GENDER;
    }

    public function placeholder()
    {
        return view('livewire_lazy_load.employer_dashboard_table');
    }

    public function render()
    {
        return view('livewire.employer-dashboard-table');
    }
}
