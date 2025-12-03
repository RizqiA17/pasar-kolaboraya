<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Ecosystem;
use App\Models\Connection;
use App\Models\CollectiveAction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

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

            return match ($this->type) {
                'connections' => Cache::tags('stats:connections')->rememberForever(
                    "stats:connections:{$user->id}",
                    fn() => Connection::forUserActiveSession($user)
                        ->where('status', 'accepted')
                        ->where(
                            fn($query) => $query
                                ->where('requester_id', $user->id)
                                ->orWhere('receiver_id', $user->id)
                        )->count()
                ),
                'ecosystems' => Cache::tags('stats:ecosystems')->rememberForever(
                    "stats:ecosystems:{$user->id}",
                    fn() => Ecosystem::forUserActiveSession($user)
                        ->whereHas('acceptedUsers', fn($query) => $query->where('user_id', $user->id))
                        ->count()
                ),
                'collective_actions' => Cache::tags('stats:collective_actions')->rememberForever(
                    "stats:collective_actions:{$user->id}",
                    fn() => CollectiveAction::forUserActiveSession($user)
                        ->whereHas('acceptedUsers', fn($query) => $query->where('user_id', $user->id))
                        ->count()
                ),
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
