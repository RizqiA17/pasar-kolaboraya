<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization',
        'phone',
        'social_media',
        'vision',
        'profile_photo',
        'banner',
        'peran_id',
    ];

    protected $casts = [
        'social_media' => 'array',
    ];

    /**
     * Get social media links with backward compatibility
     */
    public function getSocialMediaAttribute($value)
    {
        $socialMedia = json_decode($value, true) ?? [];
        
        // If empty, return empty array
        if (empty($socialMedia)) {
            return [];
        }
        
        // Check if this is old format (key-value pairs)
        $isOldFormat = false;
        foreach ($socialMedia as $key => $val) {
            if (is_string($key) && is_string($val)) {
                $isOldFormat = true;
                break;
            }
        }
        
        // If old format, convert to new format
        if ($isOldFormat) {
            return \App\Helpers\SocialLinkFormatter::convertOldFormat($socialMedia);
        }
        
        // Return as is if already new format
        return $socialMedia;
    }

    /**
     * Set social media links
     */
    public function setSocialMediaAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['social_media'] = json_encode($value);
        } else {
            $this->attributes['social_media'] = $value;
        }
    }

    /**
     * Get formatted social media links for display
     */
    public function getFormattedSocialMediaAttribute()
    {
        $socialMedia = $this->social_media ?? [];
        $formatted = [];
        
        foreach ($socialMedia as $item) {
            if (!empty($item['platform'])) {
                $url = \App\Helpers\SocialLinkFormatter::generateProfileUrl(
                    $item['platform'],
                    $item['username'] ?? null,
                    $item['custom_link'] ?? null
                );
                
                if ($url && $url !== '#') {
                    $formatted[$item['platform']] = $url;
                }
            }
        }
        
        return $formatted;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class, 'user_interests', 'profile_id', 'interest_id')
            ->withPivot('level', 'custom_name')
            ->withTimestamps()
            ->select(['interests.*', 'user_interests.level', 'user_interests.custom_name']);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'user_skills', 'profile_id', 'skill_id')
            ->withPivot('level', 'is_primary', 'custom_name')
            ->withTimestamps()
            ->select(['skills.*', 'user_skills.level', 'user_skills.is_primary', 'user_skills.custom_name']);
    }

    public function contributions(): BelongsToMany
    {
        return $this->belongsToMany(Contribution::class, 'user_contributions', 'profile_id', 'contribution_id')
            ->withPivot('description', 'date')
            ->withTimestamps()
            ->select(['contributions.*', 'user_contributions.description', 'user_contributions.date']);
    }

    public function peran()
    {
        return $this->belongsTo(Peran::class);
    }

    /**
     * Get all skills including custom ones
     */
    public function getAllSkills()
    {
        return DB::table('user_skills')
            ->leftJoin('skills', 'user_skills.skill_id', '=', 'skills.id')
            ->where('user_skills.profile_id', $this->id)
            ->select('user_skills.*', 'skills.name as skill_name')
            ->get();
    }

    /**
     * Get all interests including custom ones
     */
    public function getAllInterests()
    {
        return DB::table('user_interests')
            ->where('profile_id', $this->id)
            ->get();
    }
}


