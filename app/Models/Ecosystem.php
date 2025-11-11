<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class Ecosystem extends Model
{
    protected $fillable = [
        'creator_id',
        'pasar_kolaboraya_id',
        'organization_name',
        'ecosystem_title',
        'issues_addressed',
        'work_region',
        'existing_roles',
        'needed_roles',
        'max_users',
        'terms_conditions',
        'description',
        'is_active',
        'auto_join_collective_actions',
        'qr_code',
    ];

    protected $casts = [
        'issues_addressed' => 'array',
        'existing_roles' => 'array',
        'needed_roles' => 'array',
        'is_active' => 'boolean',
        'auto_join_collective_actions' => 'boolean',
    ];

    /**
     * Get the creator of this ecosystem
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the Pasar Kolaboraya session this ecosystem belongs to
     */
    public function pasarKolaboraya(): BelongsTo
    {
        return $this->belongsTo(PasarKolaboraya::class, 'pasar_kolaboraya_id');
    }

    /**
     * Get users who belong to this ecosystem
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ecosystem_users')
            ->withPivot(['status', 'join_reason', 'joined_at'])
            ->withTimestamps();
    }

    /**
     * Get users with accepted status
     */
    public function acceptedUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('status', 'accepted');
    }

    /**
     * Get pending join requests
     */
    public function pendingUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('status', 'pending');
    }

    /**
     * Get collective actions that include this ecosystem
     */
    public function collectiveActions()
    {
        return CollectiveAction::whereHas('acceptedInvitations', function ($subQuery) {
            $subQuery->where('ecosystem_id', $this->id);
        });
    }

    /**
     * Get collective actions as a collection
     */
    public function getCollectiveActionsAttribute()
    {
        return $this->collectiveActions()->get();
    }

    /**
     * Check if user can join this ecosystem
     */
    public function canUserJoin(User $user): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->max_users && $this->acceptedUsers()->count() >= $this->max_users) {
            return false;
        }

        // Check if user is already a member or has pending request
        return !$this->users()->where('users.id', $user->id)->exists();
    }

    /**
     * Get user's status in this ecosystem
     */
    public function getUserStatus(User $user): ?string
    {
        $pivotData = $this->users()->where('users.id', $user->id)->first();
        return $pivotData ? $pivotData->pivot->status : null;
    }

    /**
     * Calculate ecosystem quality based on roles coverage
     * Formula: (existing roles + member roles) / total available roles
     */
    public function calculateQuality(): array
    {
        // Cache all available roles
        $allRoles = \Cache::remember('all_roles_ids', 3600, function () {
            return \App\Models\Peran::pluck('id')->toArray();
        });
        $totalRoles = count($allRoles);

        if ($totalRoles === 0) {
            return [
                'percentage' => 0,
                'covered_roles' => 0,
                'total_roles' => 0,
                'missing_roles' => []
            ];
        }

        // Get existing roles from ecosystem (these are role names, not IDs)
        $existingRoleNames = collect($this->existing_roles ?? [])->toArray();

        // Get member roles from users.assigned_role
        $memberRoles = $this->acceptedUsers()
            ->whereNotNull('assigned_role')
            ->pluck('assigned_role')
            ->toArray();

        // Combine and get unique roles
        $coveredRoles = array_unique(array_merge($existingRoleNames, $memberRoles));
        $coveredRolesCount = count($coveredRoles);

        // Calculate percentage
        $percentage = ($coveredRolesCount / $totalRoles) * 100;

        // Get missing roles - compare with all role names from database
        $allRoleNames = \App\Models\Peran::pluck('nama')->toArray();
        $missingRoles = array_diff($allRoleNames, $coveredRoles);

        return [
            'percentage' => round($percentage, 1),
            'covered_roles' => $coveredRolesCount,
            'total_roles' => $totalRoles,
            'missing_roles' => $missingRoles,
            'existing_roles_count' => count($existingRoleNames),
            'member_roles_count' => count(array_unique($memberRoles)),
        ];
    }

    /**
     * Get roles breakdown for the ecosystem
     */
    public function getRolesBreakdown(): array
    {
        // Get existing roles
        $existingRoleIds = collect($this->existing_roles ?? [])->toArray();
        $existingRoles = \App\Models\Peran::whereIn('id', $existingRoleIds)->get();

        // Get member roles
        $memberRoles = collect();
        $acceptedMembers = $this->acceptedUsers()->with('profile.peran')->get();

        foreach ($acceptedMembers as $member) {
            if ($member->profile && $member->profile->peran) {
                $memberRoles->push($member->profile->peran);
            }
        }

        // Group member roles by role and count users
        $memberRolesCounted = $memberRoles->groupBy('id')->map(function ($roles, $roleId) {
            return [
                'role' => $roles->first(),
                'user_count' => $roles->count()
            ];
        });

        return [
            'existing_roles' => $existingRoles,
            'member_roles' => $memberRolesCounted,
        ];
    }

    /**
     * Get needed roles that are not yet covered
     */
    public function getNeededRolesGap(): array
    {
        $neededRoleIds = collect($this->needed_roles ?? [])->toArray();
        $neededRoles = \App\Models\Peran::whereIn('id', $neededRoleIds)->get();

        // Get covered roles
        $existingRoleIds = collect($this->existing_roles ?? [])->toArray();
        $memberRoleIds = [];

        $acceptedMembers = $this->acceptedUsers()->with('profile.peran')->get();
        foreach ($acceptedMembers as $member) {
            if ($member->profile && $member->profile->peran) {
                $memberRoleIds[] = $member->profile->peran_id;
            }
        }

        $coveredRoleIds = array_unique(array_merge($existingRoleIds, $memberRoleIds));

        // Find gaps
        $gapRoleIds = array_diff($neededRoleIds, $coveredRoleIds);
        $gapRoles = \App\Models\Peran::whereIn('id', $gapRoleIds)->get();

        return [
            'needed_roles' => $neededRoles,
            'gap_roles' => $gapRoles,
            'coverage_percentage' => $neededRoles->count() > 0
                ? round(((count($neededRoleIds) - count($gapRoleIds)) / count($neededRoleIds)) * 100, 1)
                : 100
        ];
    }

    /**
     * Set ecosystem to require all available roles
     * This method will update the ecosystem to need all roles that exist in the system
     */
    public function requireAllRoles(): void
    {
        $allRoleIds = \App\Models\Peran::pluck('id')->toArray();
        $this->update(['needed_roles' => $allRoleIds]);
    }

    /**
     * Check if ecosystem requires all roles
     */
    public function requiresAllRoles(): bool
    {
        $allRoleIds = \App\Models\Peran::pluck('id')->toArray();
        $neededRoleIds = collect($this->needed_roles ?? [])->toArray();

        // Check if needed_roles contains all available roles
        return count(array_diff($allRoleIds, $neededRoleIds)) === 0;
    }

    /**
     * Get roles that are missing from the ecosystem
     * This considers both existing roles and member roles
     */
    public function getMissingRoles(): array
    {
        $allRoleIds = \App\Models\Peran::pluck('id')->toArray();

        // Get covered roles
        $existingRoleIds = collect($this->existing_roles ?? [])->toArray();
        $memberRoleIds = [];

        $acceptedMembers = $this->acceptedUsers()->with('profile.peran')->get();
        foreach ($acceptedMembers as $member) {
            if ($member->profile && $member->profile->peran) {
                $memberRoleIds[] = $member->profile->peran_id;
            }
        }

        $coveredRoleIds = array_unique(array_merge($existingRoleIds, $memberRoleIds));

        // Find missing roles
        $missingRoleIds = array_diff($allRoleIds, $coveredRoleIds);
        $missingRoles = \App\Models\Peran::whereIn('id', $missingRoleIds)->get();

        return [
            'missing_roles' => $missingRoles,
            'missing_count' => count($missingRoleIds),
            'total_roles' => count($allRoleIds),
            'coverage_percentage' => count($allRoleIds) > 0
                ? round((count($coveredRoleIds) / count($allRoleIds)) * 100, 1)
                : 100
        ];
    }

    /**
     * Get collective actions where this ecosystem has been invited
     */
    public function collectiveActionInvitations(): HasMany
    {
        return $this->hasMany(CollectiveActionEcosystemInvitation::class);
    }

    /**
     * Get accepted collective action invitations
     */
    public function acceptedCollectiveActions(): HasMany
    {
        return $this->collectiveActionInvitations()->where('status', 'accepted');
    }

    /**
     * Get pending collective action invitations
     */
    public function pendingCollectiveActionInvitations(): HasMany
    {
        return $this->collectiveActionInvitations()->where('status', 'pending');
    }

    /**
     * Get contributions for this ecosystem
     */
    public function contributions(): HasMany
    {
        return $this->hasMany(EcosystemContribution::class);
    }

    /**
     * Get contributions by contribution type
     */
    public function contributionsByType($contributionId): HasMany
    {
        return $this->contributions()->where('contribution_id', $contributionId);
    }

    /**
     * Get users who have contributed to this ecosystem (via contributions table)
     */
    public function contributors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ecosystem_contributions')
            ->withPivot(['contribution_id', 'contribution_description', 'contribution_amount', 'contribution_details', 'status', 'offered_at', 'accepted_at', 'completed_at', 'admin_notes'])
            ->withTimestamps();
    }

    /**
     * Get accepted contributors
     */
    public function acceptedContributors(): BelongsToMany
    {
        return $this->contributors()->wherePivot('status', 'accepted');
    }

    /**
     * Get pending contributions
     */
    public function pendingContributions(): BelongsToMany
    {
        return $this->contributors()->wherePivot('status', 'offered');
    }

    /**
     * Check if user can contribute to this ecosystem
     */
    public function canUserContribute(User $user): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // Creator can always contribute
        if ($user->id === $this->creator_id) {
            // Check if creator is already a contributor
            if ($this->contributors()->where('users.id', $user->id)->exists()) {
                return false;
            }
            return true;
        }

        // Only accepted users can contribute
        $userStatus = $this->getUserStatus($user);
        if ($userStatus !== 'accepted') {
            return false;
        }

        // Check if user is already a contributor
        if ($this->contributors()->where('users.id', $user->id)->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Scope to filter ecosystems by PasarKolaboraya session
     * Only show ecosystems that belong to the specified session
     */
    public function scopeForPasarKolaboraya($query, $pasarKolaborayaId)
    {
        return $query->where('pasar_kolaboraya_id', $pasarKolaborayaId);
    }

    /**
     * Scope to filter ecosystems by user's active PasarKolaboraya session
     */
    public function scopeForUserActiveSession($query, User $user)
    {
        if (!$user->hasActivePasarKolaboraya()) {
            return $query->whereRaw('1 = 0'); // Return empty result
        }

        return $query->forPasarKolaboraya($user->active_pasar_kolaboraya_id);
    }

    /**
     * Scope for optimized ecosystem listing with minimal data
     */
    public function scopeForListing($query)
    {
        return $query->select([
            'id', 'creator_id', 'ecosystem_title', 'organization_name', 
            'description', 'work_region', 'issues_addressed', 'needed_roles', 
            'is_active', 'created_at', 'updated_at'
        ])
        ->with([
            'creator:id,name,email',
            'acceptedUsers:id,name,assigned_role',
            'likes:id,ecosystem_id,user_id'
        ]);
    }

    /**
     * Scope for ecosystem analytics with optimized queries
     */
    public function scopeForAnalytics($query)
    {
        return $query->with([
            'creator:id,name,email',
            'acceptedUsers:id,name,assigned_role',
            'contributions:id,ecosystem_id,status,contribution_id',
            'likes:id,ecosystem_id,user_id'
        ]);
    }

    /**
     * Scope to get ecosystems with role diversity data
     */
    public function scopeWithRoleDiversity($query)
    {
        return $query->with([
            'acceptedUsers' => function($q) {
                $q->join('profiles', 'users.id', '=', 'profiles.user_id')
                  ->join('peran', 'profiles.peran_id', '=', 'peran.id')
                  ->select('users.id', 'users.name', 'users.assigned_role', 'peran.nama as role_name')
                  ->whereNotNull('profiles.peran_id');
            }
        ]);
    }

    /**
     * Generate QR code URL for ecosystem joining
     */
    public function getQrJoinUrl(): string
    {
        return route('ecosystem.join', $this);
    }

    /**
     * Generate QR code SVG for ecosystem joining
     */
    public function getQrCodeSvg(int $size = 300): string
    {
        $qrUrl = $this->getQrJoinUrl();
        return \SimpleSoftwareIO\QrCode\Facades\QrCode::size($size)
            ->format('svg')
            ->generate($qrUrl);
    }

    /**
     * Check if user can generate QR code (only creator)
     */
    public function canGenerateQr(User $user): bool
    {
        return $user->id === $this->creator_id;
    }

    /**
     * Calculate connection quality metrics for radar chart
     * Based on ecosystem member connections and interactions
     */
    public function getConnectionQualityMetrics(): array
    {
        $acceptedMembers = $this->acceptedUsers()->with(['profile.skills', 'connections'])->get();

        if ($acceptedMembers->isEmpty()) {
            return [
                'jumlah_koneksi' => 0,
                'kualitas_koneksi' => 0,
                'keluasan_jejaring' => 0,
                'keragaman_keahlian' => 0,
                'tingkat_interaksi' => 0,
                'kekuatan_jejaring' => 0
            ];
        }

        // Calculate total connections across all members
        $totalConnections = 0;
        $totalInteractions = 0;
        $allSkills = collect();
        $connectionQualityScores = [];
        $networkBreadth = 0;

        foreach ($acceptedMembers as $member) {
            // Count connections for this member
            $memberConnections = $member->connections()->count();
            $totalConnections += $memberConnections;

            // Collect skills
            if ($member->profile && $member->profile->skills) {
                $allSkills = $allSkills->merge($member->profile->skills->pluck('name'));
            }

            // Calculate connection quality for this member (simplified)
            $memberQuality = min(5, max(1, $memberConnections / 2)); // Scale 1-5
            $connectionQualityScores[] = $memberQuality;

            // Network breadth (unique organizations/regions)
            if ($member->profile) {
                $networkBreadth += 1; // Each member adds to breadth
            }
        }

        // Calculate averages and metrics
        $avgConnections = $totalConnections / $acceptedMembers->count();
        $avgConnectionQuality = count($connectionQualityScores) > 0
            ? array_sum($connectionQualityScores) / count($connectionQualityScores)
            : 0;

        // Network breadth (unique skills diversity)
        $uniqueSkills = $allSkills->unique()->count();
        $skillDiversity = min(5, $uniqueSkills / 5); // Scale to 1-5

        // Interaction level (based on member count and connections)
        $interactionLevel = min(5, ($acceptedMembers->count() + $avgConnections) / 3);

        // Network strength (combination of connections and quality)
        $networkStrength = min(5, ($avgConnections + $avgConnectionQuality) / 2);

        return [
            'jumlah_koneksi' => round($avgConnections, 1),
            'kualitas_koneksi' => round($avgConnectionQuality, 1),
            'keluasan_jejaring' => round($networkBreadth, 1),
            'keragaman_keahlian' => round($skillDiversity, 1),
            'tingkat_interaksi' => round($interactionLevel, 1),
            'kekuatan_jejaring' => round($networkStrength, 1)
        ];
    }

    /**
     * Calculate Pilar I - Koneksi scoring for this ecosystem
     * Based on the new scoring system requirements
     */
    public function calculateKoneksiScore(): array
    {
        $acceptedMembers = $this->acceptedUsers()->get();

        if ($acceptedMembers->isEmpty()) {
            return [
                'accepted_score' => 0,
                'recency_score' => 0,
                'activation_score' => 0,
                'role_fit_score' => 0,
                'koneksi_score' => 0,
                'details' => []
            ];
        }

        // Calculate average scores across all members
        $totalAcceptedScore = 0;
        $totalRecencyScore = 0;
        $totalActivationScore = 0;
        $totalRoleFitScore = 0;
        $memberCount = 0;

        foreach ($acceptedMembers as $member) {
            $memberKoneksiData = Connection::calculateKoneksiScore($member->id, $this->pasar_kolaboraya_id);

            $totalAcceptedScore += $memberKoneksiData['accepted_score'];
            $totalRecencyScore += $memberKoneksiData['recency_score'];
            $totalActivationScore += $memberKoneksiData['activation_score'];
            $totalRoleFitScore += $memberKoneksiData['role_fit_score'];
            $memberCount++;
        }

        // Calculate average scores
        $avgAcceptedScore = $memberCount > 0 ? $totalAcceptedScore / $memberCount : 0;
        $avgRecencyScore = $memberCount > 0 ? $totalRecencyScore / $memberCount : 0;
        $avgActivationScore = $memberCount > 0 ? $totalActivationScore / $memberCount : 0;
        $avgRoleFitScore = $memberCount > 0 ? $totalRoleFitScore / $memberCount : 0;

        // Calculate final Koneksi score
        $koneksiScore = ($avgAcceptedScore + $avgRecencyScore + $avgActivationScore + $avgRoleFitScore) / 4;

        return [
            'accepted_score' => round($avgAcceptedScore, 1),
            'recency_score' => round($avgRecencyScore, 1),
            'activation_score' => round($avgActivationScore, 1),
            'role_fit_score' => round($avgRoleFitScore, 1),
            'koneksi_score' => round($koneksiScore, 1),
            'details' => [
                'member_count' => $memberCount,
                'max_users' => $this->max_users,
                'needed_roles_count' => count($this->needed_roles ?? []),
                'existing_roles_count' => count($this->existing_roles ?? []),
                'coverage_count' => count(array_intersect($this->existing_roles ?? [], $this->needed_roles ?? []))
            ]
        ];
    }

    /**
     * Calculate Pilar II - Ekosistem scoring for this ecosystem
     * Based ONLY on role diversity: peran yang ada / total seluruh peran di database
     */
    public function calculateEkosistemScore(): array
    {
        // Cache total roles count to avoid repeated queries
        $totalRolesInDatabase = \Cache::remember('total_roles_count', 3600, function () {
            return \App\Models\Peran::count();
        });

        if ($totalRolesInDatabase === 0) {
            return [
                'ekosistem_score' => 0,
                'role_diversity_score' => 0,
                'total_ekosistem_score' => 0,
                'details' => [
                    'existing_roles_count' => 0,
                    'total_roles_in_database' => 0,
                    'role_diversity_details' => [],
                    'existing_role_names' => [],
                ]
            ];
        }

        // Get existing roles from ecosystem (already in memory)
        $alreadyExistsRole = collect($this->existing_roles ?? [])->toArray();
        
        // Get role names in single query instead of loop
        $existingRoleNames = \App\Models\Peran::whereIn('id', $alreadyExistsRole)
            ->pluck('nama')
            ->toArray();

        // Get member assigned roles in single query
        $memberRoles = $this->acceptedUsers()
            ->whereNotNull('assigned_role')
            ->pluck('assigned_role')
            ->toArray();

        $totalAlreadyExistsRole = array_merge($memberRoles, $existingRoleNames);

        $exclude = ['Ecosystem Builder', 'Tamu', 'Komunitas'];

        $uniqueExistingRoles = array_values(array_unique(
            array_diff($memberRoles, $exclude)
        ));

        $uniqueTotalAlreadyExistsRoles = array_values(array_unique(array_diff($totalAlreadyExistsRole, $exclude)));

        $alreadyExistsRolesCount = count($uniqueTotalAlreadyExistsRoles);
        $existingRolesCount = count($uniqueExistingRoles);

        // Calculate ecosystem quality score: peran yang ada / total seluruh peran di database
        $ekosistemScore = ($existingRolesCount / $totalRolesInDatabase) * 100;
        $totalEkosistemScore = ($alreadyExistsRolesCount / $totalRolesInDatabase) * 100;

        return [
            'ekosistem_score' => round($ekosistemScore, 1),
            'role_diversity_score' => round($ekosistemScore, 1),
            'total_ekosistem_score' => round($totalEkosistemScore, 1),
            'details' => [
                'existing_roles_count' => $existingRolesCount,
                'total_roles_in_database' => $totalRolesInDatabase,
                'role_diversity_details' => $this->getRoleDiversityDetails(),
                'existing_role_names' => $existingRoleNames,
            ]
        ];
    }

    /**
     * Get names of existing roles in the ecosystem
     */
    public function getExistingRoleNames($roleIds): array
    {
        if (empty($roleIds)) {
            return [];
        }

        return \App\Models\Peran::whereIn('id', $roleIds)
            ->pluck('nama')
            ->toArray();
    }

    /**
     * Get detailed information about role diversity
     */
    public function getRoleDiversityDetails(): array
    {
        // Use raw query with users.assigned_role instead of profiles.peran_id
        $roleDistribution = \DB::table('ecosystem_users')
            ->join('users', 'ecosystem_users.user_id', '=', 'users.id')
            ->where('ecosystem_users.ecosystem_id', $this->id)
            ->where('ecosystem_users.status', 'accepted')
            ->whereNull('users.deleted_at')
            ->whereNotNull('users.assigned_role')
            ->selectRaw('users.assigned_role as role_name, COUNT(*) as count')
            ->groupBy('users.assigned_role')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->role_name,
                    'count' => $item->count,
                    'percentage' => 0 // Will be calculated below
                ];
            })
            ->keyBy('role_name')
            ->toArray();

        $totalMembers = $this->acceptedUsers()->count();
        $membersWithoutRoles = $this->acceptedUsers()
            ->whereNull('assigned_role')
            ->count();

        // Calculate percentages
        foreach ($roleDistribution as $roleName => &$data) {
            $data['percentage'] = $totalMembers > 0 ? round(($data['count'] / $totalMembers) * 100, 1) : 0;
        }

        return [
            'total_members' => $totalMembers,
            'unique_roles' => count($roleDistribution),
            'role_distribution' => array_values($roleDistribution),
            'members_without_roles' => $membersWithoutRoles
        ];
    }

    /**
     * Get analytics data for charts
     */
    public function getEcosystemAnalytics(): array
    {
        // Contribution types distribution
        $contributionTypes = [
            'volunteer' => $this->contributions()->whereHas('contribution', function($query) {
                $query->where('name', 'like', '%relawan%')->orWhere('name', 'like', '%volunteer%');
            })->count(),
            'funding' => $this->contributions()->whereHas('contribution', function($query) {
                $query->where('name', 'like', '%dana%')->orWhere('name', 'like', '%funding%');
            })->count(),
            'expertise' => $this->contributions()->whereHas('contribution', function($query) {
                $query->where('name', 'like', '%keahlian%')->orWhere('name', 'like', '%expertise%');
            })->count(),
            'resources' => $this->contributions()->whereHas('contribution', function($query) {
                $query->where('name', 'like', '%sumber%')->orWhere('name', 'like', '%resource%');
            })->count(),
            'promotion' => $this->contributions()->whereHas('contribution', function($query) {
                $query->where('name', 'like', '%promosi%')->orWhere('name', 'like', '%promotion%');
            })->count(),
            'other' => $this->contributions()->whereHas('contribution', function($query) {
                $query->whereNotIn('name', ['Relawan', 'Dana', 'Keahlian', 'Sumber Daya', 'Promosi']);
            })->count(),
        ];

        // Contribution status distribution
        $contributionStatus = [
            'offered' => $this->contributions()->where('status', 'offered')->count(),
            'accepted' => $this->contributions()->where('status', 'accepted')->count(),
            'completed' => $this->contributions()->where('status', 'completed')->count(),
            'declined' => $this->contributions()->where('status', 'declined')->count(),
        ];

        // Member status distribution
        $memberStatus = [
            'accepted' => $this->acceptedUsers()->count(),
            'pending' => $this->pendingUsers()->count(),
        ];

        // Role diversity (from existing method)
        $roleDiversity = $this->getRoleDiversityDetails();

        return [
            'contribution_types' => $contributionTypes,
            'contribution_status' => $contributionStatus,
            'member_status' => $memberStatus,
            'role_diversity' => $roleDiversity,
            'total_contributions' => $this->contributions()->count(),
            'total_members' => $this->users()->count(),
            'ecosystem_quality' => $this->calculateEkosistemScore(),
        ];
    }

    /**
     * Get likes for this ecosystem
     */
    public function likes(): HasMany
    {
        return $this->hasMany(EcosystemLike::class);
    }

    /**
     * Get users who liked this ecosystem
     */
    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'ecosystem_likes');
    }

    /**
     * Check if user has liked this ecosystem
     */
    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Get like count for this ecosystem
     */
    public function getLikeCountAttribute(): int
    {
        return $this->likes()->count();
    }
}
