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
