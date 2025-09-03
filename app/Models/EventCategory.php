<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventCategory extends Model
{
    use SoftDeletes;
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
