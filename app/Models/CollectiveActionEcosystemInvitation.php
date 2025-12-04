<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectiveActionEcosystemInvitation extends Model
{
    protected $fillable = [
        'collective_action_id',
        'ecosystem_id',
        'invited_by',
        'status',
        'role',
        'invitation_message',
        'response_message',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saved(function ($invitation) {
            Cache::tags([
                "collective:invitations:user:{$invitation->ecosystem->creator_id}"
            ])->flush();
        });

        static::deleted(function ($invitation) {
            Cache::tags([
                "collective:invitations:user:{$invitation->ecosystem->creator_id}"
            ])->flush();
        });
    }

    public static function clearInvitationCache($userId)
    {
        Cache::tags([
            "collective:invitations:user:{$userId}"
        ])->flush();
    }


    /**
     * Get the collective action this invitation belongs to
     */
    public function collectiveAction(): BelongsTo
    {
        return $this->belongsTo(CollectiveAction::class);
    }

    /**
     * Get the ecosystem being invited
     */
    public function ecosystem(): BelongsTo
    {
        return $this->belongsTo(Ecosystem::class);
    }

    /**
     * Get the user who sent the invitation
     */
    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'accepted' => 'Diterima',
            'declined' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    /**
     * Check if invitation is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if invitation is accepted
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if invitation is declined
     */
    public function isDeclined(): bool
    {
        return $this->status === 'declined';
    }

    /**
     * Check if invitation is for admin role
     */
    public function isAdminInvitation(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if invitation is for member role
     */
    public function isMemberInvitation(): bool
    {
        return $this->role === 'member';
    }

    /**
     * Get role label
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Admin',
            'member' => 'Anggota',
            default => ucfirst($this->role),
        };
    }
}
