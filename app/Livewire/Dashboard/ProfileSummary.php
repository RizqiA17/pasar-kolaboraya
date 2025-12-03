<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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

        // Cache profile utama
        $this->profile = Cache::tags('profile')->rememberForever(
            "profile:{$this->user->id}",
            fn() => $this->user->profile
        );

        if ($this->profile) {
            // Cache skills
            $this->skills = Cache::tags('profile')->rememberForever(
                "profile:{$this->user->id}:skills",
                fn() => $this->profile->skills
            );

            // Cache interests
            $this->interests = Cache::tags('profile')->rememberForever(
                "profile:{$this->user->id}:interests",
                fn() => $this->profile->interests
            );
        }
    }

    public function render()
    {
        $allSkills = $this->skills ? $this->profile->getAllSkills() : collect();
        $allInterests = $this->interests ? $this->profile->getAllInterests() : collect();

        return view('livewire.dashboard.profile-summary', [
            'allSkills' => $allSkills,
            'allInterests' => $allInterests,
        ]);
    }
}
