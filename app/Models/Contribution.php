<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = ['name', 'icon', 'category', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_contributions')
            ->withPivot('description', 'date')
            ->withTimestamps();
    }
}
