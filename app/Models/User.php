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

class User extends Authenticatable implements MustVerifyEmail
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
        'user_type',
        'registration_key',
        'approval_status',
        'assigned_role',
        'approved_at',
        'approved_by',
        'approval_reason',
        'is_ecosystem_builder',
        'ecosystem_builder_status',
        'ecosystem_builder_reason',
        'ecosystem_builder_approved_at',
        'ecosystem_builder_approved_by',
        'active_pasar_kolaboraya_id',
        'active_container_id',
        'qr_code',
        'qr_code_generated_at',
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
            'approved_at' => 'datetime',
            'is_ecosystem_builder' => 'boolean',
            'ecosystem_builder_approved_at' => 'datetime',
            'qr_code_generated_at' => 'datetime',
        ];
    }

    /**
     * Get the admin who approved this user
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Check if user is approved
     */
    public function isApproved(): bool
    {
        return $this->approval_status === 'approved';
    }

    /**
     * Check if user is pending approval
     */
    public function isPendingApproval(): bool
    {
        return $this->approval_status === 'pending';
    }

    /**
     * Check if user is rejected
     */
    public function isRejected(): bool
    {
        return $this->approval_status === 'rejected';
    }

    /**
     * Check if user can access ecosystem and collective actions
     */
    public function canAccessEcosystem(): bool
    {
        return $this->user_type === 'partisipan';
    }

    /**
     * Check if user can only connect (tamu and komunitas)
     */
    public function canOnlyConnect(): bool
    {
        return $this->isApproved() && in_array($this->user_type, ['tamu', 'komunitas']);
    }

    /**
     * Get user type label
     */
    public function getUserTypeLabelAttribute(): string
    {
        return match($this->user_type) {
            'partisipan' => 'Partisipan',
            'tamu' => 'Tamu',
            'komunitas' => 'Komunitas',
            default => 'Unknown'
        };
    }

    /**
     * Get approval status label
     */
    public function getApprovalStatusLabelAttribute(): string
    {
        return match($this->approval_status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Unknown'
        };
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
            ->where('status', 'accepted')
            ->forUserActiveSession($this); // Filter by user's active session
    }

    /**
     * Get all accepted connections for this user (both as requester and receiver)
     */
    public function allConnections()
    {
        return Connection::where(function ($query) {
            $query->where('requester_id', $this->id)
                ->orWhere('receiver_id', $this->id);
        })
        ->where('status', 'accepted')
        ->forUserActiveSession($this); // Filter by user's active session
    }

    /**
     * Get all accepted connections for this user (both as requester and receiver) as a collection
     */
    public function getAllConnections()
    {
        return $this->allConnections()->get();
    }

    /**
     * Get all accepted connections for this user (both as requester and receiver) as a collection
     * This version handles both old connections without session and new ones with session
     */
    public function getAllConnectionsFlexible()
    {
        $query = Connection::where(function ($query) {
            $query->where('requester_id', $this->id)
                ->orWhere('receiver_id', $this->id);
        })
        ->where('status', 'accepted');

        // If user has active session, filter by it, otherwise show all connections
        if ($this->hasActivePasarKolaboraya()) {
            $query->where(function ($q) {
                $q->where('pasar_kolaboraya_id', $this->active_pasar_kolaboraya_id)
                  ->orWhereNull('pasar_kolaboraya_id'); // Include old connections without session
            });
        }

        return $query->get();
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
            ->where('status', 'pending')
            ->forUserActiveSession($this); // Filter by user's active session
    }

    public function pendingSentConnections(){
        return $this->hasMany(Connection::class, 'requester_id')
            ->where('requester_id', $this->id)
            ->where('status', 'pending')
            ->forUserActiveSession($this); // Filter by user's active session
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
        // Filter by users in the same active session
        return User::whereHas('profile', function ($query) use ($userInterests) {
            $query->whereHas('interests', function ($subQuery) use ($userInterests) {
                $subQuery->whereIn('interests.id', $userInterests);
            });
        })
            ->where('id', '!=', $this->id)
            ->where('active_pasar_kolaboraya_id', $this->active_pasar_kolaboraya_id) // Filter by same active session
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
        // Filter by users in the same active session
        return User::whereHas('profile', function ($query) use ($userSkills) {
            $query->whereHas('skills', function ($subQuery) use ($userSkills) {
                $subQuery->whereIn('skills.id', $userSkills);
            });
        })
            ->where('id', '!=', $this->id)
            ->where('active_pasar_kolaboraya_id', $this->active_pasar_kolaboraya_id) // Filter by same active session
            ->limit($limit)
            ->get();
    }

    /**
     * Get recommended users based on event participation
     */
    public function getEventBasedRecommendations($limit = 5)
    {
        $userEventIds = $this->events()->pluck('event_id');

        if ($userEventIds->isEmpty()) {
            return collect();
        }

        // Get users who participated in the same events
        // Filter by users in the same active session
        return User::whereHas('events', function ($query) use ($userEventIds) {
            $query->whereIn('event_id', $userEventIds);
        })
            ->where('id', '!=', $this->id)
            ->where('active_pasar_kolaboraya_id', $this->active_pasar_kolaboraya_id) // Filter by same active session
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

        // Get IDs of current user's friends in the same active session
        $myFriendIds = $this->connections()
            ->where('status', 'accepted')
            ->forUserActiveSession($this) // Filter by user's active session
            ->pluck('receiver_id')
            ->toArray();

        if (empty($myFriendIds)) {
            return collect();
        }

        // Get users who are friends with my friends but not with me
        // Filter by users in the same active session
        return User::whereHas('connections', function ($query) use ($myFriendIds) {
            $query->whereIn('receiver_id', $myFriendIds)
                ->where('status', 'accepted');
        })
            ->where('id', '!=', $currentUserId)
            ->where('active_pasar_kolaboraya_id', $this->active_pasar_kolaboraya_id) // Filter by same active session
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

        // Check if already connected - filter by active session
        $existingConnection = Connection::where(function ($query) use ($otherUserId, $currentUserId) {
            $query->where('requester_id', $currentUserId)
                ->where('receiver_id', $otherUserId);
        })->orWhere(function ($query) use ($otherUserId, $currentUserId) {
            $query->where('requester_id', $otherUserId)
                ->where('receiver_id', $currentUserId);
        })
        ->forUserActiveSession($this) // Filter by user's active session
        ->first();

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
     * Get ecosystem contributions made by this user
     */
    public function ecosystemContributions(): HasMany
    {
        return $this->hasMany(EcosystemContribution::class);
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
     * Get the active Pasar Kolaboraya for this user
     */
    public function activePasarKolaboraya(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PasarKolaboraya::class, 'active_pasar_kolaboraya_id');
    }

    /**
     * Get all Pasar Kolaboraya this user is part of
     */
    public function pasarKolaborayas(): BelongsToMany
    {
        return $this->belongsToMany(PasarKolaboraya::class, 'pasar_kolaboraya_users')
                    ->withPivot(['status', 'role', 'invited_by', 'join_reason', 'admin_notes', 'joined_at', 'responded_at'])
                    ->withTimestamps();
    }

    /**
     * Get accepted Pasar Kolaboraya for this user
     */
    public function acceptedPasarKolaborayas(): BelongsToMany
    {
        return $this->pasarKolaborayas()->wherePivot('status', 'accepted');
    }

    /**
     * Get pending Pasar Kolaboraya requests for this user
     */
    public function pendingPasarKolaborayas(): BelongsToMany
    {
        return $this->pasarKolaborayas()->wherePivot('status', 'pending');
    }

    /**
     * Get admin Pasar Kolaboraya for this user
     */
    public function adminPasarKolaborayas(): BelongsToMany
    {
        return $this->pasarKolaborayas()->wherePivot('role', 'admin')->wherePivot('status', 'accepted');
    }

    /**
     * Get member Pasar Kolaboraya for this user
     */
    public function memberPasarKolaborayas(): BelongsToMany
    {
        return $this->pasarKolaborayas()->wherePivot('role', 'member')->wherePivot('status', 'accepted');
    }

    /**
     * Check if user has any Pasar Kolaboraya
     */
    public function hasPasarKolaborayas(): bool
    {
        return $this->acceptedPasarKolaborayas()->exists();
    }

    /**
     * Check if user has active Pasar Kolaboraya
     */
    public function hasActivePasarKolaboraya(): bool
    {
        return !is_null($this->active_pasar_kolaboraya_id);
    }

    /**
     * Set active Pasar Kolaboraya
     */
    public function setActivePasarKolaboraya(PasarKolaboraya $pasarKolaboraya): bool
    {
        // Check if user is member of this Pasar Kolaboraya
        if (!$pasarKolaboraya->isUserMember($this)) {
            return false;
        }

        $this->update(['active_pasar_kolaboraya_id' => $pasarKolaboraya->id]);
        return true;
    }

    /**
     * Clear active Pasar Kolaboraya
     */
    public function clearActivePasarKolaboraya(): void
    {
        $this->update(['active_pasar_kolaboraya_id' => null]);
    }

    /**
     * Get users in the same active Pasar Kolaboraya
     */
    public function getUsersInActivePasarKolaboraya()
    {
        if (!$this->hasActivePasarKolaboraya()) {
            return collect();
        }

        return $this->activePasarKolaboraya->acceptedUsers()
            ->where('users.id', '!=', $this->id);
    }

    /**
     * Scope to filter users by PasarKolaboraya session
     * Only show users that belong to the specified session
     */
    public function scopeForPasarKolaboraya($query, $pasarKolaborayaId)
    {
        return $query->where('active_pasar_kolaboraya_id', $pasarKolaborayaId);
    }

    /**
     * Scope to filter users by user's active PasarKolaboraya session
     */
    public function scopeForUserActiveSession($query, User $user)
    {
        if (!$user->hasActivePasarKolaboraya()) {
            return $query->whereRaw('1 = 0'); // Return empty result
        }
        
        return $query->forPasarKolaboraya($user->active_pasar_kolaboraya_id);
    }

    /**
     * Check if user is contributor of a collective action
     */
    public function isContributorOfCollectiveAction(CollectiveAction $collectiveAction): bool
    {
        return $collectiveAction->isUserContributor($this);
    }

    /**
     * Get the active container for this user
     */
    public function activeContainer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Container::class, 'active_container_id');
    }

    /**
     * Get all containers this user is part of
     */
    public function containers(): BelongsToMany
    {
        return $this->belongsToMany(Container::class, 'container_users')
                    ->withPivot(['role', 'status', 'joined_at'])
                    ->withTimestamps();
    }

    /**
     * Get accepted containers for this user
     */
    public function acceptedContainers(): BelongsToMany
    {
        return $this->containers()->wherePivot('status', 'active');
    }

    /**
     * Get admin containers for this user
     */
    public function adminContainers(): BelongsToMany
    {
        return $this->containers()->wherePivot('role', 'admin')->wherePivot('status', 'active');
    }

    /**
     * Get member containers for this user
     */
    public function memberContainers(): BelongsToMany
    {
        return $this->containers()->wherePivot('role', 'member')->wherePivot('status', 'active');
    }

    /**
     * Check if user has any containers
     */
    public function hasContainers(): bool
    {
        return $this->acceptedContainers()->exists();
    }

    /**
     * Check if user has active container
     */
    public function hasActiveContainer(): bool
    {
        return !is_null($this->active_container_id);
    }

    /**
     * Set active container
     */
    public function setActiveContainer(Container $container): bool
    {
        // Check if user is member of this container
        if (!$container->isUserMember($this)) {
            return false;
        }

        $this->update(['active_container_id' => $container->id]);
        return true;
    }

    /**
     * Clear active container
     */
    public function clearActiveContainer(): void
    {
        $this->update(['active_container_id' => null]);
    }

    /**
     * Generate QR code for user access
     */
    public function generateQrCode(): string
    {
        $qrCode = 'PK_' . $this->id . '_' . time() . '_' . Str::random(16);
        
        $this->update([
            'qr_code' => $qrCode,
            'qr_code_generated_at' => now(),
        ]);
        
        return $qrCode;
    }

    /**
     * Get QR code data for display
     */
    public function getQrCodeData(): array
    {
        if (!$this->qr_code) {
            $this->generateQrCode();
        }
        
        return [
            'qr_code' => $this->qr_code,
            'user_id' => $this->id,
            'user_name' => $this->name,
            'user_email' => $this->email,
            'generated_at' => $this->qr_code_generated_at,
            'expires_at' => $this->qr_code_generated_at ? $this->qr_code_generated_at->addDays(30) : null,
        ];
    }

    /**
     * Check if QR code is valid and not expired
     */
    public function isQrCodeValid(): bool
    {
        if (!$this->qr_code || !$this->qr_code_generated_at) {
            return false;
        }
        
        // QR code expires after 30 days
        return true;
    }

    /**
     * Get users in the same active container
     */
    public function getUsersInActiveContainer()
    {
        if (!$this->hasActiveContainer()) {
            return collect();
        }

        return $this->activeContainer->activeUsers()
            ->where('users.id', '!=', $this->id);
    }

    /**
     * Get user's notifications
     */
    public function notifications()
    {
        return $this->morphMany(\App\Models\Notification::class, 'notifiable');
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadNotificationsCountAttribute(): int
    {
        return $this->notifications()->where('is_read', false)->count();
    }

    /**
     * Get assigned role label
     */
    public function getAssignedRoleLabelAttribute(): string
    {
        if ($this->is_ecosystem_builder) {
            return 'Ekosistem Builder';
        }
        
        if ($this->assigned_role) {
            return $this->assigned_role;
        }
        
        return 'Belum Dipilih';
    }

    /**
     * Check if user has assigned role
     */
    public function hasAssignedRole(): bool
    {
        return $this->is_ecosystem_builder || !empty($this->assigned_role);
    }

    /**
     * Get role display information
     */
    public function getRoleDisplayInfo(): array
    {
        if ($this->is_ecosystem_builder) {
            return [
                'type' => 'ecosystem_builder',
                'label' => 'Ekosistem Builder',
                'color' => 'purple',
                'approved_at' => $this->ecosystem_builder_approved_at,
            ];
        }
        
        if ($this->assigned_role) {
            return [
                'type' => 'assigned_role',
                'label' => $this->assigned_role,
                'color' => 'indigo',
                'approved_at' => null,
            ];
        }
        
        return [
            'type' => 'none',
            'label' => 'Belum Dipilih',
            'color' => 'gray',
            'approved_at' => null,
        ];
    }
}
