<?php

namespace App\Livewire;

use Livewire\Component;

class HeaderSlidersComponent extends Component
{
    public $settings;
    public function mount($settings){
        $this->settings = $settings;
    }
    public function render()
    {
        return view('livewire.header-sliders-component');
    }
}
