<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserQrScannedSuccessfully implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $pasarKolaborayaName;
    public $redirectUrl;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $pasarKolaborayaName, $redirectUrl)
    {
        $this->userId = $userId;
        $this->pasarKolaborayaName = $pasarKolaborayaName;
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->userId)
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'qr-scanned-successfully';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'user_id' => $this->userId,
            'pasar_kolaboraya_name' => $this->pasarKolaborayaName,
            'redirect_url' => $this->redirectUrl,
            'timestamp' => now()->toISOString()
        ];
    }
}
