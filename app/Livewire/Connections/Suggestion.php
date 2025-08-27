<?php

namespace App\Livewire\Connections;

use App\Models\Connection;
use Livewire\Component;

class Suggestion extends Component
{
    public function connect($userId)
    {
        Connection::create([
            'requester_id' => auth()->id(),
            'receiver_id' => $userId,
            'status' => 'pending'
        ]);

        $this->dispatch('refresh-requests');
    }

    public function render()
    {
        $user = auth()->user();
        
        return view('livewire.connections.suggestion', [
            'mutualFriendsRecommendations' => $user->getMutualFriendsRecommendations(),
            'interestRecommendations' => $user->getInterestBasedRecommendations(),
            'skillRecommendations' => $user->getSkillBasedRecommendations(),
            'eventRecommendations' => $user->getEventBasedRecommendations(),
        ]);
    }
}