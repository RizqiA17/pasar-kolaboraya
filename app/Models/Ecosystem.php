<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * Calculate ecosystem quality based on skills coverage
     * Formula: (existing skills + member skills) / total available skills
     */
    public function calculateQuality(): array
    {
        // Get all available skills
        $allSkills = \App\Models\Skill::pluck('id')->toArray();
        $totalSkills = count($allSkills);

        if ($totalSkills === 0) {
            return [
                'percentage' => 0,
                'covered_skills' => 0,
                'total_skills' => 0,
                'missing_skills' => []
            ];
        }

        // Get existing skills from ecosystem
        $existingSkillIds = collect($this->existing_roles ?? [])->toArray();

        // Get skills from accepted members
        $memberSkillIds = [];
        $acceptedMembers = $this->acceptedUsers()->with('profile.skills')->get();
        
        foreach ($acceptedMembers as $member) {
            if ($member->profile) {
                $memberSkills = $member->profile->skills->pluck('id')->toArray();
                $memberSkillIds = array_merge($memberSkillIds, $memberSkills);
            }
        }

        // Combine and get unique skills
        $coveredSkillIds = array_unique(array_merge($existingSkillIds, $memberSkillIds));
        $coveredSkillsCount = count($coveredSkillIds);

        // Calculate percentage
        $percentage = ($coveredSkillsCount / $totalSkills) * 100;

        // Get missing skills
        $missingSkillIds = array_diff($allSkills, $coveredSkillIds);
        $missingSkills = \App\Models\Skill::whereIn('id', $missingSkillIds)->pluck('name')->toArray();

        return [
            'percentage' => round($percentage, 1),
            'covered_skills' => $coveredSkillsCount,
            'total_skills' => $totalSkills,
            'missing_skills' => $missingSkills,
            'existing_skills_count' => count($existingSkillIds),
            'member_skills_count' => count(array_unique($memberSkillIds)),
        ];
    }

    /**
     * Get skills breakdown for the ecosystem
     */
    public function getSkillsBreakdown(): array
    {
        // Get existing skills
        $existingSkillIds = collect($this->existing_roles ?? [])->toArray();
        $existingSkills = \App\Models\Skill::whereIn('id', $existingSkillIds)->get();

        // Get member skills
        $memberSkills = collect();
        $acceptedMembers = $this->acceptedUsers()->with('profile.skills')->get();
        
        foreach ($acceptedMembers as $member) {
            if ($member->profile) {
                $memberSkills = $memberSkills->merge($member->profile->skills);
            }
        }

        // Group member skills by skill and count users
        $memberSkillsCounted = $memberSkills->groupBy('id')->map(function ($skills, $skillId) {
            return [
                'skill' => $skills->first(),
                'user_count' => $skills->count()
            ];
        });

        return [
            'existing_skills' => $existingSkills,
            'member_skills' => $memberSkillsCounted,
        ];
    }

    /**
     * Get needed skills that are not yet covered
     */
    public function getNeededSkillsGap(): array
    {
        $neededSkillIds = collect($this->needed_roles ?? [])->toArray();
        $neededSkills = \App\Models\Skill::whereIn('id', $neededSkillIds)->get();

        // Get covered skills
        $existingSkillIds = collect($this->existing_roles ?? [])->toArray();
        $memberSkillIds = [];
        
        $acceptedMembers = $this->acceptedUsers()->with('profile.skills')->get();
        foreach ($acceptedMembers as $member) {
            if ($member->profile) {
                $memberSkills = $member->profile->skills->pluck('id')->toArray();
                $memberSkillIds = array_merge($memberSkillIds, $memberSkills);
            }
        }

        $coveredSkillIds = array_unique(array_merge($existingSkillIds, $memberSkillIds));

        // Find gaps
        $gapSkillIds = array_diff($neededSkillIds, $coveredSkillIds);
        $gapSkills = \App\Models\Skill::whereIn('id', $gapSkillIds)->get();

        return [
            'needed_skills' => $neededSkills,
            'gap_skills' => $gapSkills,
            'coverage_percentage' => $neededSkills->count() > 0 
                ? round(((count($neededSkillIds) - count($gapSkillIds)) / count($neededSkillIds)) * 100, 1)
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
     * Generate QR code URL for ecosystem joining
     */
    public function getQrJoinUrl(): string
    {
        return route('ecosystem.qr.join', $this->id);
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
     * Based on the new scoring system requirements
     */
    public function calculateEkosistemScore(): array
    {
        // 1. Membership Activation Rate
        $accepted = $this->acceptedUsers()->count();
        $maxUsers = $this->max_users ?? 1; // Prevent division by zero
        $activationRate = $accepted / $maxUsers;
        $activationScore = min($activationRate, 1) * 100;

        // 2. Ecosystem Acceptance Rate
        $rejected = $this->users()->wherePivot('status', 'rejected')->count();
        $totalDecisions = $accepted + $rejected;
        $acceptanceRate = $totalDecisions > 0 ? $accepted / $totalDecisions : 0;
        $acceptanceScore = $acceptanceRate * 100;

        // 3. Ecosystem Contribution Completion Rate
        $completed = $this->contributions()->where('status', 'completed')->count();
        $totalContributions = $this->contributions()->count();
        $completionRate = $totalContributions > 0 ? $completed / $totalContributions : 0;
        $completionScore = $completionRate * 100;

        // 4. Ecosystem Contribution Diversity (HHI calculation)
        $contributionTypes = $this->contributions()
            ->join('contributions', 'ecosystem_contributions.contribution_id', '=', 'contributions.id')
            ->selectRaw('contributions.category, COUNT(*) as count')
            ->groupBy('contributions.category')
            ->get();

        $totalContributionCount = $contributionTypes->sum('count');
        $hhi = 0;
        $uniqueTypes = $contributionTypes->count();

        if ($totalContributionCount > 0) {
            foreach ($contributionTypes as $type) {
                $proportion = $type->count / $totalContributionCount;
                $hhi += pow($proportion, 2);
            }
        }

        $diversityScore = $uniqueTypes > 1 ? (1 - $hhi) / (1 - 1 / $uniqueTypes) * 100 : 0;

        // 5. Role Fit (Kesesuaian Kebutuhan Skill)
        $existingRoles = collect($this->existing_roles ?? []);
        $neededRoles = collect($this->needed_roles ?? []);
        $coverage = $neededRoles->count() > 0 
            ? $existingRoles->intersect($neededRoles)->count() / $neededRoles->count() 
            : 0;
        $roleFitScore = $coverage * 100;

        // 6. Ecosystem Engagement in Collective Actions
        $invited = $this->collectiveActionInvitations()->count();
        $acceptedInvitations = $this->collectiveActionInvitations()->where('status', 'accepted')->count();
        $engagementRate = $invited > 0 ? $acceptedInvitations / $invited : 0;
        $engagementScore = $engagementRate * 100;

        // Calculate final Ekosistem score as average of all 6 metrics
        $ekosistemScore = (
            $activationScore + 
            $acceptanceScore + 
            $completionScore + 
            $diversityScore + 
            $roleFitScore + 
            $engagementScore
        ) / 6;

        return [
            'activation_score' => round($activationScore, 1),
            'acceptance_score' => round($acceptanceScore, 1),
            'completion_score' => round($completionScore, 1),
            'diversity_score' => round($diversityScore, 1),
            'role_fit_score' => round($roleFitScore, 1),
            'engagement_score' => round($engagementScore, 1),
            'ekosistem_score' => round($ekosistemScore, 1),
            'details' => [
                'accepted_members' => $accepted,
                'max_users' => $maxUsers,
                'rejected_members' => $rejected,
                'total_decisions' => $totalDecisions,
                'completed_contributions' => $completed,
                'total_contributions' => $totalContributions,
                'contribution_types_count' => $uniqueTypes,
                'hhi_value' => round($hhi, 4),
                'existing_roles_count' => $existingRoles->count(),
                'needed_roles_count' => $neededRoles->count(),
                'role_coverage_count' => $existingRoles->intersect($neededRoles)->count(),
                'invited_to_actions' => $invited,
                'accepted_invitations' => $acceptedInvitations
            ]
        ];
    }
}
