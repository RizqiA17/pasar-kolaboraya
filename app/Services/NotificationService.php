<?php

namespace App\Services;

use App\Events\NotificationCreated;
use App\Events\NotificationUpdated;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Create a new notification for a user
     */
    public function createNotification(User $user, string $title, string $message, ?string $redirectUrl = null, array $data = []): Notification
    {
        $notification = Notification::create([
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'type' => 'custom',
            'title' => $title,
            'message' => $message,
            'redirect_url' => $redirectUrl,
            'data' => $data,
            'is_read' => false,
        ]);

        // Broadcast the notification
        broadcast(new NotificationCreated($notification));

        return $notification;
    }

    /**
     * Create notifications for multiple users
     */
    public function createBulkNotifications(array $userIds, string $title, string $message, ?string $redirectUrl = null, array $data = []): array
    {
        $notifications = [];
        
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                $notifications[] = $this->createNotification($user, $title, $message, $redirectUrl, $data);
            }
        }

        return $notifications;
    }

    /**
     * Create notification for all users in a Pasar Kolaboraya
     */
    public function createPasarKolaborayaNotification(int $pasarKolaborayaId, string $title, string $message, ?string $redirectUrl = null, array $data = []): array
    {
        $users = User::where('active_pasar_kolaboraya_id', $pasarKolaborayaId)->get();
        
        $notifications = [];
        foreach ($users as $user) {
            $notifications[] = $this->createNotification($user, $title, $message, $redirectUrl, $data);
        }

        return $notifications;
    }

    /**
     * Create notification for all users in an ecosystem
     */
    public function createEcosystemNotification(int $ecosystemId, string $title, string $message, ?string $redirectUrl = null, array $data = []): array
    {
        $ecosystem = \App\Models\Ecosystem::find($ecosystemId);
        if (!$ecosystem) {
            return [];
        }

        $users = $ecosystem->acceptedUsers;
        
        $notifications = [];
        foreach ($users as $user) {
            $notifications[] = $this->createNotification($user, $title, $message, $redirectUrl, $data);
        }

        return $notifications;
    }

    /**
     * Create notification for all users in a collective action
     */
    public function createBulkCollectiveActionNotification(int $collectiveActionId, string $title, string $message, ?string $redirectUrl = null, array $data = []): array
    {
        $collectiveAction = \App\Models\CollectiveAction::find($collectiveActionId);
        if (!$collectiveAction) {
            return [];
        }

        $users = $collectiveAction->activeUsers;
        
        $notifications = [];
        foreach ($users as $user) {
            $notifications[] = $this->createNotification($user, $title, $message, $redirectUrl, $data);
        }

        return $notifications;
    }

    /**
     * Mark notification as read and broadcast update
     */
    public function markAsRead(Notification $notification): bool
    {
        $result = $notification->markAsRead();
        
        if ($result) {
            broadcast(new NotificationUpdated($notification));
        }

        return $result;
    }

    /**
     * Mark notification as unread and broadcast update
     */
    public function markAsUnread(Notification $notification): bool
    {
        $result = $notification->markAsUnread();
        
        if ($result) {
            broadcast(new NotificationUpdated($notification));
        }

        return $result;
    }

    /**
     * Create connection request notification
     */
    public function createConnectionRequestNotification(User $receiver, User $sender): Notification
    {
        return $this->createNotification(
            $receiver,
            'Permintaan Koneksi Baru',
            "{$sender->name} mengirimkan permintaan koneksi kepada Anda.",
            route('connections'),
            [
                'sender_id' => $sender->id,
                'sender_name' => $sender->name,
                'type' => 'connection_request'
            ]
        );
    }

    /**
     * Create connection accepted notification
     */
    public function createConnectionAcceptedNotification(User $receiver, User $sender): Notification
    {
        return $this->createNotification(
            $receiver,
            'Koneksi Diterima',
            "{$sender->name} telah menerima permintaan koneksi Anda.",
            route('connections'),
            [
                'sender_id' => $sender->id,
                'sender_name' => $sender->name,
                'type' => 'connection_accepted'
            ]
        );
    }

    /**
     * Create ecosystem invitation notification
     */
    public function createEcosystemInvitationNotification(User $user, \App\Models\Ecosystem $ecosystem, User $inviter): Notification
    {
        return $this->createNotification(
            $user,
            'Undangan Ekosistem',
            "{$inviter->name} mengundang Anda untuk bergabung dengan ekosistem '{$ecosystem->name}'.",
            route('ecosystem.join', $ecosystem),
            [
                'ecosystem_id' => $ecosystem->id,
                'ecosystem_name' => $ecosystem->name,
                'inviter_id' => $inviter->id,
                'inviter_name' => $inviter->name,
                'type' => 'ecosystem_invitation'
            ]
        );
    }

    /**
     * Create collective action notification
     */
    public function createCollectiveActionNotification(User $user, \App\Models\CollectiveAction $collectiveAction, string $message, ?string $redirectUrl = null): Notification
    {
        return $this->createNotification(
            $user,
            'Aksi Kolektif',
            $message,
            $redirectUrl ?? route('collective-action.show', $collectiveAction),
            [
                'collective_action_id' => $collectiveAction->id,
                'collective_action_name' => $collectiveAction->name,
                'type' => 'collective_action'
            ]
        );
    }

    /**
     * Create ecosystem join request notification for ecosystem owner
     */
    public function createEcosystemJoinRequestNotification(User $ecosystemOwner, \App\Models\Ecosystem $ecosystem, User $joiningUser, string $joinReason): Notification
    {
        return $this->createNotification(
            $ecosystemOwner,
            'Permintaan Bergabung Ekosistem',
            "{$joiningUser->name} ingin bergabung dengan ekosistem '{$ecosystem->ecosystem_title}'. Alasan: {$joinReason}",
            route('ecosystem.dashboard', $ecosystem).'?activeTab=members',
            [
                'ecosystem_id' => $ecosystem->id,
                'ecosystem_name' => $ecosystem->ecosystem_title,
                'joining_user_id' => $joiningUser->id,
                'joining_user_name' => $joiningUser->name,
                'join_reason' => $joinReason,
                'type' => 'ecosystem_join_request'
            ]
        );
    }
}
