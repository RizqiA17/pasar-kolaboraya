<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectiveActionMember extends Model
{
    protected $fillable = [
        'collective_action_id',
        'user_id',
        'ecosystem_id',
        'role',
        'status',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    /**
     * Get the collective action this member belongs to
     */
    public function collectiveAction(): BelongsTo
    {
        return $this->belongsTo(CollectiveAction::class);
    }

    /**
     * Get the user who is a member
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ecosystem this member represents
     */
    public function ecosystem(): BelongsTo
    {
        return $this->belongsTo(Ecosystem::class);
    }

    /**
     * Check if member is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if member is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get role label
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Admin',
            'member' => 'Anggota',
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
            default => ucfirst($this->status),
        };
    }
}