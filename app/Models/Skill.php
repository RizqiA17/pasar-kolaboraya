<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'icon', 'category', 'description'];

    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'user_skills', 'skill_id', 'profile_id')
            ->withPivot('level', 'is_primary')
            ->withTimestamps();
    }
}
