<?php

namespace App\Livewire\Dashboard;

use Cache;
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

        $userTag = "active_pasar_kolaboraya:{$user->id}";

        $this->hasActiveSession = Cache::tags($userTag)
            ->rememberForever(
                "has_active_pasar_kolaboraya:{$user->id}",
                function () use ($user) {
                    return $user->hasActivePasarKolaboraya();
                }
            );

        if ($this->hasActiveSession) {
            $this->activePasarKolaboraya =
                Cache::tags($userTag)
                    ->rememberForever("active_pasar_kolaboraya:{$user->id}", function () use ($user) {
                        $pasar = $user->activePasarKolaboraya;
                        $total = $pasar->acceptedUsers()->count();
                        return array_merge($pasar->toArray(), ['totalAcceptedUsers' => $total]);
                    });
            $this->memberCount = Cache::tags("active_pasar_kolaboraya_member_count:{$this->activePasarKolaboraya['id']}")
                ->rememberForever(
                    "active_pasar_kolaboraya_member_count:{$this->activePasarKolaboraya['id']}",
                    function () {
                        return $this->activePasarKolaboraya['totalAcceptedUsers'];
                    }
                );
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
