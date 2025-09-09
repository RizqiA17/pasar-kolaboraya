<?php

namespace App\Models;

use App\Notifications\CustomVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable // implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_ecosystem_builder',
        'ecosystem_builder_status',
        'ecosystem_builder_reason',
        'ecosystem_builder_approved_at',
        'ecosystem_builder_approved_by',
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
            'is_ecosystem_builder' => 'boolean',
            'ecosystem_builder_approved_at' => 'datetime',
        ];
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification);
    }

    /**
     * Send the password reset notification.
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
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
            ->where('status', 'accepted');
    }

    public function collaborations()
    {
        return $this->hasMany(CollaborationUser::class)->where('status', 'accepted')->where('user_id', $this->id);
    }

    public function events()
    {
        return $this->hasMany(EventUser::class)->where('user_id', $this->id);
    }

    public function mutualConnections(){
        return $this->hasMany(Connection::class)
            ->where('status', 'accepted');
    }

    public function upcomingEvents()
    {
        return $this->hasMany(EventUser::class)
            ->where('user_id', $this->id)
            ->where('status', 'accepted')
            ->withWhereHas('event', function ($q) {
                $q->where('start_date', '>=', now());
            });

    }

    public function pastEvents()
    {
        return $this->hasMany(EventUser::class)
            ->where('user_id', $this->id)
            ->where('status', 'accepted')
            ->withWhereHas('event', function ($q) {
                $q->where('end_date', '<', now());
            });
    }

    public function pendingReceivedConnections(){
        return $this->hasMany(Connection::class, 'receiver_id')
            ->where('receiver_id', $this->id)
            ->where('status', 'pending');
    }

    public function pendingSentConnections(){
        return $this->hasMany(Connection::class, 'requester_id')
            ->where('requester_id', $this->id)
            ->where('status', 'pending');
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
            ->withCount([
                'events' => function ($query) use ($userEventIds) {
                    $query->whereIn('event_id', $userEventIds);
                }
            ])
            ->orderByDesc('events_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recommended users based on mutual friends
     */
    public function getMutualFriendsRecommendations($limit = 5)
    {
        $currentUserId = $this->id;

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
            ->where('id', '!=', $currentUserId)
            ->whereNotIn('id', $myFriendIds)  // Exclude users who are already friends
            ->whereDoesntHave('receivedConnections', function ($query) use ($currentUserId) {  // Exclude pending requests
                $query->where('requester_id', $currentUserId);
            })
            ->withCount([
                'connections' => function ($query) use ($myFriendIds) {
                    $query->whereIn('receiver_id', $myFriendIds)
                        ->where('status', 'accepted');
                }
            ])
            ->orderByDesc('connections_count')  // Order by number of mutual friends
            ->limit($limit)
            ->get();
    }

    /**
     * Get connection status with another user
     */
    public function getConnectionStatus($otherUserId)
    {
        $currentUserId = $this->id;

        if ($currentUserId === $otherUserId) {
            return 'self';
        }

        // Check if already connected
        $existingConnection = Connection::where(function ($query) use ($otherUserId, $currentUserId) {
            $query->where('requester_id', $currentUserId)
                ->where('receiver_id', $otherUserId);
        })->orWhere(function ($query) use ($otherUserId, $currentUserId) {
            $query->where('requester_id', $otherUserId)
                ->where('receiver_id', $currentUserId);
        })->first();

        if (!$existingConnection) {
            return 'not_connected';
        }

        if ($existingConnection->status === 'accepted') {
            return 'connected';
        }

        if ($existingConnection->status === 'pending') {
            if ($existingConnection->requester_id === $currentUserId) {
                return 'pending_sent';
            } else {
                return 'pending_received';
            }
        }

        return 'not_connected';
    }

    /**
     * Check if user is connected with another user
     */
    public function isConnectedWith($otherUserId)
    {
        return $this->getConnectionStatus($otherUserId) === 'connected';
    }

    /**
     * Check if user has pending connection request to another user
     */
    public function hasPendingRequestTo($otherUserId)
    {
        return $this->getConnectionStatus($otherUserId) === 'pending_sent';
    }

    /**
     * Check if user has pending connection request from another user
     */
    public function hasPendingRequestFrom($otherUserId)
    {
        return $this->getConnectionStatus($otherUserId) === 'pending_received';
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    /**
     * Check if user has admin privileges
     */
    public function hasAdminPrivileges(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Get surveys created by this user
     */
    public function createdSurveys()
    {
        return $this->hasMany(Survey::class, 'created_by');
    }

    /**
     * Get survey responses by this user
     */
    public function surveyResponses()
    {
        return $this->hasMany(SurveyResponse::class);
    }

    /**
     * Check if user has responded to a specific survey
     */
    public function hasRespondedToSurvey($surveyId)
    {
        return $this->surveyResponses()->where('survey_id', $surveyId)->exists();
    }

    /**
     * Get ecosystems created by this user
     */
    public function createdEcosystems(): HasMany
    {
        return $this->hasMany(Ecosystem::class, 'creator_id');
    }

    /**
     * Get ecosystems this user belongs to
     */
    public function ecosystems(): BelongsToMany
    {
        return $this->belongsToMany(Ecosystem::class, 'ecosystem_users')
            ->withPivot(['status', 'join_reason', 'joined_at'])
            ->withTimestamps();
    }

    /**
     * Get ecosystems where user is accepted
     */
    public function acceptedEcosystems(): BelongsToMany
    {
        return $this->ecosystems()->wherePivot('status', 'accepted');
    }

    /**
     * Get pending ecosystem join requests
     */
    public function pendingEcosystems(): BelongsToMany
    {
        return $this->ecosystems()->wherePivot('status', 'pending');
    }

    /**
     * Check if user is an ecosystem builder
     */
    public function isEcosystemBuilder(): bool
    {
        return $this->is_ecosystem_builder;
    }

    /**
     * Check if user is an approved ecosystem builder
     */
    public function isApprovedEcosystemBuilder(): bool
    {
        return $this->is_ecosystem_builder && $this->ecosystem_builder_status === 'approved';
    }

    /**
     * Check if user has pending ecosystem builder approval
     */
    public function hasPendingEcosystemBuilderApproval(): bool
    {
        return $this->is_ecosystem_builder && $this->ecosystem_builder_status === 'pending';
    }

    /**
     * Get the admin who approved this user as ecosystem builder
     */
    public function ecosystemBuilderApprovedBy()
    {
        return $this->belongsTo(User::class, 'ecosystem_builder_approved_by');
    }

    /**
     * Get collective actions created by this user
     */
    public function createdCollectiveActions(): HasMany
    {
        return $this->hasMany(CollectiveAction::class, 'created_by');
    }

    /**
     * Get collective action contributions made by this user
     */
    public function collectiveActionContributions(): HasMany
    {
        return $this->hasMany(CollectiveActionContribution::class);
    }

    /**
     * Get offered contributions
     */
    public function offeredContributions(): HasMany
    {
        return $this->collectiveActionContributions()->where('status', 'offered');
    }

    /**
     * Get accepted contributions
     */
    public function acceptedContributions(): HasMany
    {
        return $this->collectiveActionContributions()->where('status', 'accepted');
    }

    /**
     * Get completed contributions
     */
    public function completedContributions(): HasMany
    {
        return $this->collectiveActionContributions()->where('status', 'completed');
    }

    /**
     * Get declined contributions
     */
    public function declinedContributions(): HasMany
    {
        return $this->collectiveActionContributions()->where('status', 'declined');
    }

    /**
     * Get collective actions this user has contributed to (via contributions table)
     */
    public function contributedCollectiveActions(): BelongsToMany
    {
        return $this->belongsToMany(CollectiveAction::class, 'collective_action_contributions')
            ->withPivot(['contribution_type', 'contribution_description', 'contribution_amount', 'contribution_details', 'status', 'offered_at', 'accepted_at', 'completed_at', 'admin_notes'])
            ->withTimestamps();
    }

    /**
     * Get accepted collective action contributions
     */
    public function acceptedCollectiveActions(): BelongsToMany
    {
        return $this->contributedCollectiveActions()->wherePivot('status', 'accepted');
    }

    /**
     * Get collective actions where user is a member
     */
    public function collectiveActionMemberships(): BelongsToMany
    {
        return $this->belongsToMany(CollectiveAction::class, 'collective_action_users')
            ->withPivot(['ecosystem_id', 'role', 'status', 'join_type', 'join_reason', 'joined_at'])
            ->withTimestamps();
    }

    /**
     * Get collective actions where user is an admin
     */
    public function adminCollectiveActions(): BelongsToMany
    {
        return $this->collectiveActionMemberships()->wherePivot('role', 'admin');
    }

    /**
     * Get collective actions where user is a member
     */
    public function memberCollectiveActions(): BelongsToMany
    {
        return $this->collectiveActionMemberships()->wherePivot('role', 'member');
    }

    /**
     * Get collective actions where user is a contributor
     */
    public function contributorCollectiveActions(): BelongsToMany
    {
        return $this->collectiveActionMemberships()->wherePivot('role', 'contributor');
    }

    /**
     * Get active collective action memberships
     */
    public function activeCollectiveActions(): BelongsToMany
    {
        return $this->collectiveActionMemberships()->wherePivot('status', 'active');
    }

    /**
     * Get collective actions joined through ecosystem
     */
    public function ecosystemCollectiveActions(): BelongsToMany
    {
        return $this->collectiveActionMemberships()->wherePivot('join_type', 'ecosystem');
    }

    /**
     * Get collective actions joined directly
     */
    public function directCollectiveActions(): BelongsToMany
    {
        return $this->collectiveActionMemberships()->wherePivot('join_type', 'direct');
    }

    /**
     * Check if user is admin of a collective action
     */
    public function isAdminOfCollectiveAction(CollectiveAction $collectiveAction): bool
    {
        return $collectiveAction->isUserAdmin($this);
    }

    /**
     * Check if user is member of a collective action
     */
    public function isMemberOfCollectiveAction(CollectiveAction $collectiveAction): bool
    {
        return $collectiveAction->isUserMember($this);
    }

    /**
     * Check if user is contributor of a collective action
     */
    public function isContributorOfCollectiveAction(CollectiveAction $collectiveAction): bool
    {
        return $collectiveAction->isUserContributor($this);
    }
}
