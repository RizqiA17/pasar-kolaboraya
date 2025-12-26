<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Profile;
use App\Models\Ecosystem;
use App\Models\CollectiveAction;
use App\Models\Connection;
use App\Models\Interest;
use App\Models\Skill;
use App\Models\Contribution;
use App\Models\EventCategory;
use App\Models\Peran;

#[Layout('layouts.admin', ['title' => 'Admin Dashboard'])]
class Dashboard extends Component
{
    public array $stats = [];
    public $recentUsers;
    public $recentEcosystems;
    public $recentCollectiveActions;

    public function mount(): void
    {
        $this->stats = Cache::remember('admin_dashboard_stats', 300, function () {
            return array_merge(
                $this->baseCounts(),
                $this->ecosystemBuilderCounts()
            );
        });

        $this->loadRecentData();
    }

    protected function baseCounts(): array
    {
        return [
            'users' => User::count(),
            'profiles' => Profile::count(),
            'ecosystems' => Ecosystem::count(),
            'collective_actions' => CollectiveAction::count(),
            'connections' => Connection::count(),
            'interests' => Interest::count(),
            'skills' => Skill::count(),
            'contributions' => Contribution::count(),
            'peran' => Peran::count(),
        ];
    }

    protected function ecosystemBuilderCounts(): array
    {
        $row = User::where('is_ecosystem_builder', true)
            ->selectRaw("
                SUM(CASE WHEN ecosystem_builder_status = 'pending' THEN 1 ELSE 0 END) AS pending,
                SUM(CASE WHEN ecosystem_builder_status = 'approved' THEN 1 ELSE 0 END) AS approved,
                SUM(CASE WHEN ecosystem_builder_status = 'rejected' THEN 1 ELSE 0 END) AS rejected
            ")
            ->first();

        return [
            'ecosystem_builders_pending' => (int) $row->pending,
            'ecosystem_builders_approved' => (int) $row->approved,
            'ecosystem_builders_rejected' => (int) $row->rejected,
        ];
    }

    protected function loadRecentData(): void
    {
        $this->recentUsers = User::query()
            ->whereHas('profile')
            ->with([
                'profile:id,user_id,profile_photo'
            ])
            ->latest()
            ->limit(5)
            ->get(['id', 'name', 'email', 'created_at']);

        $this->recentEcosystems = Ecosystem::query()
            ->whereHas('creator', fn($q) => $q->withoutTrashed())
            ->with([
                'creator:id,name'
            ])
            ->latest()
            ->limit(5)
            ->get(['id', 'ecosystem_title', 'creator_id', 'created_at']);

        $this->recentCollectiveActions = CollectiveAction::query()
            ->whereHas('creator', fn($q) => $q->withoutTrashed())
            ->with([
                'creator:id,name'
            ])
            ->latest()
            ->limit(5)
            ->get(['id', 'title', 'created_by', 'created_at']);
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
