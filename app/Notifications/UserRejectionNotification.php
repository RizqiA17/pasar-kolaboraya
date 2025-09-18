<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class UserRejectionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, $reason = null)
    {
        $this->user = $user;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('❌ Pendaftaran Anda Ditolak - ' . config('app.name'))
            ->view('emails.user.rejection', [
                'user' => $this->user,
                'reason' => $this->reason,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_type' => $this->user->user_type,
            'reason' => $this->reason,
            'type' => 'user_rejection',
            'message' => 'Pendaftaran Anda telah ditolak untuk bergabung dengan ' . config('app.name')
        ];
    }
}
