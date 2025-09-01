<?php

namespace App\Livewire\Dashboard;

use App\Models\User;
use App\Models\Event;
use App\Models\Collaboration;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class Stats extends Component
{
    public string $type;

    public function mount()
    {
        // Ensure user is authenticated and session is valid
        if (!Auth::check()) {
            $this->redirect(route('login'));
            return;
        }
        
        // Validate session
        if (!Session::has('last_activity')) {
            Session::put('last_activity', time());
        }
    }

    public function getCountProperty()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return 0;
            }
            
            return match($this->type) {
                'connections' => $user->connections()->count(),
                'collaborations' => $user->collaborations()->count(),
                'events' => $user->events()->count(),
                default => 0
            };
        } catch (\Exception $e) {
            // Log error and return 0
            Log::error('Error getting stats count: ' . $e->getMessage(), [
                'type' => $this->type,
                'user_id' => Auth::id()
            ]);
            return 0;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.stats', [
            'count' => $this->count
        ]);
    }
}
