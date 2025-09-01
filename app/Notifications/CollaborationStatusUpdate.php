<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Collaboration;
use App\Models\User;

class CollaborationStatusUpdate extends Notification implements ShouldQueue
{
    use Queueable;

    protected $collaboration;
    protected $user;
    protected $status;
    protected $action;

    /**
     * Create a new notification instance.
     */
    public function __construct(Collaboration $collaboration, User $user, string $status, string $action)
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
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusText = $this->status === 'accepted' ? 'diterima' : 'ditolak';
        $actionText = $this->action === 'accepted' ? 'menerima' : 'menolak';
        
        return (new MailMessage)
            ->subject('Update Status Kolaborasi: ' . $this->collaboration->title)
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
     */
    public function toArray(object $notifiable): array
    {
        $statusText = $this->status === 'accepted' ? 'diterima' : 'ditolak';
        $actionText = $this->action === 'accepted' ? 'menerima' : 'menolak';
        
        return [
            'collaboration_id' => $this->collaboration->id,
            'collaboration_title' => $this->collaboration->title,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'status' => $this->status,
            'action' => $this->action,
            'type' => 'collaboration_status_update',
            'message' => $this->user->name . ' telah ' . $actionText . ' undangan kolaborasi "' . $this->collaboration->title . '"'
        ];
    }
}
