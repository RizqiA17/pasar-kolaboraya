<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name', 'icon', 'category', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skills')
            ->withPivot('level', 'is_primary')
            ->withTimestamps();
    }
}
