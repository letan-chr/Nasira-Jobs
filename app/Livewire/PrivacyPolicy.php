<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;

class PrivacyPolicy extends Component
{
    public $privacyPolicy;
    public function mount(){
        $this->privacyPolicy = Setting::pluck('value', 'key')->toArray();
    }

    public function render()
    {
        return view('livewire.privacy-policy');
    }
}
