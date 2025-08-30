<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaboration extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by',
        'title',
        'description',
        'status',
    ];

    /**
     * Get the creator of the collaboration
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all collaboration users with their status
     */
    public function collaborationUsers()
    {
        return $this->hasMany(CollaborationUser::class);
    }

    /**
     * Get pending invitations
     */
    public function pendingInvitations()
    {
        return $this->collaborationUsers()->pending();
    }

    /**
     * Get accepted members
     */
    public function acceptedMembers()
    {
        return $this->collaborationUsers()->accepted();
    }

    /**
     * Get declined invitations
     */
    public function declinedInvitations()
    {
        return $this->collaborationUsers()->declined();
    }

    /**
     * Get all members (users who accepted)
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'collaboration_user')
            ->wherePivot('status', 'accepted')
            ->withTimestamps();
    }

    /**
     * Get all invited users (including pending and declined)
     */
    public function invitedUsers()
    {
        return $this->belongsToMany(User::class, 'collaboration_user')
            ->withPivot('status')
            ->withTimestamps();
    }

    /**
     * Check if user is a member
     */
    public function isMember(User $user)
    {
        return $this->collaborationUsers()
            ->where('user_id', $user->id)
            ->where('status', 'accepted')
            ->exists();
    }

    /**
     * Check if user has pending invitation
     */
    public function hasPendingInvitation(User $user)
    {
        return $this->collaborationUsers()
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();
    }

    /**
     * Check if user has declined invitation
     */
    public function hasDeclinedInvitation(User $user)
    {
        return $this->collaborationUsers()
            ->where('user_id', $user->id)
            ->where('status', 'declined')
            ->exists();
    }

    /**
     * Get the collaboration user relationship for a specific user
     */
    public function getCollaborationUser(User $user)
    {
        return $this->collaborationUsers()
            ->where('user_id', $user->id)
            ->first();
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}


