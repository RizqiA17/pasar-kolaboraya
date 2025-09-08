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
        'ecosystem_ids',
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
        'ecosystem_ids' => 'array',
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
     * Get the ecosystems participating in this action
     */
    public function ecosystems()
    {
        return Ecosystem::whereIn('id', $this->ecosystem_ids ?? []);
    }

    /**
     * Get participating ecosystems as a collection
     */
    public function getEcosystemsAttribute()
    {
        if (empty($this->ecosystem_ids)) {
            return collect();
        }
        
        return Ecosystem::whereIn('id', $this->ecosystem_ids)->get();
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
        return !$this->contributors()->where('users.id', $user->id)->exists();
    }

    /**
     * Check if minimum ecosystems requirement is met
     */
    public function hasMinimumEcosystems(): bool
    {
        return count($this->ecosystem_ids ?? []) >= $this->min_ecosystems;
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
}
