<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectiveActionUser extends Model
{
    protected $table = 'collective_action_users';
    
    protected $fillable = [
        'collective_action_id',
        'user_id',
        'ecosystem_id',
        'role',
        'status',
        'join_type',
        'join_reason',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    /**
     * Get the collective action this user belongs to
     */
    public function collectiveAction(): BelongsTo
    {
        return $this->belongsTo(CollectiveAction::class);
    }

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ecosystem (if user joined through ecosystem)
     */
    public function ecosystem(): BelongsTo
    {
        return $this->belongsTo(Ecosystem::class);
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a member
     */
    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    /**
     * Check if user is a contributor
     */
    public function isContributor(): bool
    {
        return $this->role === 'contributor';
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if user is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if user joined through ecosystem
     */
    public function joinedThroughEcosystem(): bool
    {
        return $this->join_type === 'ecosystem';
    }

    /**
     * Check if user joined directly
     */
    public function joinedDirectly(): bool
    {
        return $this->join_type === 'direct';
    }

    /**
     * Check if user joined through invitation
     */
    public function joinedThroughInvitation(): bool
    {
        return $this->join_type === 'invitation';
    }

    /**
     * Get role label
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Admin',
            'member' => 'Anggota',
            'contributor' => 'Kontributor',
            default => ucfirst($this->role),
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'pending' => 'Menunggu',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get join type label
     */
    public function getJoinTypeLabelAttribute(): string
    {
        return match($this->join_type) {
            'ecosystem' => 'Melalui Ekosistem',
            'direct' => 'Bergabung Langsung',
            'invitation' => 'Undangan',
            default => ucfirst($this->join_type),
        };
    }
}