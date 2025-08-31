<?php

namespace App\Services;

use App\Models\Collaboration;
use App\Models\CollaborationUser;
use App\Models\User;
use App\Notifications\CollaborationInvitation;
use App\Notifications\CollaborationStatusUpdate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CollaborationService
{
    /**
     * Create a new collaboration and invite users
     */
    public function createCollaboration(array $data, User $creator, array $invitedUserIds = [])
    {
        try {
            DB::beginTransaction();

            // Create collaboration
            $collaboration = Collaboration::create([
                'created_by' => $creator->id,
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'status' => 'pending'
            ]);

            // Add creator as accepted member
            CollaborationUser::create([
                'collaboration_id' => $collaboration->id,
                'user_id' => $creator->id,
                'status' => 'accepted'
            ]);

            // Invite users
            if (!empty($invitedUserIds)) {
                $this->inviteUsers($collaboration, $invitedUserIds, $creator);
            }

            DB::commit();
            return $collaboration;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create collaboration: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Invite users to a collaboration
     */
    public function inviteUsers(Collaboration $collaboration, array $userIds, User $inviter)
    {
        foreach ($userIds as $userId) {
            // Check if user is already invited
            $existingInvitation = CollaborationUser::where('collaboration_id', $collaboration->id)
                ->where('user_id', $userId)
                ->first();

            if (!$existingInvitation) {
                // Create invitation
                CollaborationUser::create([
                    'collaboration_id' => $collaboration->id,
                    'user_id' => $userId,
                    'status' => 'pending'
                ]);

                // Send notification
                $user = User::find($userId);
                if ($user) {
                    $user->notify(new CollaborationInvitation($collaboration, $inviter));
                }
            }
        }
    }

    /**
     * Accept collaboration invitation
     */
    public function acceptInvitation(Collaboration $collaboration, User $user)
    {
        $collaborationUser = CollaborationUser::where('collaboration_id', $collaboration->id)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if (!$collaborationUser) {
            throw new \Exception('No pending invitation found for this user');
        }

        $collaborationUser->update(['status' => 'accepted']);

        // Notify collaboration creator
        $creator = $collaboration->creator;
        if ($creator) {
            $creator->notify(new CollaborationStatusUpdate($collaboration, $user, 'accepted', 'accepted'));
        }

        return $collaborationUser;
    }

    /**
     * Decline collaboration invitation (soft delete)
     */
    public function declineInvitation(Collaboration $collaboration, User $user)
    {
        $collaborationUser = CollaborationUser::where('collaboration_id', $collaboration->id)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if (!$collaborationUser) {
            throw new \Exception('No pending invitation found for this user');
        }

        $collaborationUser->update(['status' => 'declined']);

        // Notify collaboration creator
        $creator = $collaboration->creator;
        if ($creator) {
            $creator->notify(new CollaborationStatusUpdate($collaboration, $user, 'declined', 'declined'));
        }

        return $collaborationUser;
    }

    /**
     * Remove user from collaboration (soft delete)
     */
    public function removeUser(Collaboration $collaboration, User $user)
    {
        $collaborationUser = CollaborationUser::where('collaboration_id', $collaboration->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$collaborationUser) {
            throw new \Exception('User is not part of this collaboration');
        }

        // Soft delete the record
        $collaborationUser->delete();

        return true;
    }

    /**
     * Get collaboration statistics
     */
    public function getCollaborationStats(Collaboration $collaboration)
    {
        return [
            'total_invited' => $collaboration->collaborationUsers()->count(),
            'pending_invitations' => $collaboration->pendingInvitations()->count(),
            'accepted_members' => $collaboration->acceptedMembers()->count(),
            'declined_invitations' => $collaboration->declinedInvitations()->count(),
        ];
    }

    /**
     * Check if collaboration can be activated
     */
    public function canActivateCollaboration(Collaboration $collaboration)
    {
        $acceptedMembers = $collaboration->acceptedMembers()->count();
        return $acceptedMembers >= 2; // At least creator + 1 member
    }

    /**
     * Activate collaboration
     */
    public function activateCollaboration(Collaboration $collaboration)
    {
        if (!$this->canActivateCollaboration($collaboration)) {
            throw new \Exception('Collaboration needs at least 2 members to be activated');
        }

        $collaboration->update(['status' => 'active']);
        return $collaboration;
    }
}
