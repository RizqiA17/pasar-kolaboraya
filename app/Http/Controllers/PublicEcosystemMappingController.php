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
                ->with([
                    'users' => function ($query) {
                        $query->wherePivot('status', 'accepted');
                    }
                ])
                ->get();

            // Process data for visualization
            $roleData = $this->processEcosystemData($ecosystems);
        }
        // dd($roleData);

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

        // Mapping nama role -> ID
        $roleNameToId = \App\Models\Peran::pluck('id', 'nama');

        foreach ($ecosystems as $ecosystem) {
            // --- Ambil role dari user ---
            $acceptedUsers = $ecosystem->users()
                ->wherePivot('status', 'accepted')
                ->get(['users.id', 'users.name', 'users.email', 'users.assigned_role']);

            $userRoleIds = $acceptedUsers
                ->map(fn($u) => $roleNameToId[$u->assigned_role] ?? null)
                ->filter()
                ->toArray();

            // --- Ambil role dari ekosistem ---
            $existingRoleIds = collect($ecosystem->existing_roles ?? [])->map(fn($id) => (int) $id)->toArray();

            // --- Gabungan role yang sudah ada ---
            $coveredRoleIds = array_unique(array_merge($existingRoleIds, $userRoleIds));

            // --- Role yang dibutuhkan (needed) ---
            $neededRoleIds = collect($ecosystem->needed_roles ?? [])->map(fn($id) => (int) $id)->toArray();

            // --- Cari gap ---
            $gapRoleIds = array_diff($neededRoleIds, $coveredRoleIds);

            // Ambil nama role
            $coveredRoles = \App\Models\Peran::whereIn('id', $coveredRoleIds)->get();
            $gapRoles = \App\Models\Peran::whereIn('id', $gapRoleIds)->pluck('nama')->toArray();

            // --- Group user berdasarkan assigned_role (string) ---
            $grouped = $acceptedUsers->groupBy('assigned_role');

            $ecosystemRoles = [];
            foreach ($coveredRoles as $peran) {
                $key = $peran->nama;
                $usersWithRole = $grouped->get($key, collect());

                $ecosystemRoles[] = [
                    'role' => $peran->nama,
                    'description' => $peran->deskripsi,
                    'count' => $usersWithRole->count(),
                    'users' => $usersWithRole->map(fn($u) => [
                        'id' => $u->id,
                        'name' => $u->name,
                        'email' => $u->email,
                        'avatar' => $u->profile_photo_url ?? null,
                    ])->toArray()
                ];
            }

            // --- Issues ---
            $issues = $ecosystem->issues_addressed ?? [];
            $issueNames = [];
            if (!empty($issues)) {
                if (is_numeric($issues[0])) {
                    $issueNames = \App\Models\Interest::whereIn('id', $issues)->pluck('name')->toArray();
                } else {
                    $issueNames = $issues;
                }
            }

            $roleData[] = [
                'ecosystem' => [
                    'id' => $ecosystem->id,
                    'name' => $ecosystem->ecosystem_title,
                    'organization' => $ecosystem->organization_name,
                    'description' => $ecosystem->description,
                    'issues' => $issueNames,
                    'work_region' => $ecosystem->work_region,
                ],
                'roles' => $ecosystemRoles,  // Role yang sudah ada (dari user + existing_roles)
                'needed_roles' => $gapRoles, // Role yang belum ada
                'totalUsers' => $acceptedUsers->count(),
            ];
        }

        return $roleData;
    }

}
