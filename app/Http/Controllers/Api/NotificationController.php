<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NotificationReceiver;
use App\Services\NotificationRedisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Recent notification (latest only)
     */
    public function recent(Request $request): JsonResponse
    {
        return response()->json([
            'data' => [
                [
                    'id' => 1,
                    'notification_id' => 1,
                    'type' => "group_join_request",
                    'title' => "Group Join Request",
                    'message' => "Permintaan bergabung ke grup qwe oleh qwe.",
                    'redirect_url' => route('connections'),
                    'is_read' => false,
                    'created_at' => "2022-01-01T00:00:00.000000Z",
                ],
                [
                    'id' => 2,
                    'notification_id' => 2,
                    'type' => "group_join_request",
                    'title' => "Group Join Request",
                    'message' => "Permintaan bergabung ke grup qwe oleh qwe.",
                    'redirect_url' => route('connections'),
                    'is_read' => true,
                    'created_at' => "2022-01-01T00:00:00.000000Z",
                ]
            ]
        ]);
        $user = $request->user();

        $notifications = NotificationReceiver::query()
            ->with('notification')
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($receiver) {
                $notification = $receiver->notification;

                return [
                    'id' => $receiver->id,
                    'notification_id' => $notification->id,
                    'type' => $notification->type,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'redirect_url' => $notification->redirect_url,
                    'is_read' => $receiver->is_read,
                    'created_at' => $notification->created_at->toISOString(),
                ];
            });

        return response()->json([
            'data' => $notifications,
        ]);
    }

    /**
     * Unread counter
     */
    public function unreadCount(
        Request $request,
        NotificationRedisService $redis
    ): JsonResponse {
        $userId = $request->user()->id;

        return response()->json([
            'unread' => $redis->getUnread($userId),
        ]);
    }

    /**
     * Mark single notification as read
     */
    public function markAsRead(
        NotificationReceiver $receiver,
        Request $request,
        NotificationRedisService $redis
    ): JsonResponse {
        if ($receiver->user_id !== $request->user()->id) {
            abort(403);
        }

        if (!$receiver->is_read) {
            $receiver->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

            $redis->decrementUnread($receiver->user_id);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(
        Request $request,
        NotificationRedisService $redis
    ): JsonResponse {
        $user = $request->user();

        NotificationReceiver::where('user_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        $redis->resetUnread($user->id);

        return response()->json([
            'success' => true,
        ]);
    }
}
