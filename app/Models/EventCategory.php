<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EventCategory extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'description',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_category_relations', 'category_id', 'event_id')
            ->withTimestamps();
    }
}
