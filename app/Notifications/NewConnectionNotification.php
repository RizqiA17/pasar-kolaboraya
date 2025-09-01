<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Connection;
use App\Models\User;

class NewConnectionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $connection;
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Connection $connection, User $user)
    {
        $this->connection = $connection;
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
        // Determine which user is the new connection
        $connectedUser = $this->connection->requester_id === $notifiable->id 
            ? $this->connection->receiver 
            : $this->connection->requester;

        return (new MailMessage)
            ->subject('Koneksi Baru: ' . $connectedUser->name . ' - Pasar Kolaboraya')
            ->view('emails.connections.new-connection', [
                'notifiable' => $notifiable,
                'connection' => $this->connection,
                'connectedUser' => $connectedUser,
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $connectedUser = $this->connection->requester_id === $notifiable->id 
            ? $this->connection->receiver 
            : $this->connection->requester;

        return [
            'connection_id' => $this->connection->id,
            'connected_user_id' => $connectedUser->id,
            'connected_user_name' => $connectedUser->name,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'type' => 'new_connection',
            'message' => 'Koneksi baru dengan ' . $connectedUser->name
        ];
    }
}
