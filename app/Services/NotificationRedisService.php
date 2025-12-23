<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Redis;

class NotificationRedisService
{
    /**
     * Increment unread counter
     */
    public function incrementUnread(int $userId): void
    {
        Redis::incr($this->unreadKey($userId));
    }

    /**
     * Decrement unread counter
     */
    public function decrementUnread(int $userId): void
    {
        Redis::decr($this->unreadKey($userId));
    }

    /**
     * Reset unread counter
     */
    public function resetUnread(int $userId): void
    {
        Redis::set($this->unreadKey($userId), 0);
    }

    /**
     * Get unread counter
     */
    public function getUnread(int $userId): int
    {
        return (int) Redis::get($this->unreadKey($userId));
    }

    /**
     * Publish notification event
     */
    public function publish(Notification $notification, int $userId): void
    {
        Redis::publish(
            $this->channel($userId),
            json_encode([
                'id' => $notification->id,
                'type' => $notification->type,
                'title' => $notification->title,
                'message' => $notification->message,
                'created_at' => $notification->created_at->toISOString(),
            ])
        );
    }

    protected function unreadKey(int $userId): string
    {
        return "user:{$userId}:notifications:unread";
    }

    protected function channel(int $userId): string
    {
        return "notifications:user:{$userId}";
    }
}
