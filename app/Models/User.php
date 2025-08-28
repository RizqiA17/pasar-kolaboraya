<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function sentConnections()
    {
        return $this->hasMany(Connection::class, 'requester_id');
    }

    public function receivedConnections()
    {
        return $this->hasMany(Connection::class, 'receiver_id');
    }

    public function connections()
    {
        return $this->hasMany(Connection::class, 'requester_id')
            ->where('status', 'accepted')->where('receiver_id', auth()->id())->orWhere('requester_id', auth()->id());
    }

    public function collaborations(){
        return $this->hasMany(CollaborationUser::class)->where('status', 'accepted')->where('user_id', auth()->id());
    }

    public function events()
    {
        return $this->hasMany(EventUser::class)->where('user_id', auth()->id());
    }



    /**
     * Get recommended users based on common interests
     */
    public function getInterestBasedRecommendations($limit = 5)
    {
        $profile = $this->profile;
        if (!$profile) {
            return collect();
        }
        
        $userInterests = $profile->interests()->pluck('interests.id');
        
        if ($userInterests->isEmpty()) {
            return collect();
        }
        
        // Get users who have similar interests through their profile
        return User::whereHas('profile', function ($query) use ($userInterests) {
            $query->whereHas('interests', function ($subQuery) use ($userInterests) {
                $subQuery->whereIn('interests.id', $userInterests);
            });
        })
        ->where('id', '!=', $this->id)
        ->limit($limit)
        ->get();
    }

    /**
     * Get recommended users based on common skills
     */
    public function getSkillBasedRecommendations($limit = 5)
    {
        $profile = $this->profile;
        if (!$profile) {
            return collect();
        }
        
        $userSkills = $profile->skills()->pluck('skills.id');
        
        if ($userSkills->isEmpty()) {
            return collect();
        }
        
        // Get users who have similar skills through their profile
        return User::whereHas('profile', function ($query) use ($userSkills) {
            $query->whereHas('skills', function ($subQuery) use ($userSkills) {
                $subQuery->whereIn('skills.id', $userSkills);
            });
        })
        ->where('id', '!=', $this->id)
        ->limit($limit)
        ->get();
    }

    /**
     * Get recommended users based on event participation
     */
    public function getEventBasedRecommendations($limit = 5)
    {
        $userEventIds = $this->events()->pluck('event_id');
        
        return User::whereHas('events', function ($query) use ($userEventIds) {
            $query->whereIn('event_id', $userEventIds);
        })
        ->where('id', '!=', $this->id)
        ->withCount(['events' => function ($query) use ($userEventIds) {
            $query->whereIn('event_id', $userEventIds);
        }])
        ->orderByDesc('events_count')
        ->limit($limit)
        ->get();
    }

    /**
     * Get recommended users based on mutual friends
     */
    public function getMutualFriendsRecommendations($limit = 5)
    {
        // Get IDs of current user's friends
        $myFriendIds = $this->connections()
            ->where('status', 'accepted')
            ->pluck('receiver_id')
            ->toArray();

        // Get users who are friends with my friends but not with me
        return User::whereHas('connections', function ($query) use ($myFriendIds) {
                $query->whereIn('receiver_id', $myFriendIds)
                    ->where('status', 'accepted');
            })
            ->where('id', '!=', $this->id)
            ->whereNotIn('id', $myFriendIds)  // Exclude users who are already friends
            ->whereDoesntHave('receivedConnections', function ($query) {  // Exclude pending requests
                $query->where('requester_id', $this->id);
            })
            ->withCount(['connections' => function ($query) use ($myFriendIds) {
                $query->whereIn('receiver_id', $myFriendIds)
                    ->where('status', 'accepted');
            }])
            ->orderByDesc('connections_count')  // Order by number of mutual friends
            ->limit($limit)
            ->get();
    }
}
