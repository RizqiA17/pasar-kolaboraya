<?php

namespace App\Livewire\Dashboard;

use App\Models\CollectiveAction;
use App\Models\Ecosystem;
use App\Models\EcosystemContribution;
use App\Models\CollectiveActionContribution;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ActivityTimeline extends Component
{
    public function getActivitiesProperty()
    {
        $user = Auth::user();
        
        if (!$user) {
            return collect();
        }


        $activities = collect();

        // AKSI KOLEKTIF: Get collective actions where user is involved through ecosystem membership
        $collectiveActions = CollectiveAction::whereHas('acceptedInvitations', function($query) use ($user) {
            $query->whereHas('ecosystem', function($ecosystemQuery) use ($user) {
                $ecosystemQuery->whereHas('acceptedUsers', function($userQuery) use ($user) {
                    $userQuery->where('user_id', $user->id);
                });
            });
        })->get()->map(function($item) {
            $item->type = 'collective_action';
            return $item;
        });

        // EKOSISTEM: Get ecosystems where user is a member
        $userEcosystems = DB::table('ecosystem_users')
            ->where('user_id', $user->id)
            ->where('status', 'accepted')
            ->join('ecosystems', 'ecosystem_users.ecosystem_id', '=', 'ecosystems.id')
            ->select('ecosystems.*')
            ->get()
            ->map(function($item) {
                $item->type = 'ecosystem';
                $item->title = $item->ecosystem_title;
                return $item;
            });

        // KONTRIBUSI EKOSISTEM: Get ecosystem contributions made by user
        $ecosystemContributions = EcosystemContribution::where('user_id', $user->id)
            ->with(['ecosystem', 'contribution'])
            ->get()
            ->map(function($item) {
                $item->type = 'ecosystem_contribution';
                $contributionName = $item->contribution->name ?? 'Ekosistem';
                $item->title = 'Kontribusi ' . $contributionName . ' - ' . $item->ecosystem->ecosystem_title;
                $item->ecosystem_title = $item->ecosystem->ecosystem_title;
                return $item;
            });

        // KONTRIBUSI AKSI KOLEKTIF: Get collective action contributions made by user
        $collectiveActionContributions = CollectiveActionContribution::where('user_id', $user->id)
            ->with(['collectiveAction', 'contribution'])
            ->get()
            ->map(function($item) {
                $item->type = 'collective_action_contribution';
                $contributionName = $item->contribution->name ?? 'Aksi Kolektif';
                $item->title = 'Kontribusi ' . $contributionName . ' - ' . $item->collectiveAction->title;
                return $item;
            });



        // Merge all activities
        $activities = $activities->merge($collectiveActions)
                                ->merge($userEcosystems)
                                ->merge($ecosystemContributions)
                                ->merge($collectiveActionContributions);

        // Remove duplicates using a combination of type and id to avoid conflicts
        $uniqueActivities = $activities->unique(function($item) {
            return $item->type . '_' . $item->id;
        });

        return $uniqueActivities->sortByDesc('created_at')
                                ->take(10)
                                ->values();
    }

    public function render()
    {
        return view('livewire.dashboard.activity-timeline', [
            'activities' => $this->activities
        ]);
    }
}
