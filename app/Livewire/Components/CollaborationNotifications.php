<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class CollaborationNotifications extends Component
{
    public $notifications = [];
    public $isOpen = false;

    protected $listeners = [
        'refresh-notifications' => 'loadNotifications',
        'dropdown-shown' => 'dropdownOpened',
        'dropdown-hidden' => 'dropdownClosed'
    ];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = Auth::user()
            ->notifications()
            ->where(function($query) {
                $query->where('type', 'App\\Notifications\\CollaborationInvitation')
                      ->orWhere('type', 'App\\Notifications\\CollaborationStatusUpdate');
            })
            ->latest()
            ->take(5)
            ->get();
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            $this->loadNotifications();
            $this->dispatch('notification-read', $notificationId);
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->where('is_read', false)
            ->where(function($query) {
                $query->where('type', 'App\\Notifications\\CollaborationInvitation')
                      ->orWhere('type', 'App\\Notifications\\CollaborationStatusUpdate');
            })
            ->update(['is_read' => true, 'read_at' => now()]);
        
        $this->loadNotifications();
        $this->dispatch('notifications-read');
    }

    public function dropdownOpened()
    {
        $this->isOpen = true;
        $this->loadNotifications();
    }

    public function dropdownClosed()
    {
        $this->isOpen = false;
    }

    public function getUnreadCountProperty()
    {
        return Auth::user()->notifications()
            ->where('is_read', false)
            ->where(function($query) {
                $query->where('type', 'App\\Notifications\\CollaborationInvitation')
                      ->orWhere('type', 'App\\Notifications\\CollaborationStatusUpdate');
            })
            ->count();
    }

    public function render()
    {
        return view('livewire.components.collaboration-notifications');
    }
}
