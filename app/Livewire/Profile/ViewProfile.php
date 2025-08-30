<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Profile'])]
class ViewProfile extends Component
{
    public User $user;
    public $profile;

    public function mount($userId)
    {
        $this->user = User::findOrFail($userId);
        $this->profile = $this->user->profile;
    }

    public function render()
    {
        return view('livewire.profile.view-profile', [
            'skills' => \App\Models\Skill::all(),
            'interests' => \App\Models\Interest::all(),
            'contributions' => \App\Models\Contribution::all(),
        ]);
    }
}
