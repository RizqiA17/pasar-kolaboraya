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
}
