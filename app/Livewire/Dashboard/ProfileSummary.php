<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfileSummary extends Component
{
    public $user;
    public $profile;
    public $skills;
    public $interests;
    public $contributions;

    public function mount()
    {
        $this->user = Auth::user();
        $this->profile = $this->user->profile;
        
        if ($this->profile) {
            $this->skills = $this->profile->skills;
            $this->interests = $this->profile->interests;
            $this->contributions = $this->profile->contributions;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.profile-summary');
    }
}






