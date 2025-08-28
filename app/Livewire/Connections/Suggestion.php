<?php

namespace App\Livewire\Connections;

use App\Models\Connection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Suggestion extends Component
{
    public function connect($userId)
    {
        Connection::create([
            'requester_id' => Auth::id(),
            'receiver_id' => $userId,
            'status' => 'pending'
        ]);

        $this->dispatch('refresh-requests');
    }

    public function render()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Get all recommendations with their respective counts
        $mutualFriendsRecommendations = $user->getMutualFriendsRecommendations();
        $interestRecommendations = $user->getInterestBasedRecommendations();
        $skillRecommendations = $user->getSkillBasedRecommendations();
        $eventRecommendations = $user->getEventBasedRecommendations();
        
        return view('livewire.connections.suggestion', [
            'mutualFriendsRecommendations' => $mutualFriendsRecommendations,
            'interestRecommendations' => $interestRecommendations,
            'skillRecommendations' => $skillRecommendations,
            'eventRecommendations' => $eventRecommendations,
        ]);
    }
}