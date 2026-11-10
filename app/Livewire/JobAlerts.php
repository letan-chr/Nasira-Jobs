<?php

namespace App\Livewire;

use Livewire\Component;

class JobAlerts extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function placeholder()
    {
        return view('livewire_lazy_load.career-informations');
    }
    public function render()
    {
        return view('livewire.job-alerts');
    }
}
