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
        return Auth::user()
            ->notifications()
            ->latest()
            ->take(5)
            ->get();
    }

    public function getUnreadNotificationsProperty()
    {
        return Auth::user()->notifications()->where('is_read', false)->count();
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()->where('is_read', false)->update(['is_read' => true, 'read_at' => now()]);
        $this->dispatch('notifications-read');
    }

    public function markAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
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
