<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;

class ImageSlidersComponent extends Component
{
    public $settings;
    public function mount(){
        $this->settings = Setting::pluck('value', 'key')->toArray();
    }
    public function placeholder()
    {
        return view('livewire_lazy_load.image-sliders');
    }

    public function render()
    {
        return view('livewire.image-sliders-component');
    }
}
