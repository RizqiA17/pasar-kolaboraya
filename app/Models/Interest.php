<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Interest extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'icon', 'category', 'description'];

    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'user_interests', 'interest_id', 'profile_id')
            ->withPivot('level')
            ->withTimestamps();
    }

    protected static function booted()
    {
        static::saved(function ($interest) {
            foreach ($interest->profiles as $profile) {
                Cache::tags('profile')->forget("profile:{$profile->user_id}:interests");
            }
        });

        static::deleted(function ($interest) {
            foreach ($interest->profiles as $profile) {
                Cache::tags('profile')->forget("profile:{$profile->user_id}:interests");
            }
        });
    }
}
