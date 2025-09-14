<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasarKolaborayaUser extends Model
{
    protected $fillable = [
        'pasar_kolaboraya_id',
        'user_id',
        'status',
        'role',
        'invited_by',
        'join_reason',
        'admin_notes',
        'joined_at',
        'responded_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    /**
     * Get the Pasar Kolaboraya
     */
    public function pasarKolaboraya(): BelongsTo
    {
        return $this->belongsTo(PasarKolaboraya::class);
    }

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user who invited this user
     */
    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is member
     */
    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    /**
     * Check if status is accepted
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if status is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if status is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get role label
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Admin',
            'member' => 'Anggota',
            default => 'Tidak Diketahui'
        };
    }
}
