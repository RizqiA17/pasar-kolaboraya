<?php

namespace App\Livewire\Notification;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\NotificationReceiver;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Cache;

class NotificationDropdown extends Component
{
    public array $notifications = [];
    public bool $hasUnread = false;
    public bool $loading = false;
    public int $unreadCount = 0;
    public int $userId;

    protected $listeners = [
        'refreshNotifications' => 'loadNotifications',
        'refreshUnread' => 'checkUnread',
        'markAsRead' => 'markAsRead',
    ];

    public function mount(): void
    {
        $this->userId = auth()->id();
        $this->checkUnread();
    }

    public function loadNotifications(): void
    {
        if ($this->loading)
            return;
        if (empty($this->notifications))
            $this->loading = true;

        $this->notifications = Cache::tags("notification:{$this->userId}")
            ->remember("user:{$this->userId}:notifications", 300, function () {
                return NotificationReceiver::with('notification')
                    ->where('user_id', $this->userId)
                    ->where('is_read', false)
                    ->latest()
                    ->limit(4)
                    ->get()
                    ->map(function ($receiver) {
                        return [
                            'id' => $receiver->id,
                            'title' => $receiver->notification->title,
                            'message' => $receiver->notification->message,
                            'redirect_url' => $receiver->notification->redirect_url,
                            'created_at' => Carbon::parse($receiver->created_at)->diffForHumans(),
                        ];
                    })->toArray();
            });

        $this->unreadCount = Cache::tags("notification:{$this->userId}")
            ->remember("user:{$this->userId}:notifications:count", 300, function () {
                return NotificationReceiver::where('user_id', $this->userId)
                    ->where('is_read', false)
                    ->count();
            });

        $this->loading = false;
    }

    public function seeNotification(string $url, int $receiverId){
        $this->markAsRead($receiverId);
        return $this->redirectIntended($url, navigate: true);
    }

    public function markAsRead(int $receiverId): void
    {
        app(NotificationService::class)
            ->markAsRead($this->userId, $receiverId);

        $this->loadNotifications();
        $this->checkUnread();
    }

    public function checkUnread(): void
    {
        $this->hasUnread = Cache::tags("notification:{$this->userId}")
            ->remember("user:{$this->userId}:notifications:check_unread", 300, function () {
                return NotificationReceiver::where('user_id', $this->userId)
                    ->where('is_read', false)
                    ->exists();
            });
    }

    public function render()
    {
        return view('livewire.notification.notification-dropdown');
    }
}
