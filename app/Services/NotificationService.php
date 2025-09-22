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

    /**
     * Create collective action join request notification for collective action admins
     */
    public function createCollectiveActionJoinRequestNotification(\App\Models\CollectiveAction $collectiveAction, User $joiningUser, string $joinReason, string $requestedRole): array
    {
        $admins = $collectiveAction->adminUsers;
        $notifications = [];
        
        foreach ($admins as $admin) {
            $notifications[] = $this->createNotification(
                $admin,
                'Permintaan Bergabung Aksi Kolektif',
                "{$joiningUser->name} ingin bergabung dengan aksi kolektif '{$collectiveAction->title}' sebagai {$requestedRole}. Alasan: {$joinReason}",
                route('collective-action.user-approvals', $collectiveAction),
                [
                    'collective_action_id' => $collectiveAction->id,
                    'collective_action_name' => $collectiveAction->title,
                    'joining_user_id' => $joiningUser->id,
                    'joining_user_name' => $joiningUser->name,
                    'join_reason' => $joinReason,
                    'requested_role' => $requestedRole,
                    'type' => 'collective_action_join_request'
                ]
            );
        }

        return $notifications;
    }

    /**
     * Create collective action join approval notification for user
     */
    public function createCollectiveActionJoinApprovalNotification(User $user, \App\Models\CollectiveAction $collectiveAction, User $approver, string $adminNotes = null): Notification
    {
        $message = "Permintaan bergabung Anda dengan aksi kolektif '{$collectiveAction->title}' telah disetujui oleh {$approver->name}.";
        if ($adminNotes) {
            $message .= " Catatan admin: {$adminNotes}";
        }

        return $this->createNotification(
            $user,
            'Permintaan Bergabung Disetujui',
            $message,
            route('collective-action.show', $collectiveAction),
            [
                'collective_action_id' => $collectiveAction->id,
                'collective_action_name' => $collectiveAction->title,
                'approver_id' => $approver->id,
                'approver_name' => $approver->name,
                'admin_notes' => $adminNotes,
                'type' => 'collective_action_join_approved'
            ]
        );
    }

    /**
     * Create collective action join rejection notification for user
     */
    public function createCollectiveActionJoinRejectionNotification(User $user, \App\Models\CollectiveAction $collectiveAction, User $approver, string $adminNotes = null): Notification
    {
        $message = "Permintaan bergabung Anda dengan aksi kolektif '{$collectiveAction->title}' telah ditolak oleh {$approver->name}.";
        if ($adminNotes) {
            $message .= " Alasan: {$adminNotes}";
        }

        return $this->createNotification(
            $user,
            'Permintaan Bergabung Ditolak',
            $message,
            route('collective-action.browse'),
            [
                'collective_action_id' => $collectiveAction->id,
                'collective_action_name' => $collectiveAction->title,
                'approver_id' => $approver->id,
                'approver_name' => $approver->name,
                'admin_notes' => $adminNotes,
                'type' => 'collective_action_join_rejected'
            ]
        );
    }

    /**
     * Create collective action invitation notification for ecosystem
     */
    public function createCollectiveActionInvitationNotification(\App\Models\Ecosystem $ecosystem, \App\Models\CollectiveAction $collectiveAction, User $inviter): array
    {
        $users = $ecosystem->acceptedUsers;
        $notifications = [];
        
        foreach ($users as $user) {
            $notifications[] = $this->createNotification(
                $user,
                'Undangan Aksi Kolektif',
                "Ekosistem '{$ecosystem->ecosystem_title}' diundang untuk bergabung dengan aksi kolektif '{$collectiveAction->title}' oleh {$inviter->name}.",
                route('collective-action.respond-invitation', ['invitation' => $collectiveAction->invitations()->where('ecosystem_id', $ecosystem->id)->first()]),
                [
                    'collective_action_id' => $collectiveAction->id,
                    'collective_action_name' => $collectiveAction->title,
                    'ecosystem_id' => $ecosystem->id,
                    'ecosystem_name' => $ecosystem->ecosystem_title,
                    'inviter_id' => $inviter->id,
                    'inviter_name' => $inviter->name,
                    'type' => 'collective_action_invitation'
                ]
            );
        }

        return $notifications;
    }

    /**
     * Create collective action status update notification for all members
     */
    public function createCollectiveActionStatusUpdateNotification(\App\Models\CollectiveAction $collectiveAction, string $oldStatus, string $newStatus, User $updater): array
    {
        $statusLabels = [
            'planning' => 'Perencanaan',
            'active' => 'Aktif',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'paused' => 'Dijeda'
        ];

        $oldStatusLabel = $statusLabels[$oldStatus] ?? $oldStatus;
        $newStatusLabel = $statusLabels[$newStatus] ?? $newStatus;

        return $this->createBulkCollectiveActionNotification(
            $collectiveAction->id,
            'Status Aksi Kolektif Diperbarui',
            "Status aksi kolektif '{$collectiveAction->title}' telah diubah dari {$oldStatusLabel} menjadi {$newStatusLabel} oleh {$updater->name}.",
            route('collective-action.show', $collectiveAction),
            [
                'collective_action_id' => $collectiveAction->id,
                'collective_action_name' => $collectiveAction->title,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'updater_id' => $updater->id,
                'updater_name' => $updater->name,
                'type' => 'collective_action_status_update'
            ]
        );
    }

    /**
     * Create collective action contribution notification for admins
     */
    public function createCollectiveActionContributionNotification(\App\Models\CollectiveAction $collectiveAction, User $contributor, array $contributionData): array
    {
        $admins = $collectiveAction->adminUsers;
        $notifications = [];
        
        $contributionType = $contributionData['contribution_type'] ?? 'Kontribusi';
        $description = $contributionData['contribution_description'] ?? 'Tidak ada deskripsi';
        
        foreach ($admins as $admin) {
            $notifications[] = $this->createNotification(
                $admin,
                'Kontribusi Baru',
                "{$contributor->name} menawarkan {$contributionType} untuk aksi kolektif '{$collectiveAction->title}': {$description}",
                route('collective-action.show', $collectiveAction).'?activeTab=contributions',
                [
                    'collective_action_id' => $collectiveAction->id,
                    'collective_action_name' => $collectiveAction->title,
                    'contributor_id' => $contributor->id,
                    'contributor_name' => $contributor->name,
                    'contribution_type' => $contributionType,
                    'contribution_description' => $description,
                    'type' => 'collective_action_contribution'
                ]
            );
        }

        return $notifications;
    }

    /**
     * Create collective action contribution approval notification for contributor
     */
    public function createCollectiveActionContributionApprovalNotification(User $contributor, \App\Models\CollectiveAction $collectiveAction, User $approver, string $adminNotes = null): Notification
    {
        $message = "Kontribusi Anda untuk aksi kolektif '{$collectiveAction->title}' telah disetujui oleh {$approver->name}.";
        if ($adminNotes) {
            $message .= " Catatan admin: {$adminNotes}";
        }

        return $this->createNotification(
            $contributor,
            'Kontribusi Disetujui',
            $message,
            route('collective-action.show', $collectiveAction),
            [
                'collective_action_id' => $collectiveAction->id,
                'collective_action_name' => $collectiveAction->title,
                'approver_id' => $approver->id,
                'approver_name' => $approver->name,
                'admin_notes' => $adminNotes,
                'type' => 'collective_action_contribution_approved'
            ]
        );
    }

    /**
     * Create collective action contribution rejection notification for contributor
     */
    public function createCollectiveActionContributionRejectionNotification(User $contributor, \App\Models\CollectiveAction $collectiveAction, User $approver, string $adminNotes = null): Notification
    {
        $message = "Kontribusi Anda untuk aksi kolektif '{$collectiveAction->title}' telah ditolak oleh {$approver->name}.";
        if ($adminNotes) {
            $message .= " Alasan: {$adminNotes}";
        }

        return $this->createNotification(
            $contributor,
            'Kontribusi Ditolak',
            $message,
            route('collective-action.show', $collectiveAction),
            [
                'collective_action_id' => $collectiveAction->id,
                'collective_action_name' => $collectiveAction->title,
                'approver_id' => $approver->id,
                'approver_name' => $approver->name,
                'admin_notes' => $adminNotes,
                'type' => 'collective_action_contribution_rejected'
            ]
        );
    }

    /**
     * Create collective action reminder notification for all members
     */
    public function createCollectiveActionReminderNotification(\App\Models\CollectiveAction $collectiveAction, string $reminderMessage, User $sender): array
    {
        return $this->createBulkCollectiveActionNotification(
            $collectiveAction->id,
            'Pengingat Aksi Kolektif',
            $reminderMessage,
            route('collective-action.show', $collectiveAction),
            [
                'collective_action_id' => $collectiveAction->id,
                'collective_action_name' => $collectiveAction->title,
                'sender_id' => $sender->id,
                'sender_name' => $sender->name,
                'type' => 'collective_action_reminder'
            ]
        );
    }

    /**
     * Create collective action deadline reminder notification
     */
    public function createCollectiveActionDeadlineReminderNotification(\App\Models\CollectiveAction $collectiveAction, string $deadlineType = 'end_date'): array
    {
        $deadline = $deadlineType === 'end_date' ? $collectiveAction->end_date : $collectiveAction->start_date;
        $deadlineLabel = $deadlineType === 'end_date' ? 'berakhir' : 'dimulai';
        
        if (!$deadline || !($deadline instanceof \Carbon\Carbon)) {
            return [];
        }
        
        $message = "Aksi kolektif '{$collectiveAction->title}' akan {$deadlineLabel} pada " . $deadline->format('d F Y') . ". Pastikan semua tugas telah diselesaikan.";

        return $this->createBulkCollectiveActionNotification(
            $collectiveAction->id,
            'Pengingat Deadline Aksi Kolektif',
            $message,
            route('collective-action.show', $collectiveAction),
            [
                'collective_action_id' => $collectiveAction->id,
                'collective_action_name' => $collectiveAction->title,
                'deadline_type' => $deadlineType,
                'deadline_date' => $deadline->toDateString(),
                'type' => 'collective_action_deadline_reminder'
            ]
        );
    }

    /**
     * Create ecosystem acceptance notification for user
     */
    public function createEcosystemAcceptanceNotification(User $user, \App\Models\Ecosystem $ecosystem, User $approver): Notification
    {
        return $this->createNotification(
            $user,
            'Bergabung dengan Ekosistem',
            "Permintaan bergabung Anda dengan ekosistem '{$ecosystem->ecosystem_title}' telah disetujui oleh {$approver->name}. Selamat bergabung!",
            route('ecosystem.dashboard', $ecosystem),
            [
                'ecosystem_id' => $ecosystem->id,
                'ecosystem_name' => $ecosystem->ecosystem_title,
                'approver_id' => $approver->id,
                'approver_name' => $approver->name,
                'type' => 'ecosystem_acceptance'
            ]
        );
    }

    /**
     * Create ecosystem rejection notification for user
     */
    public function createEcosystemRejectionNotification(User $user, \App\Models\Ecosystem $ecosystem, User $approver): Notification
    {
        return $this->createNotification(
            $user,
            'Permintaan Bergabung Ditolak',
            "Permintaan bergabung Anda dengan ekosistem '{$ecosystem->ecosystem_title}' telah ditolak oleh {$approver->name}.",
            route('ecosystem.browse'),
            [
                'ecosystem_id' => $ecosystem->id,
                'ecosystem_name' => $ecosystem->ecosystem_title,
                'approver_id' => $approver->id,
                'approver_name' => $approver->name,
                'type' => 'ecosystem_rejection'
            ]
        );
    }
}
