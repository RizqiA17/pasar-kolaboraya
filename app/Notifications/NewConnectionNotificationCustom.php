<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Connection;
use App\Models\User;

class NewConnectionNotificationCustom extends Notification
{
    use Queueable;

    protected $connection;
    protected $connectedUser;

    /**
     * Create a new notification instance.
     */
    public function __construct(Connection $connection, User $connectedUser)
    {
        $this->connection = $connection;
        $this->connectedUser = $connectedUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Koneksi Baru: ' . $this->connectedUser->name)
            ->view('emails.connections.new-connection', [
                'notifiable' => $notifiable,
                'connection' => $this->connection,
                'connectedUser' => $this->connectedUser,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'connection_id' => $this->connection->id,
            'connected_user_id' => $this->connectedUser->id,
            'message' => 'New connection notification sent for ' . $this->connectedUser->name,
        ];
    }
}
