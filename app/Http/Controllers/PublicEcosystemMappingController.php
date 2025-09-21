<?php

namespace App\Http\Controllers;

use App\Models\PasarKolaboraya;
use App\Models\Ecosystem;
use Illuminate\Http\Request;

class PublicEcosystemMappingController extends Controller
{
    public function index(Request $request)
    {
        // Get all active Pasar Kolaboraya for market selector
        $pasarKolaborayaList = PasarKolaboraya::active()
            ->select('id', 'name', 'description')
            ->orderBy('name')
            ->get();

        // Get selected Pasar Kolaboraya (from query parameter or first available)
        $selectedPasarId = $request->get('pasar_id');
        $selectedPasar = null;
        
        if ($selectedPasarId) {
            $selectedPasar = $pasarKolaborayaList->firstWhere('id', $selectedPasarId);
        }
        
        if (!$selectedPasar && $pasarKolaborayaList->isNotEmpty()) {
            $selectedPasar = $pasarKolaborayaList->first();
        }

        // Get ecosystem data for selected Pasar Kolaboraya
        $ecosystems = collect();
        $roleData = [];
        $pasarKolaboraya = null;

        if ($selectedPasar) {
            $pasarKolaboraya = $selectedPasar;
            $ecosystems = $selectedPasar->ecosystems()
                ->with(['users' => function($query) {
                    $query->wherePivot('status', 'accepted');
                }])
                ->get();

            // Process data for visualization
            $roleData = $this->processEcosystemData($ecosystems);
        }

        return view('public-ecosystem-mapping', compact(
            'pasarKolaborayaList',
            'selectedPasar',
            'pasarKolaboraya',
            'ecosystems',
            'roleData'
        ));
    }

    private function processEcosystemData($ecosystems)
    {
        $roleData = [];

        foreach ($ecosystems as $ecosystem) {
            $ecosystemRoles = [];

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
                    // Get role description from peran table
                    $peranModel = \App\Models\Peran::where('nama', $role)->first();
                    $roleDescription = $peranModel ? $peranModel->deskripsi : 'Tidak ada deskripsi tersedia';

                    $ecosystemRoles[] = [
                        'role' => $role,
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
                }
            }

            $roleData[] = [
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
        }

        return $roleData;
    }
}
