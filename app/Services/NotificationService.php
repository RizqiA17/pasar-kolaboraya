<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationReceiver;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    /**
     * Create notification event and deliver to users
     */
    public function create(
        string $type,
        string $message,
        array $receivers,
        ?string $title = null,
        array $data = []
    ): Notification {
        return DB::transaction(function () use ($type, $message, $receivers, $title, $data) {

            $notification = Notification::create([
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => $data,
            ]);

            $rows = [];
            $now = now();

            foreach ($receivers as $user) {
                $rows[] = [
                    'notification_id' => $notification->id,
                    'user_id' => $user->id,
                    'is_read' => false,
                    'read_at' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            NotificationReceiver::insert($rows);

            return $notification;
        });
    }

    /**
     * Send notification to single user
     */
    public function toUser(
        User $user,
        string $type,
        string $message,
        ?string $title = null,
        array $data = []
    ): Notification {
        return $this->create(
            $type,
            $message,
            [$user],
            $title,
            $data
        );
    }

    /**
     * Send notification to multiple users
     */
    public function toUsers(
        iterable $users,
        string $type,
        string $message,
        ?string $title = null,
        array $data = []
    ): Notification {
        return $this->create(
            $type,
            $message,
            $users,
            $title,
            $data
        );
    }

    /**
     * Group join request -> all group admins
     */
    public function groupJoinRequest(
        User $requester,
        $group
    ): Notification {
        $admins = $group->admins;

        return $this->create(
            'group_join_request',
            "{$requester->name} ingin bergabung ke grup {$group->name}.",
            $admins,
            'Permintaan Bergabung Grup',
            [
                'group_id' => $group->id,
                'group_name' => $group->name,
                'requester_id' => $requester->id,
                'requester_name' => $requester->name,
            ]
        );
    }

    /**
     * Group join approved -> user
     */
    public function groupJoinApproved(
        User $user,
        User $approver,
        $group
    ): Notification {
        return $this->toUser(
            $user,
            'group_join_approved',
            "Permintaan bergabung ke grup {$group->name} telah disetujui oleh {$approver->name}.",
            'Permintaan Disetujui',
            [
                'group_id' => $group->id,
                'group_name' => $group->name,
                'approver_id' => $approver->id,
                'approver_name' => $approver->name,
            ]
        );
    }

    /**
     * Group join rejected -> user
     */
    public function groupJoinRejected(
        User $user,
        User $approver,
        $group,
        ?string $reason = null
    ): Notification {
        $message = "Permintaan bergabung ke grup {$group->name} ditolak oleh {$approver->name}.";

        if ($reason) {
            $message .= " Alasan: {$reason}";
        }

        return $this->toUser(
            $user,
            'group_join_rejected',
            $message,
            'Permintaan Ditolak',
            [
                'group_id' => $group->id,
                'group_name' => $group->name,
                'approver_id' => $approver->id,
                'approver_name' => $approver->name,
                'reason' => $reason,
            ]
        );
    }
}
