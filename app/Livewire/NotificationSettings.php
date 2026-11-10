<?php

namespace App\Livewire;

use App\Models\NotificationSetting;
use Livewire\Component;

class NotificationSettings extends Component
{
    public $notificationSetting;

    public function mount($notificationSetting)
    {
        $this->notificationSetting = $notificationSetting;
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
            loading
        </div>
        HTML;
        // return view('livewire_lazy_load.candidate_dashboard');
    }

    public function render()
    {
        return view('livewire.notification-settings');
    }
}
