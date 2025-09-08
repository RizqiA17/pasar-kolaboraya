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
    ];

    protected $casts = [
        'issues_addressed' => 'array',
        'existing_roles' => 'array',
        'needed_roles' => 'array',
        'is_active' => 'boolean',
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
     * Get collective actions created by this ecosystem
     */
    public function collectiveActions(): HasMany
    {
        return $this->hasMany(CollectiveAction::class);
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
}
