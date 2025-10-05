<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EcosystemContribution extends Model
{
    protected $fillable = [
        'ecosystem_id',
        'user_id',
        'contribution_id',
        'contribution_description',
        'contribution_amount',
        'contribution_details',
        'contribution_custom_type',
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
     * Get the ecosystem this contribution belongs to
     */
    public function ecosystem(): BelongsTo
    {
        return $this->belongsTo(Ecosystem::class);
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
        // If custom type is provided, use it
        if ($this->contribution_custom_type) {
            return $this->contribution_custom_type;
        }
        
        return $this->contribution ? $this->contribution->name : 'Tidak Diketahui';
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
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get status color class
     */
    public function getStatusColorClassAttribute(): string
    {
        return match($this->status) {
            'offered' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300',
            'accepted' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
            'completed' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300',
            'declined' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300',
            default => 'bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-slate-300'
        };
    }
}
