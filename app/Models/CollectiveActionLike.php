<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectiveActionLike extends Model
{
    protected $fillable = [
        'user_id',
        'collective_action_id',
    ];

    /**
     * Get the user who liked the collective action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the collective action that was liked
     */
    public function collectiveAction(): BelongsTo
    {
        return $this->belongsTo(CollectiveAction::class);
    }
}
