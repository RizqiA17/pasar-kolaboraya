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

    public function placeholder()
    {
        return <<<'HTML'
        <div class="h-fit bg-gray-100 dark:bg-gray-800 rounded-xl p-4 animate-pulse flex justify-center">
            <div class="flex items-center justify-between w-full gap-4">
                <div class="flex items-center space-x-3 flex-grow">
                    <div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center">
                    </div>
                    <div class="flex-grow flex flex-col gap-1">
                        <h3 class="text-sm p-1 w-full mr-4 font-semibold bg-gray-200 dark:bg-gray-700">
                        </h3>
                        <p class="bg-gray-200 w-full mr-4 p-1 dark:bg-gray-700 text-xs">
                        </p>
                        <p class="text-xs w-full mr-4 bg-gray-200 p-1 dark:bg-gray-700">
                        </p>
                    </div>
                </div>
                <div class="h-6 bg-gray-200 dark:bg-gray-700 w-20"></div>
            </div>
        </div>
        HTML;
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
