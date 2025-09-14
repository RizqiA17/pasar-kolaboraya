<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectiveActionContribution extends Model
{
    protected $fillable = [
        'collective_action_id',
        'user_id',
        'contribution_id',
        'contribution_description',
        'contribution_amount',
        'contribution_details',
        'status',
        'offered_at',
        'accepted_at',
        'completed_at',
        'admin_notes',
    ];

    protected $casts = [
        'contribution_details' => 'array',
        'contribution_amount' => 'decimal:2',
        'offered_at' => 'datetime',
        'accepted_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the collective action this contribution belongs to
     */
    public function collectiveAction(): BelongsTo
    {
        return $this->belongsTo(CollectiveAction::class);
    }

    /**
     * Get the user who made this contribution
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the contribution type this contribution belongs to
     */
    public function contribution(): BelongsTo
    {
        return $this->belongsTo(Contribution::class);
    }

    /**
     * Check if contribution is offered
     */
    public function isOffered(): bool
    {
        return $this->status === 'offered';
    }

    /**
     * Check if contribution is accepted
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if contribution is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if contribution is declined
     */
    public function isDeclined(): bool
    {
        return $this->status === 'declined';
    }

    /**
     * Get contribution type label
     */
    public function getContributionTypeLabelAttribute(): string
    {
        return $this->contribution ? $this->contribution->name : 'Unknown';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'offered' => 'Ditawarkan',
            'accepted' => 'Diterima',
            'completed' => 'Selesai',
            'declined' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'offered' => 'warning',
            'accepted' => 'success',
            'completed' => 'primary',
            'declined' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Scope for offered contributions
     */
    public function scopeOffered($query)
    {
        return $query->where('status', 'offered');
    }

    /**
     * Scope for accepted contributions
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope for completed contributions
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for declined contributions
     */
    public function scopeDeclined($query)
    {
        return $query->where('status', 'declined');
    }

    /**
     * Scope for funding contributions
     */
    public function scopeFunding($query)
    {
        return $query->whereHas('contribution', function($q) {
            $q->where('name', 'like', '%funding%')->orWhere('name', 'like', '%dana%');
        });
    }

    /**
     * Scope for volunteer contributions
     */
    public function scopeVolunteer($query)
    {
        return $query->whereHas('contribution', function($q) {
            $q->where('name', 'like', '%volunteer%')->orWhere('name', 'like', '%relawan%');
        });
    }

    /**
     * Scope for expertise contributions
     */
    public function scopeExpertise($query)
    {
        return $query->whereHas('contribution', function($q) {
            $q->where('name', 'like', '%expertise%')->orWhere('name', 'like', '%keahlian%');
        });
    }

    /**
     * Scope for resource contributions
     */
    public function scopeResources($query)
    {
        return $query->whereHas('contribution', function($q) {
            $q->where('name', 'like', '%resource%')->orWhere('name', 'like', '%sumber daya%');
        });
    }

    /**
     * Scope for promotion contributions
     */
    public function scopePromotion($query)
    {
        return $query->whereHas('contribution', function($q) {
            $q->where('name', 'like', '%promotion%')->orWhere('name', 'like', '%promosi%');
        });
    }

    /**
     * Scope for other contributions
     */
    public function scopeOther($query)
    {
        return $query->whereHas('contribution', function($q) {
            $q->where('name', 'like', '%other%')->orWhere('name', 'like', '%lainnya%');
        });
    }
}