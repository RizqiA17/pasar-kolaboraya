<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PasarKolaboraya extends Model
{
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'status',
        'settings',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /**
     * Get the user who created this Pasar Kolaboraya
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all users in this Pasar Kolaboraya
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pasar_kolaboraya_users')
                    ->withPivot(['status', 'role', 'invited_by', 'join_reason', 'admin_notes', 'joined_at', 'responded_at'])
                    ->withTimestamps();
    }

    /**
     * Get accepted users only
     */
    public function acceptedUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('status', 'accepted');
    }

    /**
     * Get pending users
     */
    public function pendingUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('status', 'pending');
    }

    /**
     * Get admin users
     */
    public function adminUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'admin')->wherePivot('status', 'accepted');
    }

    /**
     * Get member users
     */
    public function memberUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'member')->wherePivot('status', 'accepted');
    }

    /**
     * Get users with active Pasar Kolaboraya
     */
    public function activeUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pasar_kolaboraya_users')
                    ->wherePivot('status', 'accepted')
                    ->where('users.active_pasar_kolaboraya_id', $this->id);
    }

    /**
     * Get pivot records
     */
    public function pasarKolaborayaUsers(): HasMany
    {
        return $this->hasMany(PasarKolaborayaUser::class);
    }

    /**
     * Check if user is admin of this Pasar Kolaboraya
     */
    public function isUserAdmin(User $user): bool
    {
        return $this->adminUsers()->where('users.id', $user->id)->exists();
    }

    /**
     * Check if user is member of this Pasar Kolaboraya
     */
    public function isUserMember(User $user): bool
    {
        return $this->acceptedUsers()->where('users.id', $user->id)->exists();
    }

    /**
     * Check if user can join this Pasar Kolaboraya
     */
    public function canUserJoin(User $user): bool
    {
        // User can join if they're not already a member and session is active
        return $this->status === 'active' && !$this->isUserMember($user);
    }

    /**
     * Add user to Pasar Kolaboraya
     */
    public function addUser(User $user, string $role = 'member', string $joinReason = null, User $invitedBy = null): void
    {
        $this->users()->attach($user->id, [
            'status' => 'accepted',
            'role' => $role,
            'invited_by' => $invitedBy?->id,
            'join_reason' => $joinReason,
            'joined_at' => now(),
        ]);
    }

    /**
     * Request to join Pasar Kolaboraya
     */
    public function requestJoin(User $user, string $joinReason = null): void
    {
        $this->users()->attach($user->id, [
            'status' => 'pending',
            'role' => 'member',
            'join_reason' => $joinReason,
        ]);
    }

    /**
     * Approve user join request
     */
    public function approveUser(User $user, User $approver, string $adminNotes = null): bool
    {
        $pivot = $this->pasarKolaborayaUsers()
                     ->where('user_id', $user->id)
                     ->where('status', 'pending')
                     ->first();

        if (!$pivot) {
            return false;
        }

        $pivot->update([
            'status' => 'accepted',
            'joined_at' => now(),
            'responded_at' => now(),
            'admin_notes' => $adminNotes,
        ]);

        return true;
    }

    /**
     * Reject user join request
     */
    public function rejectUser(User $user, User $rejector, string $adminNotes = null): bool
    {
        $pivot = $this->pasarKolaborayaUsers()
                     ->where('user_id', $user->id)
                     ->where('status', 'pending')
                     ->first();

        if (!$pivot) {
            return false;
        }

        $pivot->update([
            'status' => 'rejected',
            'responded_at' => now(),
            'admin_notes' => $adminNotes,
        ]);

        return true;
    }

    /**
     * Remove user from Pasar Kolaboraya
     */
    public function removeUser(User $user): bool
    {
        $removed = $this->users()->detach($user->id);
        
        // If user was active in this session, clear their active session
        if ($user->active_pasar_kolaboraya_id === $this->id) {
            $user->update(['active_pasar_kolaboraya_id' => null]);
        }
        
        return $removed > 0;
    }

    /**
     * Scope for active Pasar Kolaboraya
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'archived' => 'Diarsipkan',
            default => 'Tidak Diketahui'
        };
    }
}
