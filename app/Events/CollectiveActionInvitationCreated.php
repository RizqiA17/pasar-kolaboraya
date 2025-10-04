<?php

namespace App\Events;

use App\Models\CollectiveActionEcosystemInvitation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CollectiveActionInvitationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invitation;

    /**
     * Create a new event instance.
     */
    public function __construct(CollectiveActionEcosystemInvitation $invitation)
    {
        $this->invitation = $invitation->load(['collectiveAction', 'invitedBy']);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->invitation->ecosystem->creator_id),
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
            'invitation' => [
                'id' => $this->invitation->id,
                'status' => $this->invitation->status,
                'status_label' => $this->invitation->status_label,
                'invitation_message' => $this->invitation->invitation_message,
                'created_at' => $this->invitation->created_at->toISOString(),
                'collective_action' => [
                    'id' => $this->invitation->collectiveAction->id,
                    'title' => $this->invitation->collectiveAction->title,
                    'description' => $this->invitation->collectiveAction->description,
                    'scale' => $this->invitation->collectiveAction->scale,
                    'scale_label' => $this->invitation->collectiveAction->scale_label,
                    'scope' => $this->invitation->collectiveAction->scope,
                    'scope_label' => $this->invitation->collectiveAction->scope_label,
                ],
                'invited_by' => [
                    'id' => $this->invitation->invitedBy->id,
                    'name' => $this->invitation->invitedBy->name,
                    'initials' => $this->invitation->invitedBy->initials(),
                ],
            ],
            'pending_count' => CollectiveActionEcosystemInvitation::whereHas('ecosystem', function ($q) {
                $q->where('creator_id', $this->invitation->ecosystem->creator_id);
            })->where('status', 'pending')->count(),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'invitation.created';
    }
}
