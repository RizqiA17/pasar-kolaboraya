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
        return $this->belongsToMany(Interest::class, 'user_interests', 'profile_id', 'interest_id')
            ->withPivot('level')
            ->withTimestamps()
            ->select(['interests.*', 'user_interests.level']);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'user_skills', 'profile_id', 'skill_id')
            ->withPivot('level', 'is_primary')
            ->withTimestamps()
            ->select(['skills.*', 'user_skills.level', 'user_skills.is_primary']);
    }

    public function contributions(): BelongsToMany
    {
        return $this->belongsToMany(Contribution::class, 'user_contributions', 'profile_id', 'contribution_id')
            ->withPivot('description', 'date')
            ->withTimestamps()
            ->select(['contributions.*', 'user_contributions.description', 'user_contributions.date']);
    }
}


