<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EcosystemLike extends Model
{
    protected $fillable = [
        'user_id',
        'ecosystem_id',
    ];

    /**
     * Get the user who liked the ecosystem
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the ecosystem that was liked
     */
    public function ecosystem(): BelongsTo
    {
        return $this->belongsTo(Ecosystem::class);
    }
}
