<?php

namespace App\Events;

use App\Models\Ecosystem;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EcosystemUserStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ecosystem;
    public $user;
    public $status;
    public $action;

    /**
     * Create a new event instance.
     */
    public function __construct(Ecosystem $ecosystem, User $user, string $status, string $action)
    {
        $this->ecosystem = $ecosystem;
        $this->user = $user;
        $this->status = $status;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->user->id),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'ecosystem' => [
                'id' => $this->ecosystem->id,
                'title' => $this->ecosystem->ecosystem_title,
                'organization_name' => $this->ecosystem->organization_name,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'status' => $this->status,
            'action' => $this->action,
            'member_count' => $this->ecosystem->acceptedUsers()->count(),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'ecosystem.user.status.updated';
    }
}
