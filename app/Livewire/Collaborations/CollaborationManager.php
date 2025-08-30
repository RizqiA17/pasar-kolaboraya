<?php

namespace App\Livewire\Collaborations;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CollaborationManager extends Component
{
    public function render()
    {
        return view('livewire.collaborations.collaboration-manager');
    }

    public function getPendingInvitationsProperty()
    {
        return Auth::user()->collaborationInvitations()
            ->where('status', 'pending')
            ->with(['collaboration.creator'])
            ->get();
    }

    public function getMyCollaborationsProperty()
    {
        return Auth::user()->collaborations()
            ->with(['collaboration.creator', 'collaboration.collaborationUsers.user'])
            ->get();
    }
}
