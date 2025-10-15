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

    /**
     * Get ecosystems for this Pasar Kolaboraya
     */
    public function ecosystems(): HasMany
    {
        return $this->hasMany(Ecosystem::class, 'pasar_kolaboraya_id');
    }

    /**
     * Get collective actions for this Pasar Kolaboraya
     */
    public function collectiveActions(): HasMany
    {
        return $this->hasMany(CollectiveAction::class, 'pasar_kolaboraya_id');
    }

    /**
     * Get connections for this Pasar Kolaboraya
     */
    public function connections(): HasMany
    {
        return $this->hasMany(Connection::class, 'pasar_kolaboraya_id');
    }

    /**
     * Calculate overall health score for this Pasar Kolaboraya
     */
    public function calculateHealthScore(): float
    {
        $totalUsers = $this->acceptedUsers->count();
        if ($totalUsers === 0) return 0;

        $ecosystemHealth = $this->calculateEcosystemHealth();
        $collectiveActionQuality = $this->calculateCollectiveActionQuality();
        $collaborationIndex = $this->calculateCollaborationIndex();
        $participationRate = $this->calculateParticipationRate();
        $engagementScore = $this->calculateEngagementScore();
        $networkDiversity = $this->calculateNetworkDiversity();
        $resourceUtilization = $this->calculateResourceUtilization();

        return round((
            $ecosystemHealth * 0.25 +
            $collectiveActionQuality * 0.20 +
            $collaborationIndex * 0.15 +
            $participationRate * 0.10 +
            $engagementScore * 0.10 +
            $networkDiversity * 0.10 +
            $resourceUtilization * 0.10
        ), 2);
    }

    /**
     * Calculate ecosystem health score using Pilar II - Ekosistem scoring
     */
    public function calculateEcosystemHealth(): float
    {
        $ecosystems = $this->ecosystems;
        if ($ecosystems->isEmpty()) return 0;
        
        $totalScore = 0;
        foreach ($ecosystems as $ecosystem) {
            $ekosistemData = $ecosystem->calculateEkosistemScore();
            $totalScore += $ekosistemData['ekosistem_score'];
        }
        
        return round($totalScore / $ecosystems->count(), 2);
    }

    /**
     * Calculate collective action quality score using Pilar III - Aksi Kolektif scoring
     */
    public function calculateCollectiveActionQuality(): float
    {
        $collectiveActions = $this->collectiveActions;
        if ($collectiveActions->isEmpty()) return 0;
        
        $totalScore = 0;
        foreach ($collectiveActions as $action) {
            $aksiData = $action->calculateAksiScore();
            $totalScore += $aksiData['aksi_score'];
        }
        
        return round($totalScore / $collectiveActions->count(), 2);
    }

    /**
     * Calculate collaboration index
     */
    public function calculateCollaborationIndex(): float
    {
        $collectiveActions = $this->collectiveActions;
        if ($collectiveActions->isEmpty()) return 0;
        
        $totalParticipants = 0;
        foreach ($collectiveActions as $action) {
            $totalParticipants += $action->users()->count();
        }
        
        $avgParticipants = $totalParticipants / $collectiveActions->count();
        $totalUsers = $this->acceptedUsers->count();
        
        return $totalUsers > 0 ? round(($avgParticipants / $totalUsers) * 100, 2) : 0;
    }

    /**
     * Calculate participation rate
     */
    public function calculateParticipationRate(): float
    {
        $totalUsers = $this->acceptedUsers->count();
        if ($totalUsers === 0) return 0;
        
        $activeUsers = $this->acceptedUsers->where('active_pasar_kolaboraya_id', $this->id)->count();
        return round(($activeUsers / $totalUsers) * 100, 2);
    }

    /**
     * Calculate engagement score
     */
    public function calculateEngagementScore(): float
    {
        $totalUsers = $this->acceptedUsers->count();
        if ($totalUsers === 0) return 0;
        
        $activeUsers = $this->acceptedUsers->where('active_pasar_kolaboraya_id', $this->id)->count();
        $usersWithConnections = $this->acceptedUsers->filter(function($user) {
            return $user->sentConnections()->where('pasar_kolaboraya_id', $this->id)->where('status', 'accepted')->count() > 0;
        })->count();
        
        $usersWithEcosystems = $this->acceptedUsers->filter(function($user) {
            return $user->ecosystems()->where('pasar_kolaboraya_id', $this->id)->count() > 0;
        })->count();
        
        $usersWithActions = $this->acceptedUsers->filter(function($user) {
            return $user->activeCollectiveActions()->where('pasar_kolaboraya_id', $this->id)->count() > 0;
        })->count();
        
        $engagementScore = (
            ($activeUsers / $totalUsers) * 30 +
            ($usersWithConnections / $totalUsers) * 25 +
            ($usersWithEcosystems / $totalUsers) * 25 +
            ($usersWithActions / $totalUsers) * 20
        );
        
        return round($engagementScore, 2);
    }

    /**
     * Calculate network diversity
     */
    public function calculateNetworkDiversity(): float
    {
        $users = $this->acceptedUsers;
        if ($users->isEmpty()) return 0;
        
        $sectors = $users->pluck('organization_name')->filter()->unique()->count();
        $skills = $users->flatMap(function($user) {
            return $user->profile ? $user->profile->skills->pluck('name') : collect();
        })->unique()->count();
        
        $diversityScore = min(100, ($sectors * 5) + ($skills * 2));
        
        return round($diversityScore, 2);
    }

    /**
     * Calculate resource utilization
     */
    public function calculateResourceUtilization(): float
    {
        $collectiveActions = $this->collectiveActions;
        if ($collectiveActions->isEmpty()) return 0;
        
        $totalResources = 0;
        $utilizedResources = 0;
        
        foreach ($collectiveActions as $action) {
            $requiredResources = is_array($action->required_resources) ? count($action->required_resources) : 0;
            $totalResources += $requiredResources;
            
            // Count how many resources are actually provided
            $providedResources = $action->contributions()->count();
            $utilizedResources += min($providedResources, $requiredResources);
        }
        
        return $totalResources > 0 ? round(($utilizedResources / $totalResources) * 100, 2) : 0;
    }

    /**
     * Get health status based on overall score
     */
    public function getHealthStatusAttribute(): string
    {
        $score = $this->calculateHealthScore();
        
        if ($score >= 80) return 'excellent';
        if ($score >= 60) return 'good';
        if ($score >= 40) return 'fair';
        return 'poor';
    }

    /**
     * Get health status label
     */
    public function getHealthStatusLabelAttribute(): string
    {
        return match($this->health_status) {
            'excellent' => 'Sangat Sehat',
            'good' => 'Sehat',
            'fair' => 'Cukup Sehat',
            'poor' => 'Perlu Perhatian',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get health status color
     */
    public function getHealthStatusColorAttribute(): string
    {
        return match($this->health_status) {
            'excellent' => 'green',
            'good' => 'blue',
            'fair' => 'yellow',
            'poor' => 'red',
            default => 'gray'
        };
    }
}
