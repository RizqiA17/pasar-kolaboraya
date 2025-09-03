<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contribution extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'icon', 'category', 'description'];

    public function profiles(): BelongsToMany
    {
        return $this->belongsToMany(Profile::class, 'user_contributions', 'contribution_id', 'profile_id')
            ->withTimestamps();
    }
}
