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
        
        // Load user's current selections
        $this->selectedInterests = auth()->user()->interests()
            ->pluck('interest_id')
            ->toArray();
            
        $this->selectedSkills = auth()->user()->skills()
            ->pluck('skill_id')
            ->toArray();
    }

    public function updateInterests()
    {
        auth()->user()->interests()->sync(
            collect($this->selectedInterests)->mapWithKeys(function ($id) {
                return [$id => ['level' => 1]];
            })
        );

        $this->dispatch('profile-updated');
    }

    public function updateSkills()
    {
        auth()->user()->skills()->sync(
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

        auth()->user()->contributions()->attach(
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
        auth()->user()->contributions()->detach($contributionId);
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        $userContributions = auth()->user()->contributions()
            ->withPivot('description', 'date')
            ->orderByDesc('user_contributions.date')
            ->get();

        return view('livewire.settings.profile-settings', [
            'userContributions' => $userContributions,
        ]);
    }
}
