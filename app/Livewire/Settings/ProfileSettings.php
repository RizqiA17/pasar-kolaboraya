<?php

namespace App\Livewire\Settings;

use App\Models\Interest;
use App\Models\Skill;
use App\Models\Contribution;
use Livewire\Component;

class ProfileSettings extends Component
{
    public $interests = [];
    public $skills = [];
    public $contributions = [];
    public $selectedInterests = [];
    public $selectedSkills = [];
    public $newContribution = [
        'contribution_id' => '',
        'description' => '',
        'date' => '',
    ];

    public function mount()
    {
        $this->interests = Interest::all();
        $this->skills = Skill::all();
        $this->contributions = Contribution::all();
        
        // Get or create user profile
        $profile = auth()->user()->profile;
        if (!$profile) {
            $profile = auth()->user()->profile()->create();
        }
        
        // Load user's current selections from profile
        $this->selectedInterests = $profile->interests()
            ->pluck('interest_id')
            ->toArray();
            
        $this->selectedSkills = $profile->skills()
            ->pluck('skill_id')
            ->toArray();
    }

    public function updateInterests()
    {
        $profile = auth()->user()->profile;
        if (!$profile) {
            $profile = auth()->user()->profile()->create();
        }

        $profile->interests()->sync(
            collect($this->selectedInterests)->mapWithKeys(function ($id) {
                return [$id => ['level' => 1]];
            })
        );

        $this->dispatch('profile-updated');
    }

    public function updateSkills()
    {
        $profile = auth()->user()->profile;
        if (!$profile) {
            $profile = auth()->user()->profile()->create();
        }

        $profile->skills()->sync(
            collect($this->selectedSkills)->mapWithKeys(function ($id) {
                return [$id => ['level' => 1, 'is_primary' => false]];
            })
        );

        $this->dispatch('profile-updated');
    }

    public function addContribution()
    {
        $this->validate([
            'newContribution.contribution_id' => 'required',
            'newContribution.description' => 'required|string|max:500',
            'newContribution.date' => 'required|date',
        ]);

        $profile = auth()->user()->profile;
        if (!$profile) {
            $profile = auth()->user()->profile()->create();
        }

        $profile->contributions()->attach(
            $this->newContribution['contribution_id'],
            [
                'description' => $this->newContribution['description'],
                'date' => $this->newContribution['date'],
            ]
        );

        $this->newContribution = [
            'contribution_id' => '',
            'description' => '',
            'date' => '',
        ];

        $this->dispatch('profile-updated');
    }

    public function removeContribution($contributionId)
    {
        $profile = auth()->user()->profile;
        if ($profile) {
            $profile->contributions()->detach($contributionId);
        }
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        $profile = auth()->user()->profile;
        if (!$profile) {
            $profile = auth()->user()->profile()->create();
        }

        $userContributions = $profile->contributions()
            ->withPivot('description', 'date')
            ->orderByDesc('user_contributions.date')
            ->get();

        return view('livewire.settings.profile-settings', [
            'userContributions' => $userContributions,
        ]);
    }
}
