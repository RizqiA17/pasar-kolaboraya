<?php

namespace App\Http\Controllers;

use App\Models\PasarKolaboraya;
use App\Models\Ecosystem;
use App\Models\CollectiveAction;
use App\Models\Connection;
use App\Models\User;
use App\Models\EcosystemContribution;
use App\Models\CollectiveActionContribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMarketStatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Get selected Pasar Kolaboraya (from query parameter or active session)
        $pasarKolaborayaList = PasarKolaboraya::where('status', 'active')
            ->select('id', 'name', 'description')
            ->orderBy('name')
            ->get();

        $selectedPasarId = $request->get('pasar_id');
        $selectedPasar = null;

        if ($selectedPasarId) {
            $selectedPasar = $pasarKolaborayaList->firstWhere('id', $selectedPasarId);
        }

        if (!$selectedPasar && $pasarKolaborayaList->isNotEmpty()) {
            $selectedPasar = $pasarKolaborayaList->first();
        }

        // If no pasar selected, return empty stats
        if (!$selectedPasar) {
            return view('admin.market-statistics', [
                'pasarKolaborayaList' => $pasarKolaborayaList,
                'selectedPasar' => null,
                'stats' => $this->getEmptyStats(),
            ]);
        }

        // Calculate comprehensive statistics
        $stats = $this->calculateMarketStatistics($selectedPasar->id);

        return view('admin.market-statistics', compact(
            'pasarKolaborayaList',
            'selectedPasar',
            'stats'
        ));
    }

    private function getEmptyStats()
    {
        return [
            'totals' => [
                'connections' => 0,
                'ecosystems' => 0,
                'users_in_ecosystems' => 0,
                'users_contributed_ecosystems' => 0,
                'collective_actions' => 0,
                'users_in_actions' => 0,
                'ecosystems_in_actions' => 0,
                'contributions_in_actions' => 0,
            ],
            'top_connections' => [],
            'top_ecosystems' => [],
            'top_ecosystem_contributions' => [],
            'top_actions' => [],
            'top_action_contributions' => [],
        ];
    }

    private function calculateMarketStatistics($pasarKolaborayaId)
    {
        // Total counts
        $totals = [
            'connections' => Connection::where('pasar_kolaboraya_id', $pasarKolaborayaId)
                ->where('status', 'accepted')
                ->count(),
            'ecosystems' => Ecosystem::where('pasar_kolaboraya_id', $pasarKolaborayaId)->count(),
            'users_in_ecosystems' => DB::table('ecosystem_users')
                ->join('ecosystems', 'ecosystem_users.ecosystem_id', '=', 'ecosystems.id')
                ->where('ecosystems.pasar_kolaboraya_id', $pasarKolaborayaId)
                // ->where('ecosystem_users.status', 'accepted')
                ->distinct('ecosystem_users.user_id')
                ->count('ecosystem_users.user_id'),
            'users_contributed_ecosystems' => EcosystemContribution::whereHas('ecosystem', function($q) use ($pasarKolaborayaId) {
                $q->where('pasar_kolaboraya_id', $pasarKolaborayaId);
            })->where('status', 'accepted')->distinct('user_id')->count('user_id'),
            'collective_actions' => CollectiveAction::where('pasar_kolaboraya_id', $pasarKolaborayaId)->count(),
            'users_in_actions' => DB::table('collective_action_users')
                ->join('collective_actions', 'collective_action_users.collective_action_id', '=', 'collective_actions.id')
                ->where('collective_actions.pasar_kolaboraya_id', $pasarKolaborayaId)
                // ->where('collective_action_users.status', 'active')
                ->distinct('collective_action_users.user_id')
                ->count('collective_action_users.user_id'),
            'ecosystems_in_actions' => DB::table('collective_action_ecosystem_invitations')
                ->join('collective_actions', 'collective_action_ecosystem_invitations.collective_action_id', '=', 'collective_actions.id')
                ->where('collective_actions.pasar_kolaboraya_id', $pasarKolaborayaId)
                // ->where('collective_action_ecosystem_invitations.status', 'accepted')
                ->distinct('collective_action_ecosystem_invitations.ecosystem_id')
                ->count('collective_action_ecosystem_invitations.ecosystem_id'),
            'contributions_in_actions' => CollectiveActionContribution::whereHas('collectiveAction', function($q) use ($pasarKolaborayaId) {
                $q->where('pasar_kolaboraya_id', $pasarKolaborayaId);
            })->count(),
        ];

        // Top statistics for connections
        $topConnections = $this->getTopConnectionsStats($pasarKolaborayaId);

        // Top statistics for ecosystems
        $topEcosystems = $this->getTopEcosystemsStats($pasarKolaborayaId);

        // Top statistics for ecosystem contributions
        $topEcosystemContributions = $this->getTopEcosystemContributionsStats($pasarKolaborayaId);

        // Top statistics for collective actions
        $topActions = $this->getTopActionsStats($pasarKolaborayaId);

        // Top statistics for action contributions
        $topActionContributions = $this->getTopActionContributionsStats($pasarKolaborayaId);

        return [
            'totals' => $totals,
            'top_connections' => $topConnections,
            'top_ecosystems' => $topEcosystems,
            'top_ecosystem_contributions' => $topEcosystemContributions,
            'top_actions' => $topActions,
            'top_action_contributions' => $topActionContributions,
        ];
    }

    private function getTopConnectionsStats($pasarKolaborayaId)
    {
        // User with most connections
        $userWithMostConnections = DB::table('connections')
            ->select('requester_id as user_id', DB::raw('COUNT(*) as connection_count'))
            ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('status', 'accepted')
            ->groupBy('requester_id')
            ->union(
                DB::table('connections')
                    ->select('receiver_id as user_id', DB::raw('COUNT(*) as connection_count'))
                    ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
                    ->where('status', 'accepted')
                    ->groupBy('receiver_id')
            )
            ->get()
            ->groupBy('user_id')
            ->map(function($group) {
                return $group->sum('connection_count');
            })
            ->sortDesc()
            ->take(5);

        $topUserConnections = [];
        foreach ($userWithMostConnections as $userId => $count) {
            $user = User::find($userId);
            if ($user) {
                $topUserConnections[] = [
                    'user' => $user,
                    'count' => $count,
                ];
            }
        }

        // User with most diverse connections by role (assigned_role)
        $userWithMostDiverseRoles = DB::table('connections')
            ->select('connections.requester_id as user_id', DB::raw('COUNT(DISTINCT users.assigned_role) as role_count'))
            ->join('users', 'connections.receiver_id', '=', 'users.id')
            ->where('connections.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('connections.status', 'accepted')
            ->whereNotNull('users.assigned_role')
            ->groupBy('connections.requester_id')
            ->union(
                DB::table('connections')
                    ->select('connections.receiver_id as user_id', DB::raw('COUNT(DISTINCT users.assigned_role) as role_count'))
                    ->join('users', 'connections.requester_id', '=', 'users.id')
                    ->where('connections.pasar_kolaboraya_id', $pasarKolaborayaId)
                    ->where('connections.status', 'accepted')
                    ->whereNotNull('users.assigned_role')
                    ->groupBy('connections.receiver_id')
            )
            ->get()
            ->groupBy('user_id')
            ->map(function($group) {
                return $group->max('role_count');
            })
            ->sortDesc()
            ->take(5);

        $topUserDiverseConnections = [];
        foreach ($userWithMostDiverseRoles as $userId => $count) {
            $user = User::find($userId);
            if ($user) {
                $topUserDiverseConnections[] = [
                    'user' => $user,
                    'count' => $count,
                ];
            }
        }

        // Ecosystem with most diverse roles (from ecosystem_users pivot)
        $ecosystemWithMostDiverseRoles = DB::table('ecosystem_users')
            ->select('ecosystem_id', DB::raw('COUNT(DISTINCT users.assigned_role) as role_count'))
            ->join('ecosystems', 'ecosystem_users.ecosystem_id', '=', 'ecosystems.id')
            ->join('users', 'ecosystem_users.user_id', '=', 'users.id')
            ->where('ecosystems.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('ecosystem_users.status', 'accepted')
            ->whereNotNull('users.assigned_role')
            ->groupBy('ecosystem_id')
            ->orderBy('role_count', 'desc')
            ->take(5)
            ->get();

        $topEcosystemDiverseRoles = [];
        foreach ($ecosystemWithMostDiverseRoles as $item) {
            $ecosystem = Ecosystem::find($item->ecosystem_id);
            if ($ecosystem) {
                $topEcosystemDiverseRoles[] = [
                    'ecosystem' => $ecosystem,
                    'count' => $item->role_count,
                ];
            }
        }

        return [
            'most_connections' => $topUserConnections,
            'most_diverse_by_role' => $topUserDiverseConnections,
            'ecosystems_most_diverse_roles' => $topEcosystemDiverseRoles,
        ];
    }

    private function getTopEcosystemsStats($pasarKolaborayaId)
    {
        // Ecosystem with most members
        $ecosystemWithMostMembers = DB::table('ecosystem_users')
            ->select('ecosystem_id', DB::raw('COUNT(*) as member_count'))
            ->join('ecosystems', 'ecosystem_users.ecosystem_id', '=', 'ecosystems.id')
            ->where('ecosystems.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('ecosystem_users.status', 'accepted')
            ->groupBy('ecosystem_id')
            ->orderBy('member_count', 'desc')
            ->take(5)
            ->get();

        $topEcosystemMembers = [];
        foreach ($ecosystemWithMostMembers as $item) {
            $ecosystem = Ecosystem::find($item->ecosystem_id);
            if ($ecosystem) {
                $topEcosystemMembers[] = [
                    'ecosystem' => $ecosystem,
                    'count' => $item->member_count,
                ];
            }
        }

        // Ecosystem with most contributions
        $ecosystemWithMostContributions = DB::table('ecosystem_contributions')
            ->select('ecosystem_id', DB::raw('COUNT(*) as contribution_count'))
            ->join('ecosystems', 'ecosystem_contributions.ecosystem_id', '=', 'ecosystems.id')
            ->where('ecosystems.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->groupBy('ecosystem_id')
            ->orderBy('contribution_count', 'desc')
            ->take(5)
            ->get();

        $topEcosystemContributions = [];
        foreach ($ecosystemWithMostContributions as $item) {
            $ecosystem = Ecosystem::find($item->ecosystem_id);
            if ($ecosystem) {
                $topEcosystemContributions[] = [
                    'ecosystem' => $ecosystem,
                    'count' => $item->contribution_count,
                ];
            }
        }

        return [
            'most_members' => $topEcosystemMembers,
            'most_contributions' => $topEcosystemContributions,
        ];
    }

    private function getTopEcosystemContributionsStats($pasarKolaborayaId)
    {
        // Most given contribution type in ecosystems
        $mostGivenContribution = DB::table('ecosystem_contributions')
            ->select('contributions.name', DB::raw('COUNT(*) as count'))
            ->join('ecosystems', 'ecosystem_contributions.ecosystem_id', '=', 'ecosystems.id')
            ->join('contributions', 'ecosystem_contributions.contribution_id', '=', 'contributions.id')
            ->where('ecosystems.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->groupBy('contributions.id', 'contributions.name')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();

        // User with most ecosystem contributions
        $userWithMostContributions = DB::table('ecosystem_contributions')
            ->select('user_id', DB::raw('COUNT(*) as contribution_count'))
            ->join('ecosystems', 'ecosystem_contributions.ecosystem_id', '=', 'ecosystems.id')
            ->where('ecosystems.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->groupBy('user_id')
            ->orderBy('contribution_count', 'desc')
            ->take(5)
            ->get();

        $topContributors = [];
        foreach ($userWithMostContributions as $item) {
            $user = User::find($item->user_id);
            if ($user) {
                $topContributors[] = [
                    'user' => $user,
                    'count' => $item->contribution_count,
                ];
            }
        }

        // User with most ecosystems joined
        $userWithMostEcosystems = DB::table('ecosystem_users')
            ->select('user_id', DB::raw('COUNT(DISTINCT ecosystem_id) as ecosystem_count'))
            ->join('ecosystems', 'ecosystem_users.ecosystem_id', '=', 'ecosystems.id')
            ->where('ecosystems.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('ecosystem_users.status', 'accepted')
            ->groupBy('user_id')
            ->orderBy('ecosystem_count', 'desc')
            ->take(5)
            ->get();

        $topUserEcosystems = [];
        foreach ($userWithMostEcosystems as $item) {
            $user = User::find($item->user_id);
            if ($user) {
                $topUserEcosystems[] = [
                    'user' => $user,
                    'count' => $item->ecosystem_count,
                ];
            }
        }

        return [
            'most_given_type' => $mostGivenContribution,
            'most_contributors' => $topContributors,
            'users_with_most_ecosystems' => $topUserEcosystems,
        ];
    }

    private function getTopActionsStats($pasarKolaborayaId)
    {
        // Action with most members
        $actionWithMostMembers = DB::table('collective_action_users')
            ->select('collective_action_id', DB::raw('COUNT(*) as member_count'))
            ->join('collective_actions', 'collective_action_users.collective_action_id', '=', 'collective_actions.id')
            ->where('collective_actions.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('collective_action_users.status', 'active')
            ->groupBy('collective_action_id')
            ->orderBy('member_count', 'desc')
            ->take(5)
            ->get();

        $topActionMembers = [];
        foreach ($actionWithMostMembers as $item) {
            $action = CollectiveAction::find($item->collective_action_id);
            if ($action) {
                $topActionMembers[] = [
                    'action' => $action,
                    'count' => $item->member_count,
                ];
            }
        }

        // Action with most diverse roles (from collective_action_users)
        $actionWithMostDiverseRoles = DB::table('collective_action_users')
            ->select('collective_action_id', DB::raw('COUNT(DISTINCT users.assigned_role) as role_count'))
            ->join('collective_actions', 'collective_action_users.collective_action_id', '=', 'collective_actions.id')
            ->join('users', 'collective_action_users.user_id', '=', 'users.id')
            ->where('collective_actions.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('collective_action_users.status', 'active')
            ->whereNotNull('users.assigned_role')
            ->groupBy('collective_action_id')
            ->orderBy('role_count', 'desc')
            ->take(5)
            ->get();

        $topActionDiverseRoles = [];
        foreach ($actionWithMostDiverseRoles as $item) {
            $action = CollectiveAction::find($item->collective_action_id);
            if ($action) {
                $topActionDiverseRoles[] = [
                    'action' => $action,
                    'count' => $item->role_count,
                ];
            }
        }

        // Action with most ecosystems
        $actionWithMostEcosystems = DB::table('collective_action_ecosystem_invitations')
            ->select('collective_action_id', DB::raw('COUNT(*) as ecosystem_count'))
            ->join('collective_actions', 'collective_action_ecosystem_invitations.collective_action_id', '=', 'collective_actions.id')
            ->where('collective_actions.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('collective_action_ecosystem_invitations.status', 'accepted')
            ->groupBy('collective_action_id')
            ->orderBy('ecosystem_count', 'desc')
            ->take(5)
            ->get();

        $topActionEcosystems = [];
        foreach ($actionWithMostEcosystems as $item) {
            $action = CollectiveAction::find($item->collective_action_id);
            if ($action) {
                $topActionEcosystems[] = [
                    'action' => $action,
                    'count' => $item->ecosystem_count,
                ];
            }
        }

        // Action with most contributions
        $actionWithMostContributions = DB::table('collective_action_contributions')
            ->select('collective_action_id', DB::raw('COUNT(*) as contribution_count'))
            ->join('collective_actions', 'collective_action_contributions.collective_action_id', '=', 'collective_actions.id')
            ->where('collective_actions.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->groupBy('collective_action_id')
            ->orderBy('contribution_count', 'desc')
            ->take(5)
            ->get();

        $topActionContributions = [];
        foreach ($actionWithMostContributions as $item) {
            $action = CollectiveAction::find($item->collective_action_id);
            if ($action) {
                $topActionContributions[] = [
                    'action' => $action,
                    'count' => $item->contribution_count,
                ];
            }
        }

        return [
            'most_members' => $topActionMembers,
            'most_diverse_by_role' => $topActionDiverseRoles,
            'most_ecosystems' => $topActionEcosystems,
            'most_contributions' => $topActionContributions,
        ];
    }

    private function getTopActionContributionsStats($pasarKolaborayaId)
    {
        // Most given contribution type in actions
        $mostGivenContribution = DB::table('collective_action_contributions')
            ->select('contributions.name', DB::raw('COUNT(*) as count'))
            ->join('collective_actions', 'collective_action_contributions.collective_action_id', '=', 'collective_actions.id')
            ->join('contributions', 'collective_action_contributions.contribution_id', '=', 'contributions.id')
            ->where('collective_actions.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->groupBy('contributions.id', 'contributions.name')
            ->orderBy('count', 'desc')
            ->take(5)
            ->get();

        // User with most action contributions
        $userWithMostContributions = DB::table('collective_action_contributions')
            ->select('user_id', DB::raw('COUNT(*) as contribution_count'))
            ->join('collective_actions', 'collective_action_contributions.collective_action_id', '=', 'collective_actions.id')
            ->where('collective_actions.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->groupBy('user_id')
            ->orderBy('contribution_count', 'desc')
            ->take(5)
            ->get();

        $topContributors = [];
        foreach ($userWithMostContributions as $item) {
            $user = User::find($item->user_id);
            if ($user) {
                $topContributors[] = [
                    'user' => $user,
                    'count' => $item->contribution_count,
                ];
            }
        }

        // User with most actions joined
        $userWithMostActions = DB::table('collective_action_users')
            ->select('user_id', DB::raw('COUNT(DISTINCT collective_action_id) as action_count'))
            ->join('collective_actions', 'collective_action_users.collective_action_id', '=', 'collective_actions.id')
            ->where('collective_actions.pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('collective_action_users.status', 'active')
            ->groupBy('user_id')
            ->orderBy('action_count', 'desc')
            ->take(5)
            ->get();

        $topUserActions = [];
        foreach ($userWithMostActions as $item) {
            $user = User::find($item->user_id);
            if ($user) {
                $topUserActions[] = [
                    'user' => $user,
                    'count' => $item->action_count,
                ];
            }
        }

        return [
            'most_given_type' => $mostGivenContribution,
            'most_contributors' => $topContributors,
            'users_with_most_actions' => $topUserActions,
        ];
    }
}

