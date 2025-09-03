<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
