<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ActiveSessionInfo extends Component
{
    public $activePasarKolaboraya;
    public $memberCount = 0;
    public $hasActiveSession = false;

    public function mount()
    {
        $user = Auth::user();
        
        if (!$user) {
            return;
        }

        $this->hasActiveSession = $user->hasActivePasarKolaboraya();
        
        if ($this->hasActiveSession) {
            $this->activePasarKolaboraya = $user->activePasarKolaboraya;
            $this->memberCount = $this->activePasarKolaboraya->acceptedUsers->count();
        }
    }

    public function switchSession()
    {
        return redirect()->route('pasar-kolaboraya.select');
    }

    public function render()
    {
        return view('livewire.dashboard.active-session-info');
    }
}
