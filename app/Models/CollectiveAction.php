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
        'start_date',
        'end_date',
        'location',
        'status',
        'min_ecosystems',
        'collaboration_terms',
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
     * Get users who have contributed to this action
     */
    public function contributors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'collective_action_users')
            ->withPivot(['contribution_type', 'contribution_description', 'contribution_amount', 'contribution_details', 'status'])
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

        // Check if user is already a contributor
        if ($this->contributors()->where('users.id', $user->id)->exists()) {
            return false;
        }

        // Check if user is already a member (they can contribute as members)
        if ($this->isUserMember($user)) {
            return false; // Members don't need to contribute separately
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
        // Check if ecosystem is the creator or has accepted invitation
        if ($this->created_by === $ecosystemId) {
            return true;
        }
        
        return $this->acceptedInvitations()
            ->where('ecosystem_id', $ecosystemId)
            ->exists();
    }

    /**
     * Scope to filter collective actions by ecosystem ID
     */
    public function scopeForEcosystem($query, int $ecosystemId)
    {
        return $query->where(function ($q) use ($ecosystemId) {
            $q->where('created_by', $ecosystemId)
              ->orWhereHas('acceptedInvitations', function ($subQuery) use ($ecosystemId) {
                  $subQuery->where('ecosystem_id', $ecosystemId);
              });
        });
    }

    /**
     * Scope to filter collective actions by multiple ecosystem IDs
     */
    public function scopeForEcosystems($query, array $ecosystemIds)
    {
        return $query->where(function ($q) use ($ecosystemIds) {
            $q->whereIn('created_by', $ecosystemIds)
              ->orWhereHas('acceptedInvitations', function ($subQuery) use ($ecosystemIds) {
                  $subQuery->whereIn('ecosystem_id', $ecosystemIds);
              });
        });
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
     * Get all members of this collective action
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'collective_action_members')
            ->withPivot(['ecosystem_id', 'role', 'status', 'joined_at'])
            ->withTimestamps();
    }

    /**
     * Get admin members
     */
    public function adminMembers(): BelongsToMany
    {
        return $this->members()->wherePivot('role', 'admin');
    }

    /**
     * Get regular members
     */
    public function regularMembers(): BelongsToMany
    {
        return $this->members()->wherePivot('role', 'member');
    }

    /**
     * Get active members
     */
    public function activeMembers(): BelongsToMany
    {
        return $this->members()->wherePivot('status', 'active');
    }

    /**
     * Check if user is an admin of this collective action
     */
    public function isUserAdmin(User $user): bool
    {
        return $this->adminMembers()->where('users.id', $user->id)->exists();
    }

    /**
     * Check if user is a member of this collective action
     */
    public function isUserMember(User $user): bool
    {
        return $this->activeMembers()->where('users.id', $user->id)->exists();
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

        // Check if user is admin member
        return $this->isUserAdmin($user);
    }

    /**
     * Add ecosystem members as collective action members
     */
    public function addEcosystemMembers(Ecosystem $ecosystem, string $role = 'member'): void
    {
        $ecosystemMembers = $ecosystem->acceptedUsers()->get();
        
        foreach ($ecosystemMembers as $member) {
            // Check if user is already a member
            if (!$this->isUserMember($member)) {
                $this->members()->attach($member->id, [
                    'ecosystem_id' => $ecosystem->id,
                    'role' => $role,
                    'status' => 'active',
                    'joined_at' => now(),
                ]);
            }
        }
    }

    /**
     * Remove ecosystem members from collective action
     */
    public function removeEcosystemMembers(Ecosystem $ecosystem): void
    {
        $this->members()->wherePivot('ecosystem_id', $ecosystem->id)->detach();
    }
}
