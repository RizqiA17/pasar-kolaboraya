<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use App\Models\NotificationReceiver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class NotificationService
{
    public function send(array $users, string $type, string $message, array $options = []): void
    {
        DB::transaction(function () use ($users, $type, $message, $options) {
            $notification = Notification::create([
                'id' => (string) Str::uuid(),
                'type' => $type,
                'title' => $options['title'] ?? null,
                'message' => $message,
                'redirect_url' => $options['redirect_url'] ?? null,
            ]);

            $now = now();

            $receivers = collect($users)->map(function ($userId) use ($notification, $now) {
                return [
                    'notification_id' => $notification->id,
                    'user_id' => $userId,
                    'is_read' => false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })->all();

            NotificationReceiver::insert($receivers);

            foreach ($users as $userId) {
                Cache::tags("notification:{$userId}")->flush();
            }
        });
    }

    protected function pushToRedis(int $userId, NotificationReceiver $receiver, Notification $notification): void
    {
        $payload = [
            'id' => $receiver->id,
            'notification_id' => $notification->id,
            'type' => $notification->type,
            'title' => $notification->title,
            'message' => $notification->message,
            'redirect_url' => $notification->redirect_url,
            'is_read' => false,
            'created_at' => $notification->created_at->toISOString(),
        ];

        $zsetKey = "user:$userId:notifications:unread";
        $countKey = "user:$userId:notifications:unread_count";
        $pingKey = "user:$userId:notifications:ping";

        Redis::zadd($zsetKey, now()->timestamp, json_encode($payload));
        Redis::incr($countKey);
        Redis::publish($pingKey, 'new');
    }

    public function markAsRead(int $userId, int $receiverId): void
    {
        $receiver = NotificationReceiver::where('id', $receiverId)
            ->where('user_id', $userId)
            ->firstOrFail();

        if ($receiver->is_read) {
            return;
        }

        $receiver->update([
            'is_read' => true,
            'read_at' => now(),
        ]);


        Cache::tags("notification:{$userId}")->flush();
        // $this->removeFromRedis($userId, $receiverId);
    }

    protected function removeFromRedis(int $userId, int $receiverId): void
    {
        $zsetKey = "user:$userId:notifications:unread";
        $countKey = "user:$userId:notifications:unread_count";

        $items = Redis::zrange($zsetKey, 0, -1);

        foreach ($items as $item) {
            $decoded = json_decode($item, true);
            if ((int) $decoded['id'] === $receiverId) {
                Redis::zrem($zsetKey, $item);
                Redis::decr($countKey);
                break;
            }
        }
    }
}
