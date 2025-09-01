<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;
use App\Models\User;

class EventNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event, User $user)
    {
        $this->event = $event;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Event Baru: ' . $this->event->title . ' - Pasar Kolaboraya')
            ->view('emails.events.event-notification', [
                'user' => $this->user,
                'event' => $this->event,
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'event_title' => $this->event->title,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'type' => 'event_notification',
            'message' => 'Event baru: ' . $this->event->title
        ];
    }
}
