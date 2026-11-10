<?php

namespace App\Livewire;

use App\Models\FrontSetting;
use App\Models\SalaryCurrency;
use Livewire\Component;

class FrontSettings extends Component
{
    public $currencies;
    public $frontSettings;
    public function mount(){
        $this->currencies = SalaryCurrency::pluck('currency_name', 'id');
        $this->frontSettings = FrontSetting::pluck('value', 'key')->toArray();
    }

    public function placeholder()
    {
        return view('livewire_lazy_load.front-settings');
    }

    public function render()
    {
        return view('livewire.front-settings');
    }
}
