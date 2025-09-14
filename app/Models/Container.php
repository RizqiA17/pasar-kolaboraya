<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Container extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    /**
     * Get all users in this container
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'container_users')
                    ->withPivot(['role', 'status', 'joined_at'])
                    ->withTimestamps();
    }

    /**
     * Get pivot records
     */
    public function containerUsers(): HasMany
    {
        return $this->hasMany(ContainerUser::class);
    }

    /**
     * Get active users
     */
    public function activeUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('status', 'active');
    }

    /**
     * Get admin users
     */
    public function adminUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'admin')->wherePivot('status', 'active');
    }

    /**
     * Get member users
     */
    public function memberUsers(): BelongsToMany
    {
        return $this->users()->wherePivot('role', 'member')->wherePivot('status', 'active');
    }

    /**
     * Add user to container
     */
    public function addUser(User $user, string $role = 'member'): void
    {
        $this->users()->attach($user->id, [
            'role' => $role,
            'status' => 'active',
            'joined_at' => now(),
        ]);
    }

    /**
     * Remove user from container
     */
    public function removeUser(User $user): bool
    {
        return $this->users()->detach($user->id) > 0;
    }

    /**
     * Check if user is admin of this container
     */
    public function isUserAdmin(User $user): bool
    {
        return $this->adminUsers()->where('users.id', $user->id)->exists();
    }

    /**
     * Check if user is member of this container
     */
    public function isUserMember(User $user): bool
    {
        return $this->activeUsers()->where('users.id', $user->id)->exists();
    }

    /**
     * Scope for active containers
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
