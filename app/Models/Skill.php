<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

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

    protected static function booted()
    {
        static::saved(function ($skill) {
            foreach ($skill->profiles as $profile) {
                Cache::tags('profile')->forget("profile:{$profile->user_id}:skills");
            }
        });

        static::deleted(function ($skill) {
            foreach ($skill->profiles as $profile) {
                Cache::tags('profile')->forget("profile:{$profile->user_id}:skills");
            }
        });
    }
}
