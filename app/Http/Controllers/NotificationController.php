<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     */
    public function index()
    {
        $user = Auth::user();
        
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Display the specified notification.
     */
    public function show(Notification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->notifiable_id !== Auth::id() || $notification->notifiable_type !== User::class) {
            abort(403, 'Unauthorized access to notification.');
        }

        // Mark as read if not already read
        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        // If there's a redirect URL, redirect to it
        if ($notification->redirect_url) {
            return redirect($notification->redirect_url);
        }

        return view('notifications.show', compact('notification'));
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->notifiable_id !== Auth::id() || $notification->notifiable_type !== User::class) {
            abort(403, 'Unauthorized access to notification.');
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.'
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        
        $user->notifications()
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read.'
        ]);
    }

    /**
     * Get unread notifications count (for AJAX requests).
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        $unreadCount = $user->notifications()->where('is_read', false)->count();

        return response()->json([
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Get recent notifications (for dropdown).
     */
    public function getRecent()
    {
        $user = Auth::user();
        
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'redirect_url' => $notification->redirect_url,
                    'is_read' => $notification->is_read,
                    'time_ago' => $notification->time_ago,
                    'data' => $notification->data,
                    'created_at' => $notification->created_at->toISOString(),
                ];
            });

        return response()->json([
            'notifications' => $notifications
        ]);
    }

    public function test()
    {
        return response()->json([
            'success' => true,
            'message' => 'Notification routes are working correctly!',
            'timestamp' => now()->toISOString(),
            'user_id' => Auth::id()
        ]);
    }

    /**
     * Delete a notification.
     */
    public function destroy(Notification $notification)
    {
        // Ensure the notification belongs to the authenticated user
        if ($notification->notifiable_id !== Auth::id() || $notification->notifiable_type !== User::class) {
            abort(403, 'Unauthorized access to notification.');
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully.'
        ]);
    }

    /**
     * Delete all read notifications.
     */
    public function destroyAllRead()
    {
        $user = Auth::user();
        
        $user->notifications()
            ->where('is_read', true)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'All read notifications deleted successfully.'
        ]);
    }

}
