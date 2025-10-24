<?php

namespace App\Events;

use App\Models\CollectiveAction;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CollectiveActionUserStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $collectiveAction;
    public $user;
    public $status;
    public $action;

    /**
     * Create a new event instance.
     */
    public function __construct(CollectiveAction $collectiveAction, User $user, string $status, string $action)
    {
        $this->collectiveAction = $collectiveAction;
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
            'collective_action' => [
                'id' => $this->collectiveAction->id,
                'title' => $this->collectiveAction->title,
                'description' => $this->collectiveAction->description,
            ],
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
            'status' => $this->status,
            'action' => $this->action,
            'member_count' => $this->collectiveAction->activeUsers()->count(),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'collective_action.user.status.updated';
    }
}
