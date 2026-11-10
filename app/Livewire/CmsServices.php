<?php

namespace App\Livewire;

use Livewire\Component;

class CmsServices extends Component
{
    public $cmsServices;
    public function mount($cmsServices){
        $this->cmsServices = $cmsServices;
    }

    public function placeholder()
    {
        return view('livewire_lazy_load.listing-skeleton-filter-no-button-search');
    }
    public function render()
    {
        return view('livewire.cms-services');
    }
}
