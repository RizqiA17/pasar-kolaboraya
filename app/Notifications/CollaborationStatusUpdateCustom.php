<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Collaboration;
use App\Models\User;

class CollaborationStatusUpdateCustom extends Notification
{
    use Queueable;

    protected $collaboration;
    protected $user;
    protected $status;
    protected $action;

    /**
     * Create a new notification instance.
     */
    public function __construct(Collaboration $collaboration, User $user, $status, $action)
    {
        $this->collaboration = $collaboration;
        $this->user = $user;
        $this->status = $status;
        $this->action = $action;
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
        $subject = $this->getSubject();
        
        return (new MailMessage)
            ->subject($subject)
            ->view('emails.collaboration.status-update', [
                'notifiable' => $notifiable,
                'collaboration' => $this->collaboration,
                'user' => $this->user,
                'status' => $this->status,
                'action' => $this->action,
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
            'collaboration_id' => $this->collaboration->id,
            'user_id' => $this->user->id,
            'status' => $this->status,
            'action' => $this->action,
            'message' => 'Collaboration status update sent for ' . $this->collaboration->title,
        ];
    }

    /**
     * Get the subject based on action
     */
    private function getSubject()
    {
        switch ($this->action) {
            case 'accepted':
                return 'Kolaborasi Diterima: ' . $this->collaboration->title;
            case 'declined':
                return 'Kolaborasi Ditolak: ' . $this->collaboration->title;
            case 'completed':
                return 'Kolaborasi Selesai: ' . $this->collaboration->title;
            case 'cancelled':
                return 'Kolaborasi Dibatalkan: ' . $this->collaboration->title;
            default:
                return 'Update Status Kolaborasi: ' . $this->collaboration->title;
        }
    }
}
