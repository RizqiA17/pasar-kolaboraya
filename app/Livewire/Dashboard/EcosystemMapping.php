<?php

namespace App\Livewire\Dashboard;

use App\Models\Ecosystem;
use App\Models\PasarKolaboraya;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EcosystemMapping extends Component
{
    public $pasarKolaboraya;
    public $ecosystems = [];
    public $roleData = [];
    public $userData = [];

    public function mount()
    {
        // Get the active Pasar Kolaboraya for the current user
        $user = Auth::user();
        
        if ($user && $user->active_pasar_kolaboraya_id) {
            $this->pasarKolaboraya = PasarKolaboraya::find($user->active_pasar_kolaboraya_id);
            $this->loadEcosystemData();
        }
    }

    public function loadEcosystemData()
    {
        // Get all ecosystems in the current Pasar Kolaboraya
        $this->ecosystems = $this->pasarKolaboraya->ecosystems()
            ->with(['users' => function($query) {
                $query->wherePivot('status', 'accepted');
            }])
            ->get();

        // Process data for visualization
        $this->processEcosystemData();
    }

    public function processEcosystemData()
    {
        $this->roleData = [];
        $this->userData = [];

        foreach ($this->ecosystems as $ecosystem) {
            $ecosystemRoles = [];
            $roleUsers = [];

            // Get all unique roles from existing_roles and needed_roles (these are peran IDs)
            $allRoleIds = collect($ecosystem->existing_roles ?? [])
                ->merge($ecosystem->needed_roles ?? [])
                ->unique()
                ->values()
                ->toArray();

            // Get peran details for these IDs
            $peranList = \App\Models\Peran::whereIn('id', $allRoleIds)->get();

            foreach ($peranList as $peran) {
                // Find users who have this role in this ecosystem through profile.peran relationship
                $usersWithRole = $ecosystem->users()
                    ->wherePivot('status', 'accepted')
                    ->with('profile.peran')
                    ->get()
                    ->filter(function($user) use ($peran) {
                        // Check if user has this role in their profile.peran relationship
                        return $user->profile && 
                               $user->profile->peran && 
                               $user->profile->peran->id === $peran->id;
                    });

                if ($usersWithRole->count() > 0) {
                    $roleDescription = $peran->deskripsi;

                    $ecosystemRoles[] = [
                        'role' => $peran->nama,
                        'description' => $roleDescription,
                        'count' => $usersWithRole->count(),
                        'users' => $usersWithRole->map(function($user) {
                            return [
                                'id' => $user->id,
                                'name' => $user->name,
                                'email' => $user->email,
                                'avatar' => $user->profile_photo_url ?? null,
                            ];
                        })->toArray()
                    ];

                    $roleUsers[$peran->nama] = $usersWithRole->map(function($user) {
                        return [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'avatar' => $user->profile_photo_url ?? null,
                        ];
                    })->toArray();
                }
            }

            $this->roleData[] = [
                'ecosystem' => [
                    'id' => $ecosystem->id,
                    'name' => $ecosystem->ecosystem_title,
                    'organization' => $ecosystem->organization_name,
                    'description' => $ecosystem->description,
                    'issues' => $ecosystem->issues_addressed ?? [],
                    'work_region' => $ecosystem->work_region,
                ],
                'roles' => $ecosystemRoles,
                'needed_roles' => $ecosystem->needed_roles ?? [],
                'totalUsers' => $ecosystem->users()->wherePivot('status', 'accepted')->count(),
            ];

            $this->userData[$ecosystem->id] = $roleUsers;
        }
    }

    public function getRoleUsers($ecosystemId, $role)
    {
        return $this->userData[$ecosystemId][$role] ?? [];
    }

    public function render()
    {
        return view('livewire.dashboard.ecosystem-mapping');
    }
}
