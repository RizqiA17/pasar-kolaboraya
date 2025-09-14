<?php

namespace App\Livewire\Dashboard;

use App\Models\CollectiveAction;
use App\Models\Ecosystem;
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

        // HANYA AKSI KOLEKTIF: Get collective actions where user is involved through ecosystem membership
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

        // HANYA EKOSISTEM: Get ecosystems where user is a member
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

        // Merge only ecosystem-related activities
        $activities = $activities->merge($collectiveActions)
                                ->merge($userEcosystems);

        // Remove duplicates and sort by created_at
        return $activities->unique('id')
                         ->sortByDesc('created_at')
                         ->take(5)
                         ->values();
    }

    public function render()
    {
        return view('livewire.dashboard.activity-timeline', [
            'activities' => $this->activities
        ]);
    }
}
