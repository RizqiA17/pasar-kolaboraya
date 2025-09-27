<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ConnectionSuccess implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user1;
    public $user2;
    public $pasarKolaborayaId;
    public $connectionId;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user1, User $user2, int $pasarKolaborayaId, int $connectionId)
    {
        $this->user1 = $user1;
        $this->user2 = $user2;
        $this->pasarKolaborayaId = $pasarKolaborayaId;
        $this->connectionId = $connectionId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->user1->id),
            new PrivateChannel('user.' . $this->user2->id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'connection.success';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'connection_id' => $this->connectionId,
            'user1' => [
                'id' => $this->user1->id,
                'name' => $this->user1->name,
            ],
            'user2' => [
                'id' => $this->user2->id,
                'name' => $this->user2->name,
            ],
            'pasar_kolaboraya_id' => $this->pasarKolaborayaId,
            'message' => 'Koneksi berhasil! Anda sekarang terhubung dengan ' . $this->user2->name,
            'timestamp' => now()->toISOString(),
        ];
    }
}
