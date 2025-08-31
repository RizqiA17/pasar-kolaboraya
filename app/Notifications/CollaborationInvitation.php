<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Collaboration;
use App\Models\User;

class CollaborationInvitation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $collaboration;
    protected $inviter;

    /**
     * Create a new notification instance.
     */
    public function __construct(Collaboration $collaboration, User $inviter)
    {
        $this->collaboration = $collaboration;
        $this->inviter = $inviter;
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
            ->subject('Undangan Kolaborasi: ' . $this->collaboration->title)
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line($this->inviter->name . ' mengundang Anda untuk bergabung dalam kolaborasi.')
            ->line('Judul: ' . $this->collaboration->title)
            ->line('Deskripsi: ' . ($this->collaboration->description ?? 'Tidak ada deskripsi'))
            ->action('Lihat Detail', url('/collaborations/' . $this->collaboration->id))
            ->line('Silakan terima atau tolak undangan ini sesuai dengan keinginan Anda.')
            ->salutation('Salam, ' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'collaboration_id' => $this->collaboration->id,
            'collaboration_title' => $this->collaboration->title,
            'inviter_id' => $this->inviter->id,
            'inviter_name' => $this->inviter->name,
            'type' => 'collaboration_invitation',
            'message' => $this->inviter->name . ' mengundang Anda untuk bergabung dalam kolaborasi "' . $this->collaboration->title . '"'
        ];
    }
}
