<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization',
        'phone',
        'social_media',
        'vision',
    ];

    protected $casts = [
        'social_media' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class, 'user_interests', 'user_id', 'interest_id')
            ->withPivot('level')
            ->withTimestamps();
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'user_skills', 'user_id', 'skill_id')
            ->withPivot('level', 'is_primary')
            ->withTimestamps();
    }

    public function contributions(): BelongsToMany
    {
        return $this->belongsToMany(Contribution::class, 'user_contributions', 'user_id', 'contribution_id')
            ->withPivot('description', 'date')
            ->withTimestamps();
    }
}


