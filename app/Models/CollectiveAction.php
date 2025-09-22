<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CollectiveAction extends Model
{
    protected $fillable = [
        'title',
        'description',
        'scale',
        'scope',
        'goals',
        'required_resources',
        'created_by',
        'pasar_kolaboraya_id',
        'start_date',
        'end_date',
        'location',
        'latitude',
        'longitude',
        'status',
        'min_ecosystems',
        'collaboration_terms',
        'qr_code',
    ];

    protected $casts = [
        'required_resources' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the creator of this collective action
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the Pasar Kolaboraya session this collective action belongs to
     */
    public function pasarKolaboraya(): BelongsTo
    {
        return $this->belongsTo(PasarKolaboraya::class, 'pasar_kolaboraya_id');
    }

    /**
     * Get invitations sent for this collective action
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(CollectiveActionEcosystemInvitation::class);
    }

    /**
     * Get accepted invitations
     */
    public function acceptedInvitations(): HasMany
    {
        return $this->invitations()->where('status', 'accepted');
    }

    /**
     * Get pending invitations
     */
    public function pendingInvitations(): HasMany
    {
        return $this->invitations()->where('status', 'pending');
    }

    /**
     * Get the ecosystems participating in this action (via accepted invitations)
     */
    public function participatingEcosystems()
    {
        return $this->hasManyThrough(
            Ecosystem::class,
            CollectiveActionEcosystemInvitation::class,
            'collective_action_id',
            'id',
            'id',
            'ecosystem_id'
        )->where('collective_action_ecosystem_invitations.status', 'accepted');
    }

    /**
     * Get participating ecosystems as a collection
     */
    public function getParticipatingEcosystemsAttribute()
    {
        return $this->participatingEcosystems()->get();
    }

    /**
     * Check if ecosystem is invited to this action
     */
    public function hasInvitedEcosystem($ecosystemId): bool
    {
        return $this->invitations()->where('ecosystem_id', $ecosystemId)->exists();
    }

    /**
     * Get invitation status for ecosystem
     */
    public function getEcosystemInvitationStatus($ecosystemId): ?string
    {
        $invitation = $this->invitations()->where('ecosystem_id', $ecosystemId)->first();
        return $invitation ? $invitation->status : null;
    }

    /**
     * Get contributions for this collective action
     */
    public function contributions(): HasMany
    {
        return $this->hasMany(CollectiveActionContribution::class);
    }

    /**
     * Get offered contributions
     */
    public function offeredContributions(): HasMany
    {
        return $this->contributions()->where('status', 'offered');
    }

    /**
     * Get accepted contributions
     */
    public function acceptedContributions(): HasMany
    {
        return $this->contributions()->where('status', 'accepted');
    }

    /**
     * Get completed contributions
     */
    public function completedContributions(): HasMany
    {
        return $this->contributions()->where('status', 'completed');
    }

    /**
     * Get declined contributions
     */
    public function declinedContributions(): HasMany
    {
        return $this->contributions()->where('status', 'declined');
    }

    /**
     * Get funding contributions
     */
    public function fundingContributions(): HasMany
    {
        return $this->contributions()->whereHas('contribution', function($q) {
            $q->where('name', 'like', '%funding%')->orWhere('name', 'like', '%dana%');
        });
    }

    /**
     * Get volunteer contributions
     */
    public function volunteerContributions(): HasMany
    {
        return $this->contributions()->whereHas('contribution', function($q) {
            $q->where('name', 'like', '%volunteer%')->orWhere('name', 'like', '%relawan%');
        });
    }

    /**
     * Get expertise contributions
     */
    public function expertiseContributions(): HasMany
    {
        return $this->contributions()->whereHas('contribution', function($q) {
            $q->where('name', 'like', '%expertise%')->orWhere('name', 'like', '%keahlian%');
        });
    }

    /**
     * Get resource contributions
     */
    public function resourceContributions(): HasMany
    {
        return $this->contributions()->whereHas('contribution', function($q) {
            $q->where('name', 'like', '%resource%')->orWhere('name', 'like', '%sumber daya%');
        });
    }

    /**
     * Get promotion contributions
     */
    public function promotionContributions(): HasMany
    {
        return $this->contributions()->whereHas('contribution', function($q) {
            $q->where('name', 'like', '%promotion%')->orWhere('name', 'like', '%promosi%');
        });
    }

    /**
     * Get other contributions
     */
    public function otherContributions(): HasMany
    {
        return $this->contributions()->whereHas('contribution', function($q) {
            $q->where('name', 'like', '%other%')->orWhere('name', 'like', '%lainnya%');
        });
    }

    /**
     * Get users who have contributed to this action (via contributions table)
     */
    public function contributors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'collective_action_contributions')
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
     * Check if user can contribute to this action
     */
    public function canUserContribute(User $user): bool
    {
        if ($this->status !== 'active' && $this->status !== 'planning') {
            return false;
        }

        // Only joined users (members, contributors, admins) can contribute
        if (!$this->isUserMember($user) && !$this->isUserAdmin($user) && !$this->isUserContributor($user)) {
            return false;
        }

        // Check if user has any pending or accepted contributions
        if ($this->contributions()->where('user_id', $user->id)
            ->whereIn('status', ['offered', 'accepted'])
            ->exists()) {
            return false;
        }

        return true;
    }

    /**
     * Check if minimum ecosystems requirement is met
     */
    public function hasMinimumEcosystems(): bool
    {
        return $this->acceptedInvitations()->count() >= $this->min_ecosystems;
    }

    /**
     * Check if this collective action includes a specific ecosystem
     */
    public function includesEcosystem(int $ecosystemId): bool
    {
        // Check if ecosystem has accepted invitation
        if ($this->acceptedInvitations()
            ->where('ecosystem_id', $ecosystemId)
            ->exists()) {
            return true;
        }
        
        // Check if ecosystem creator is a member of this collective action
        $ecosystem = Ecosystem::find($ecosystemId);
        if ($ecosystem && $this->users()->where('users.id', $ecosystem->creator_id)->exists()) {
            return true;
        }
        
        return false;
    }

    /**
     * Scope to filter collective actions by ecosystem ID
     */
    public function scopeForEcosystem($query, int $ecosystemId)
    {
        return $query->where(function ($q) use ($ecosystemId) {
            $q->whereHas('acceptedInvitations', function ($subQuery) use ($ecosystemId) {
                  $subQuery->where('ecosystem_id', $ecosystemId);
              })
              ->orWhereHas('users', function ($subQuery) use ($ecosystemId) {
                  $ecosystem = Ecosystem::find($ecosystemId);
                  if ($ecosystem) {
                      $subQuery->where('users.id', $ecosystem->creator_id);
                  }
              });
        });
    }

    /**
     * Scope to filter collective actions by multiple ecosystem IDs
     */
    public function scopeForEcosystems($query, array $ecosystemIds)
    {
        return $query->where(function ($q) use ($ecosystemIds) {
            $q->whereHas('acceptedInvitations', function ($subQuery) use ($ecosystemIds) {
                  $subQuery->whereIn('ecosystem_id', $ecosystemIds);
              })
              ->orWhereHas('users', function ($subQuery) use ($ecosystemIds) {
                  $ecosystems = Ecosystem::whereIn('id', $ecosystemIds)->get();
                  $creatorIds = $ecosystems->pluck('creator_id')->toArray();
                  $subQuery->whereIn('users.id', $creatorIds);
              });
        });
    }

    /**
     * Scope to filter collective actions by PasarKolaboraya session
     * Only show collective actions that belong to the specified session
     */
    public function scopeForPasarKolaboraya($query, $pasarKolaborayaId)
    {
        return $query->where('pasar_kolaboraya_id', $pasarKolaborayaId);
    }

    /**
     * Scope to filter collective actions by user's active PasarKolaboraya session
     */
    public function scopeForUserActiveSession($query, User $user)
    {
        if (!$user->hasActivePasarKolaboraya()) {
            return $query->whereRaw('1 = 0'); // Return empty result
        }
        
        return $query->forPasarKolaboraya($user->active_pasar_kolaboraya_id);
    }

    /**
     * Get scale label
     */
    public function getScaleLabelAttribute(): string
    {
        return match($this->scale) {
            'kecil' => 'Aksi Kecil',
            'sedang' => 'Aksi Sedang',
            'besar' => 'Aksi Besar',
            default => ucfirst($this->scale),
        };
    }

    /**
     * Get scope label
     */
    public function getScopeLabelAttribute(): string
    {
        return match($this->scope) {
            'local' => 'Lokal',
            'national' => 'Nasional',
            'international' => 'Internasional',
            default => ucfirst($this->scope),
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'planning' => 'Perencanaan',
            'active' => 'Aktif',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get all users of this collective action
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'collective_action_users')
            ->withPivot(['ecosystem_id', 'role', 'status', 'join_type', 'join_reason', 'joined_at'])
            ->withTimestamps();
    }

    /**
     * Get admin users
     */
    public function adminUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'admin');
    }

    /**
     * Get member users
     */
    public function memberUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'member');
    }

    /**
     * Get contributor users
     */
    public function contributorUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'contributor');
    }

    /**
     * Get active users
     */
    public function activeUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('status', 'active');
    }

    /**
     * Get pending users
     */
    public function pendingUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('status', 'pending');
    }

    /**
     * Get users pending approval (non-ecosystem users)
     */
    public function pendingApprovalUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('status', 'pending_approval');
    }

    /**
     * Get rejected users
     */
    public function rejectedUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('status', 'rejected');
    }

    /**
     * Get users who joined through ecosystem
     */
    public function ecosystemUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('join_type', 'ecosystem');
    }

    /**
     * Get users who joined directly
     */
    public function directUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('join_type', 'direct');
    }

    /**
     * Check if user is an admin of this collective action
     */
    public function isUserAdmin(User $user): bool
    {
        return $this->adminUsers()->where('users.id', $user->id)->wherePivot('status', 'active')->exists();
    }

    /**
     * Check if user is a member of this collective action
     */
    public function isUserMember(User $user): bool
    {
        return $this->memberUsers()->where('users.id', $user->id)->wherePivot('status', 'active')->exists();
    }

    /**
     * Check if user is a contributor of this collective action
     */
    public function isUserContributor(User $user): bool
    {
        return $this->contributorUsers()->where('users.id', $user->id)->wherePivot('status', 'active')->exists();
    }

    /**
     * Check if user can manage this collective action
     */
    public function canUserManage(User $user): bool
    {
        // Creator is always admin
        if ($this->created_by === $user->id) {
            return true;
        }

        // Check if user is admin
        return $this->isUserAdmin($user);
    }

    /**
     * Check if user is registered in this collective action (any status)
     */
    public function isUserRegistered(User $user): bool
    {
        return $this->users()->where('users.id', $user->id)->exists();
    }

    /**
     * Get user status in this collective action
     */
    public function getUserStatus(User $user): ?string
    {
        $pivotData = $this->users()->where('users.id', $user->id)->first();
        return $pivotData ? $pivotData->pivot->status : null;
    }

    /**
     * Check if user can join this collective action
     */
    public function canUserJoin(User $user): bool
    {
        // Check if user is already registered (any status)
        if ($this->isUserRegistered($user)) {
            return false;
        }

        // Check if action is open for joining
        return in_array($this->status, ['planning', 'active']);
    }

    /**
     * Add ecosystem members as collective action users
     */
    public function addEcosystemMembers(Ecosystem $ecosystem, string $role = 'member'): void
    {
        // Get all ecosystem members including the creator
        $ecosystemMembers = $ecosystem->acceptedUsers()->get();
        
        // Also include the ecosystem creator if not already in the list
        $creator = $ecosystem->creator;
        if ($creator && !$ecosystemMembers->contains('id', $creator->id)) {
            $ecosystemMembers->push($creator);
        }
        
        foreach ($ecosystemMembers as $member) {
            // Check if user is already a member
            if (!$this->isUserMember($member) && !$this->isUserAdmin($member) && !$this->isUserContributor($member)) {
                // Determine status based on ecosystem auto-join setting
                $status = $ecosystem->auto_join_collective_actions ? 'active' : 'pending_approval';
                
                $this->users()->attach($member->id, [
                    'ecosystem_id' => $ecosystem->id,
                    'role' => $role,
                    'status' => $status,
                    'join_type' => 'ecosystem',
                    'join_reason' => 'Joined through ecosystem invitation',
                    'joined_at' => $ecosystem->auto_join_collective_actions ? now() : null,
                    'approval_requested_at' => $ecosystem->auto_join_collective_actions ? null : now(),
                ]);
            }
        }
    }

    /**
     * Add user directly to collective action
     */
    public function addUser(User $user, string $role = 'member', string $joinReason = null, int $ecosystemId = null): void
    {
        if (!$this->isUserMember($user) && !$this->isUserAdmin($user) && !$this->isUserContributor($user)) {
            // Check if user is part of any participating ecosystem
            $isEcosystemMember = false;
            if ($ecosystemId) {
                $ecosystem = Ecosystem::find($ecosystemId);
                $isEcosystemMember = $ecosystem && $ecosystem->acceptedUsers()->where('users.id', $user->id)->exists();
            }
            
            // If user is not in an ecosystem, they need approval for direct join
            $status = $isEcosystemMember ? 'active' : 'pending_approval';
            
            $this->users()->attach($user->id, [
                'ecosystem_id' => $ecosystemId,
                'role' => $role,
                'status' => $status,
                'join_type' => $ecosystemId ? 'ecosystem' : 'direct',
                'join_reason' => $joinReason,
                'joined_at' => $status === 'active' ? now() : null,
                'approval_requested_at' => $status === 'pending_approval' ? now() : null,
            ]);
        }
    }

    /**
     * Remove user from collective action
     */
    public function removeUser(User $user): void
    {
        $this->users()->detach($user->id);
    }

    /**
     * Update user role in collective action
     */
    public function updateUserRole(User $user, string $role): void
    {
        $this->users()->updateExistingPivot($user->id, [
            'role' => $role
        ]);
    }

    /**
     * Update user status in collective action
     */
    public function updateUserStatus(User $user, string $status): void
    {
        $this->users()->updateExistingPivot($user->id, [
            'status' => $status
        ]);
    }

    /**
     * Approve user join request
     */
    public function approveUser(User $user, User $approver, string $adminNotes = null): bool
    {
        $pivotData = $this->users()->where('users.id', $user->id)->first();
        if (!$pivotData || $pivotData->pivot->status !== 'pending_approval') {
            return false;
        }

        $this->users()->updateExistingPivot($user->id, [
            'status' => 'active',
            'joined_at' => now(),
            'approved_at' => now(),
            'approved_by' => $approver->id,
            'admin_notes' => $adminNotes,
        ]);

        return true;
    }

    /**
     * Reject user join request
     */
    public function rejectUser(User $user, User $approver, string $adminNotes = null): bool
    {
        $pivotData = $this->users()->where('users.id', $user->id)->first();
        if (!$pivotData || $pivotData->pivot->status !== 'pending_approval') {
            return false;
        }

        $this->users()->updateExistingPivot($user->id, [
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => $approver->id,
            'admin_notes' => $adminNotes,
        ]);

        return true;
    }

    /**
     * Remove ecosystem members from collective action
     */
    public function removeEcosystemMembers(Ecosystem $ecosystem): void
    {
        $this->users()->wherePivot('ecosystem_id', $ecosystem->id)->detach();
    }

    /**
     * Create a new contribution
     */
    public function createContribution(User $user, array $contributionData): CollectiveActionContribution
    {
        $contributionData['user_id'] = $user->id;
        $contributionData['offered_at'] = now();
        
        return $this->contributions()->create($contributionData);
    }

    /**
     * Accept a contribution
     */
    public function acceptContribution(int $contributionId, string $adminNotes = null): bool
    {
        $contribution = $this->contributions()->find($contributionId);
        
        if (!$contribution || $contribution->status !== 'offered') {
            return false;
        }

        $contribution->update([
            'status' => 'accepted',
            'accepted_at' => now(),
            'admin_notes' => $adminNotes,
        ]);

        return true;
    }

    /**
     * Decline a contribution
     */
    public function declineContribution(int $contributionId, string $adminNotes = null): bool
    {
        $contribution = $this->contributions()->find($contributionId);
        
        if (!$contribution || $contribution->status !== 'offered') {
            return false;
        }

        $contribution->update([
            'status' => 'declined',
            'admin_notes' => $adminNotes,
        ]);

        return true;
    }

    /**
     * Mark a contribution as completed
     */
    public function completeContribution(int $contributionId, string $adminNotes = null): bool
    {
        $contribution = $this->contributions()->find($contributionId);
        
        if (!$contribution || $contribution->status !== 'accepted') {
            return false;
        }

        $contribution->update([
            'status' => 'completed',
            'completed_at' => now(),
            'admin_notes' => $adminNotes,
        ]);

        return true;
    }

    /**
     * Get total funding amount from accepted contributions
     */
    public function getTotalFundingAttribute(): float
    {
        return $this->fundingContributions()
            ->where('status', 'accepted')
            ->sum('contribution_amount') ?? 0;
    }

    /**
     * Get contribution statistics
     */
    public function getContributionStatsAttribute(): array
    {
        return [
            'total_offered' => $this->contributions()->offered()->count(),
            'total_accepted' => $this->contributions()->accepted()->count(),
            'total_completed' => $this->contributions()->completed()->count(),
            'total_declined' => $this->contributions()->declined()->count(),
            'total_funding' => $this->getTotalFundingAttribute(),
            'by_type' => [
                'volunteer' => $this->volunteerContributions()->accepted()->count(),
                'funding' => $this->fundingContributions()->accepted()->count(),
                'expertise' => $this->expertiseContributions()->accepted()->count(),
                'resources' => $this->resourceContributions()->accepted()->count(),
                'promotion' => $this->promotionContributions()->accepted()->count(),
                'other' => $this->otherContributions()->accepted()->count(),
            ],
        ];
    }

    /**
     * Calculate Aksi Score (Pilar III — Aksi Kolektif)
     * Returns array with 6 metrics and overall score
     */
    public function calculateAksiScore(): array
    {
        // 1. Action Activity Rate
        // For single action: 1 if active or completed, 0 otherwise
        $isActive = $this->status === 'active' ? 1 : 0;
        $isCompleted = $this->status === 'completed' ? 1 : 0;
        $activityScore = ($isActive + $isCompleted) * 100;

        // 2. Scale & Scope Impact
        $scaleWeights = ['kecil' => 1, 'sedang' => 2, 'besar' => 3];
        $scopeWeights = ['local' => 1, 'national' => 2, 'international' => 3];
        
        $scaleWeight = $scaleWeights[$this->scale] ?? 1;
        $scopeWeight = $scopeWeights[$this->scope] ?? 1;
        $impactValue = $scaleWeight * $scopeWeight;
        
        // For single action, impact_raw = impact_value
        $impactRaw = $impactValue;
        $impactRef = 300; // Reference maximum value
        $impactScore = min($impactRaw / $impactRef, 1) * 100;

        // 3. Action Participation Rate (Users)
        $participants = $this->activeUsers()->count();
        $totalRegistered = $this->users()->count();
        $participationRate = $totalRegistered > 0 ? $participants / $totalRegistered : 0;
        $participationScore = $participationRate * 100;

        // 4. Action Ecosystem Engagement
        $accepted = $this->acceptedInvitations()->count();
        $invited = $this->invitations()->count();
        $engagementRate = $invited > 0 ? $accepted / $invited : 0;
        $engagementScore = $engagementRate * 100;

        // 5. Action Contribution Completion Rate
        $completedContributions = $this->completedContributions()->count();
        $totalContributions = $this->contributions()->count();
        $completionRate = $totalContributions > 0 ? $completedContributions / $totalContributions : 0;
        $completionScore = $completionRate * 100;

        // 6. Action Contribution Diversity
        $contributionTypes = $this->contributions()
            ->join('contributions', 'collective_action_contributions.contribution_id', '=', 'contributions.id')
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

        // Calculate final Aksi score as average of all 6 metrics
        $aksiScore = (
            $activityScore + 
            $impactScore + 
            $participationScore + 
            $engagementScore + 
            $completionScore + 
            $diversityScore
        ) / 6;

        return [
            'activity_score' => round($activityScore, 1),
            'impact_score' => round($impactScore, 1),
            'participation_score' => round($participationScore, 1),
            'engagement_score' => round($engagementScore, 1),
            'completion_score' => round($completionScore, 1),
            'diversity_score' => round($diversityScore, 1),
            'aksi_score' => round($aksiScore, 1),
            'details' => [
                'is_active' => $isActive,
                'is_completed' => $isCompleted,
                'action_status' => $this->status,
                'scale_weight' => $scaleWeight,
                'scope_weight' => $scopeWeight,
                'impact_value' => $impactValue,
                'impact_raw' => $impactRaw,
                'impact_ref' => $impactRef,
                'active_participants' => $participants,
                'total_registered' => $totalRegistered,
                'accepted_ecosystems' => $accepted,
                'invited_ecosystems' => $invited,
                'completed_contributions' => $completedContributions,
                'total_contributions' => $totalContributions,
                'contribution_types_count' => $uniqueTypes,
                'hhi_value' => round($hhi, 4)
            ]
        ];
    }

    /**
     * Get analytics data for charts
     */
    public function getCollectiveActionsAnalytics(): array
    {
        // Status distribution
        $statusDistribution = [
            'active' => $this->status === 'active' ? 1 : 0,
            'completed' => $this->status === 'completed' ? 1 : 0,
            'cancelled' => $this->status === 'cancelled' ? 1 : 0,
            'draft' => $this->status === 'draft' ? 1 : 0,
        ];

        // Scale distribution
        $scaleDistribution = [
            'kecil' => $this->scale === 'kecil' ? 1 : 0,
            'sedang' => $this->scale === 'sedang' ? 1 : 0,
            'besar' => $this->scale === 'besar' ? 1 : 0,
        ];

        // Contribution types distribution
        $contributionTypes = [
            'volunteer' => $this->volunteerContributions()->count(),
            'funding' => $this->fundingContributions()->count(),
            'expertise' => $this->expertiseContributions()->count(),
            'resources' => $this->resourceContributions()->count(),
            'promotion' => $this->promotionContributions()->count(),
            'other' => $this->otherContributions()->count(),
        ];

        // Contribution status distribution
        $contributionStatus = [
            'offered' => $this->offeredContributions()->count(),
            'accepted' => $this->acceptedContributions()->count(),
            'completed' => $this->completedContributions()->count(),
            'declined' => $this->declinedContributions()->count(),
        ];

        // Member roles distribution
        $memberRoles = [
            'admin' => $this->adminUsers()->count(),
            'member' => $this->memberUsers()->count(),
            'contributor' => $this->contributorUsers()->count(),
        ];

        // Ecosystem participation
        $ecosystemParticipation = [
            'total_invited' => $this->invitations()->count(),
            'accepted' => $this->acceptedInvitations()->count(),
            'pending' => $this->pendingInvitations()->count(),
        ];

        return [
            'status_distribution' => $statusDistribution,
            'scale_distribution' => $scaleDistribution,
            'contribution_types' => $contributionTypes,
            'contribution_status' => $contributionStatus,
            'member_roles' => $memberRoles,
            'ecosystem_participation' => $ecosystemParticipation,
            'total_contributions' => $this->contributions()->count(),
            'total_funding' => $this->getTotalFundingAttribute(),
            'total_members' => $this->users()->count(),
        ];
    }
}
