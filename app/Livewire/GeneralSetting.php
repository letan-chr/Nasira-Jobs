<?php

namespace App\Livewire;

use App\Repositories\SettingRepository;
use Livewire\Component;

class GeneralSetting extends Component
{
    public $envData,$setting, $sectionName, $envSetting, $languages;
    public function mount($envData, $setting, $sectionName, $envSetting, $languages) {
        $this->envData = $envData;
        $this->setting = $setting;
        $this->sectionName = $sectionName;
        $this->envSetting = $envSetting;
        $this->languages = $languages;
    }

    public function placeholder()
    {
        return view('livewire_lazy_load.listing-skeleton-filter-no-button-search');
    }

    public function render()
    {
        return view('livewire.general-setting');
    }
}
