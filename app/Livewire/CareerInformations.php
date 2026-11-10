<?php

namespace App\Livewire;

use Livewire\Component;

class CareerInformations extends Component
{
    public $user, $data, $countries, $states, $cities, $candidateSkills, $candidateLanguage;
    public function mount($user, $data, $countries, $states, $cities, $candidateSkills, $candidateLanguage){
        $this->user = $user;
        $this->data = $data;
        $this->countries = $countries;
        $this->states = $states;
        $this->cities = $cities;
        $this->candidateSkills = $candidateSkills;
        $this->candidateLanguage = $candidateLanguage;
    }
    public function placeholder()
    {
        return view('livewire_lazy_load.career-informations');
    }
    public function render()
    {
        return view('livewire.career-informations');
    }
}
