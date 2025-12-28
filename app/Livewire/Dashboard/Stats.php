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
    public string $title;
    public string $description;
    public string $icon;
    public string $iconColor;
    public string $iconBgColor;
    public string $link;

    public function mount(

        string $type,
        string $title,
        string $description,
        string $icon,
        string $iconColor,
        string $iconBgColor,
        string $link

    ) {

        $this->type = $type;
        $this->title = $title;
        $this->description = $description;
        $this->icon = $icon;
        $this->iconColor = $iconColor;
        $this->iconBgColor = $iconBgColor;
        $this->link = $link;

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

    public function placeholder()
    {
        return <<<'HTML'
        <div class="col-span-1 group relative overflow-hidden rounded-xl p-5 h-44 bg-gray-100 dark:bg-gray-800 animate-pulse flex flex-col">
            <div class="relative z-10 flex flex-col flex-grow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                    </div>
                    <div class="text-right flex flex-col gap-1">
                        <div class="w-14 h-4 bg-gray-200 dark:bg-gray-700 rounded"></div>
                        <div class="w-10 h-3 bg-gray-200 dark:bg-gray-700 rounded"></div>
                    </div>
                </div>

                <div class="h-4 w-32 bg-gray-200 dark:bg-gray-700 rounded mb-2"></div>

                <div class="h-3 w-full bg-gray-200 dark:bg-gray-700 rounded mb-3"></div>

                <div class="h-4 w-24 bg-gray-200 dark:bg-gray-700 rounded mt-auto"></div>
            </div>
        </div>
        HTML;
    }

    public function getCountProperty()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return 0;
            }

            return match ($this->type) {
                'connections' => Cache::tags("stats:connections:{$user->id}:{$user->active_pasar_kolaboraya_id}")->rememberForever(
                    "stats:connections:{$user->id}",
                    fn() => Connection::forUserActiveSession($user)
                        ->where('status', 'accepted')
                        ->where(
                            fn($query) => $query
                                ->where('requester_id', $user->id)
                                ->orWhere('receiver_id', $user->id)
                        )->count()
                ),
                'ecosystems' => Cache::tags("stats:ecosystems:{$user->id}:{$user->active_pasar_kolaboraya_id}")->rememberForever(
                    "stats:ecosystems:{$user->id}",
                    fn() => Ecosystem::forUserActiveSession($user)
                        ->whereHas('acceptedUsers', fn($query) => $query->where('user_id', $user->id))
                        ->count()
                ),
                'collective_actions' => Cache::tags("stats:collective_actions:{$user->id}:{$user->active_pasar_kolaboraya_id}")->rememberForever(
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
