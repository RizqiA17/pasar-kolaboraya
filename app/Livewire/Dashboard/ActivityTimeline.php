<?php

namespace App\Livewire\Dashboard;

use App\Models\Event;
use App\Models\Collaboration;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ActivityTimeline extends Component
{
    public function getActivitiesProperty()
    {
        $user = auth()->user();

        $events = Event::where(function($query) use ($user) {
            $query->whereHas('participants', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        })->select([
            'id',
            'title',
            'created_at',
            DB::raw("'event' as type")
        ]);

        $collaborations = Collaboration::where(function($query) use ($user) {
            $query->whereHas('members', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        })->select([
            'id',
            'title',
            'created_at',
            DB::raw("'collaboration' as type")
        ]);

        return $events->union($collaborations)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.activity-timeline', [
            'activities' => $this->activities
        ]);
    }
}
