<?php

namespace App\Livewire\Collaborations;

use App\Models\CollaborationUser;
use Livewire\Component;
use App\Models\Collaboration;

class ListCollaboration extends Component
{
    public $collaborations = [];

    public function mount()
    {
        $this->loadCollaboration();
    }

    public function loadCollaboration()
    {
        $myCollab = CollaborationUser::with(['collaboration', 'user'])
            ->where('user_id', auth()->id())
            ->get();
            
        $collabIds = $myCollab->pluck('collaboration_id');
        
        $patnerCollab = CollaborationUser::with(['collaboration', 'user'])
            ->whereIn('collaboration_id', $collabIds)
            ->where('user_id', '!=', auth()->id())
            ->get();
            
        $this->collaborations = $patnerCollab;
    }

    public function render()
    {
        return view('livewire.collaborations.list-collaboration');
    }
}
