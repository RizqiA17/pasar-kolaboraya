<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use App\Models\Event;
use App\Models\Collaboration;
use Livewire\Component;

class Stats extends Component
{
    public string $type;

    public function getCountProperty()
    {
        $user = auth()->user();
        
        return match($this->type) {
            'connections' => $user->connections()->count(),
            'collaborations' => $user->collaborations()->count(),
            'events' => $user->events()->count(),
            default => 0
        };
    }

    public function render()
    {
        return view('livewire.dashboard.stats', [
            'count' => $this->count
        ]);
    }
}
