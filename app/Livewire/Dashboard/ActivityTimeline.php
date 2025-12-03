<?php

namespace App\Livewire\Dashboard;

use App\Models\CollectiveAction;
use App\Models\Ecosystem;
use App\Models\EcosystemContribution;
use App\Models\CollectiveActionContribution;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ActivityTimeline extends Component
{

    public function getActivitiesProperty()
    {
        $user = Auth::user();

        if (!$user || !$user->active_pasar_kolaboraya_id) {
            return collect();
        }

        $cacheKey = "activity_timeline:{$user->id}:{$user->active_pasar_kolaboraya_id}";

        return Cache::tags('activity_timeline')->rememberForever($cacheKey, function () use ($user) {
            $activities = collect();

            // AKSI KOLEKTIF
            $collectiveActions = CollectiveAction::forUserActiveSession($user)
                ->whereHas('acceptedInvitations', function ($query) use ($user) {
                    $query->whereHas('ecosystem', function ($ecosystemQuery) use ($user) {
                        $ecosystemQuery->whereHas('acceptedUsers', function ($userQuery) use ($user) {
                            $userQuery->where('user_id', $user->id);
                        });
                    });
                })->get()->map(function ($item) {
                    $item->type = 'collective_action';
                    return $item;
                });

            // EKOSISTEM
            $userEcosystems = Ecosystem::forUserActiveSession($user)
                ->whereHas('acceptedUsers', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get()
                ->map(function ($item) {
                    $item->type = 'ecosystem';
                    $item->title = $item->ecosystem_title;
                    return $item;
                });

            // KONTRIBUSI EKOSISTEM
            $ecosystemContributions = EcosystemContribution::where('user_id', $user->id)
                ->whereHas('ecosystem', function ($query) use ($user) {
                    $query->forUserActiveSession($user);
                })
                ->with(['ecosystem', 'contribution'])
                ->get()
                ->map(function ($item) {
                    $item->type = 'ecosystem_contribution';
                    $contributionName = $item->contribution->name ?? 'Ekosistem';
                    $item->title = 'Kontribusi ' . $contributionName . ' - ' . $item->ecosystem->ecosystem_title;
                    $item->ecosystem_title = $item->ecosystem->ecosystem_title;
                    return $item;
                });

            // KONTRIBUSI AKSI KOLEKTIF
            $collectiveActionContributions = CollectiveActionContribution::where('user_id', $user->id)
                ->whereHas('collectiveAction', function ($query) use ($user) {
                    $query->forUserActiveSession($user);
                })
                ->with(['collectiveAction', 'contribution'])
                ->get()
                ->map(function ($item) {
                    $item->type = 'collective_action_contribution';
                    $contributionName = $item->contribution->name ?? 'Aksi Kolektif';
                    $item->title = 'Kontribusi ' . $contributionName . ' - ' . $item->collectiveAction->title;
                    return $item;
                });

            // Merge & deduplicate
            $activities = $activities->merge($collectiveActions)
                ->merge($userEcosystems)
                ->merge($ecosystemContributions)
                ->merge($collectiveActionContributions);

            $uniqueActivities = $activities->unique(fn($item) => $item->type . '_' . $item->id);

            return $uniqueActivities->sortByDesc('created_at')->take(10)->values();
        });
    }


    public function render()
    {
        return view('livewire.dashboard.activity-timeline', [
            'activities' => $this->activities
        ]);
    }
}
