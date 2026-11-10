<?php

namespace App\Livewire;

use Livewire\Component;

class ManageSubscription extends Component
{
    public $plans;
    public function mount($plans){
        $this->plans = $plans;
    }
    public function placeholder()
    {
        return view('livewire_lazy_load.job-notifications');
    }
    public function render()
    {
        return view('livewire.manage-subscription');
    }
}
