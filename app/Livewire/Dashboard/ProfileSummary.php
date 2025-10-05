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
        // Get all skills and interests including custom ones
        $allSkills = $this->profile ? $this->profile->getAllSkills() : collect();
        $allInterests = $this->profile ? $this->profile->getAllInterests() : collect();
        
        return view('livewire.dashboard.profile-summary', [
            'allSkills' => $allSkills,
            'allInterests' => $allInterests,
        ]);
    }
}






