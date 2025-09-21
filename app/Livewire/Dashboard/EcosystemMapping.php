<?php

namespace App\Livewire\Dashboard;

use App\Models\Ecosystem;
use App\Models\PasarKolaboraya;
use App\Models\User;
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
        $this->pasarKolaboraya = auth()->user()->activePasarKolaboraya;
        
        if ($this->pasarKolaboraya) {
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

            // Get all unique roles from existing_roles and needed_roles
            $allRoles = collect($ecosystem->existing_roles ?? [])
                ->merge($ecosystem->needed_roles ?? [])
                ->unique()
                ->values()
                ->toArray();

            foreach ($allRoles as $role) {
                // Find users who have this role in this ecosystem
                $usersWithRole = $ecosystem->users()
                    ->wherePivot('status', 'accepted')
                    ->get()
                    ->filter(function($user) use ($role) {
                        // Check if user has this role in their profile or ecosystem membership
                        return $user->assigned_role === $role || 
                               $user->user_type === $role ||
                               $user->role === $role;
                    });

                if ($usersWithRole->count() > 0) {
                    $ecosystemRoles[] = [
                        'role' => $role,
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

                    $roleUsers[$role] = $usersWithRole->map(function($user) {
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
                ],
                'roles' => $ecosystemRoles,
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
