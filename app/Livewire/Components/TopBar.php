<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class TopBar extends Component
{
    public $search = '';
    public $searchPlaceholder = 'Search...';
    public $tab;

    protected $listeners = ['refreshNotifications' => '$refresh'];

    public function getNotificationsProperty()
    {
        return auth()->user()
            ->notifications()
            ->latest()
            ->take(5)
            ->get();
    }

    public function getUnreadNotificationsProperty()
    {
        return auth()->user()->unreadNotifications()->count();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->dispatch('notifications-read');
    }

    public function markAsRead($notificationId)
    {
        $notification = DatabaseNotification::find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            $this->dispatch('notification-read', $notificationId);
        }
    }
    
    public function updatedSearch()
    {
        $this->dispatch('search-updated', $this->search);
    }

    public function render()
    {
        return view('livewire.components.top-bar');
    }
}
