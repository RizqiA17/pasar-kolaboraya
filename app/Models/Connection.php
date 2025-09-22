<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Connection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'requester_id',
        'receiver_id',
        'pasar_kolaboraya_id',
        'status',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function pasarKolaboraya()
    {
        return $this->belongsTo(PasarKolaboraya::class, 'pasar_kolaboraya_id');
    }

    public function searchRequest()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
    public function searchRecive()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function pendingRequests()
    {
        return $this->hasMany(Connection::class, 'receiver_id')
            ->where('receiver_id', $this->id)
            ->where('status', 'pending');
    }

    /**
     * Scope to filter connections by PasarKolaboraya session
     * Only show connections that belong to the specified session
     */
    public function scopeForPasarKolaboraya($query, $pasarKolaborayaId)
    {
        return $query->where('pasar_kolaboraya_id', $pasarKolaborayaId);
    }

    /**
     * Scope to filter connections by user's active PasarKolaboraya session
     */
    public function scopeForUserActiveSession($query, $user)
    {
        if (!$user->hasActivePasarKolaboraya()) {
            return $query->whereRaw('1 = 0'); // Return empty result
        }
        
        return $query->forPasarKolaboraya($user->active_pasar_kolaboraya_id);
    }

    /**
     * Calculate Pilar I - Koneksi scoring metrics
     * Based on the new scoring system requirements
     */
    public static function calculateKoneksiScore($userId, $pasarKolaborayaId = null)
    {
        $user = User::find($userId);
        if (!$user) {
            return [
                'friendship_density_score' => 0,
                'avg_friends_score' => 0,
                'acceptance_rate_score' => 0,
                'recency_score' => 0,
                'diversity_score' => 0,
                'koneksi_score' => 0,
                'details' => []
            ];
        }

        // Use active session if no specific session provided
        if (!$pasarKolaborayaId) {
            $pasarKolaborayaId = $user->active_pasar_kolaboraya_id;
        }

        if (!$pasarKolaborayaId) {
            return [
                'friendship_density_score' => 0,
                'avg_friends_score' => 0,
                'acceptance_rate_score' => 0,
                'recency_score' => 0,
                'diversity_score' => 0,
                'koneksi_score' => 0,
                'details' => []
            ];
        }

        // 1. Friendship Density - only for user's connections
        $userConnections = Connection::where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('status', 'accepted')
            ->where(function ($query) use ($userId) {
                $query->where('requester_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->get();

        $acceptedConnections = $userConnections->count();

        // Get unique users connected to this specific user
        $connectedUserIds = $userConnections
            ->flatMap(function ($connection) use ($userId) {
                return $connection->requester_id == $userId 
                    ? [$connection->receiver_id] 
                    : [$connection->requester_id];
            })
            ->unique()
            ->values();

        $n = $connectedUserIds->count();
        $possiblePairs = $n > 1 ? $n * ($n - 1) / 2 : 0;
        $densityRef = 0.15; // Target density reference
        $friendshipDensity = $possiblePairs > 0 ? $acceptedConnections / $possiblePairs : 0;
        $friendshipDensityScore = min($friendshipDensity / $densityRef, 1) * 100;

        // 2. Average Friends per User
        $avgDegree = $n > 0 ? (2 * $acceptedConnections) / $n : 0;
        $degreeRef = 20; // Target average friends per user
        $avgFriendsScore = min($avgDegree / $degreeRef, 1) * 100;

        // 3. Connection Acceptance Rate - only for user's connections
        $accepted = $userConnections->count();
        
        $rejected = Connection::where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('status', 'rejected')
            ->where(function ($query) use ($userId) {
                $query->where('requester_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->count();

        $acceptanceRate = ($accepted + $rejected) > 0 ? $accepted / ($accepted + $rejected) : 0;
        $acceptanceRateScore = $acceptanceRate * 100;

        // 4. Connection Recency - only for user's connections
        $recent = $userConnections
            ->where('created_at', '>=', now()->subDays(90))
            ->count();

        $total = $accepted;
        $recencyRate = $total > 0 ? $recent / $total : 0;
        $recencyScore = $recencyRate * 100;

        // 5. Network Diversity (based on user roles) - only for user's connected users
        $diversityScore = 0;
        $roleCategories = [];
        
        if ($n > 0) {
            // Get only the user's connected users with their roles
            $connectedUsers = User::whereIn('id', $connectedUserIds)
                ->with('profile')
                ->get();

            // Count roles from user profiles
            foreach ($connectedUsers as $connectedUser) {
                if ($connectedUser->profile && $connectedUser->profile->existing_roles) {
                    $roles = is_array($connectedUser->profile->existing_roles) 
                        ? $connectedUser->profile->existing_roles 
                        : json_decode($connectedUser->profile->existing_roles, true);
                    
                    if (is_array($roles)) {
                        foreach ($roles as $role) {
                            $roleCategories[$role] = ($roleCategories[$role] ?? 0) + 1;
                        }
                    }
                }
            }

            // Calculate Shannon diversity index
            if (!empty($roleCategories)) {
                $totalUsers = array_sum($roleCategories);
                $K = count($roleCategories);
                
                if ($K > 1) {
                    $H = 0;
                    foreach ($roleCategories as $count) {
                        $pi = $count / $totalUsers;
                        if ($pi > 0) {
                            $H -= $pi * log($pi);
                        }
                    }
                    $diversityScore = ($H / log($K)) * 100;
                } else {
                    $diversityScore = 0; // No diversity if only one category
                }
            }
        }

        // Calculate final Koneksi score (average of all 5 components)
        $koneksiScore = ($friendshipDensityScore + $avgFriendsScore + $acceptanceRateScore + $recencyScore + $diversityScore) / 5;

        return [
            'friendship_density_score' => round($friendshipDensityScore, 1),
            'avg_friends_score' => round($avgFriendsScore, 1),
            'acceptance_rate_score' => round($acceptanceRateScore, 1),
            'recency_score' => round($recencyScore, 1),
            'diversity_score' => round($diversityScore, 1),
            'koneksi_score' => round($koneksiScore, 1),
            'details' => [
                'accepted_connections' => $acceptedConnections,
                'connected_users_count' => $n,
                'possible_pairs' => $possiblePairs,
                'friendship_density' => round($friendshipDensity, 4),
                'avg_degree' => round($avgDegree, 2),
                'accepted_count' => $accepted,
                'rejected_count' => $rejected,
                'acceptance_rate' => round($acceptanceRate, 4),
                'recent_connections' => $recent,
                'total_accepted' => $total,
                'recency_rate' => round($recencyRate, 4),
                'role_categories' => $roleCategories,
                'diversity_index' => round($diversityScore / 100, 4)
            ]
        ];
    }

    /**
     * Get connection quality metrics for a specific user
     */
    public static function getConnectionQualityMetrics($userId, $pasarKolaborayaId = null)
    {
        $user = User::find($userId);
        if (!$user) {
            return [
                'jumlah_koneksi' => 0,
                'kualitas_koneksi' => 0,
                'keluasan_jejaring' => 0,
                'keragaman_keahlian' => 0,
                'tingkat_interaksi' => 0,
                'kekuatan_jejaring' => 0
            ];
        }

        // Use active session if no specific session provided
        if (!$pasarKolaborayaId) {
            $pasarKolaborayaId = $user->active_pasar_kolaboraya_id;
        }

        if (!$pasarKolaborayaId) {
            return [
                'jumlah_koneksi' => 0,
                'kualitas_koneksi' => 0,
                'keluasan_jejaring' => 0,
                'keragaman_keahlian' => 0,
                'tingkat_interaksi' => 0,
                'kekuatan_jejaring' => 0
            ];
        }

        // Get accepted connections with related data
        $connections = Connection::where(function ($query) use ($userId) {
            $query->where('requester_id', $userId)
                ->orWhere('receiver_id', $userId);
        })
        ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
        ->where('status', 'accepted')
        ->with(['requester.profile.skills', 'receiver.profile.skills'])
        ->get();

        if ($connections->isEmpty()) {
            return [
                'jumlah_koneksi' => 0,
                'kualitas_koneksi' => 0,
                'keluasan_jejaring' => 0,
                'keragaman_keahlian' => 0,
                'tingkat_interaksi' => 0,
                'kekuatan_jejaring' => 0
            ];
        }

        // Calculate metrics
        $totalConnections = $connections->count();
        $allSkills = collect();
        $connectionQualityScores = [];
        $networkBreadth = 0;

        foreach ($connections as $connection) {
            // Determine which user is the connection (not the current user)
            $connectedUser = $connection->requester_id == $userId ? $connection->receiver : $connection->requester;
            
            if ($connectedUser && $connectedUser->profile) {
                // Collect skills
                if ($connectedUser->profile->skills) {
                    $allSkills = $allSkills->merge($connectedUser->profile->skills->pluck('name'));
                }
                
                // Calculate connection quality for this member (simplified)
                $memberQuality = min(5, max(1, 1)); // Each connection adds value
                $connectionQualityScores[] = $memberQuality;
                
                // Network breadth (unique organizations/regions)
                $networkBreadth += 1; // Each member adds to breadth
            }
        }

        // Calculate averages and metrics
        $avgConnections = $totalConnections;
        $avgConnectionQuality = count($connectionQualityScores) > 0 
            ? array_sum($connectionQualityScores) / count($connectionQualityScores) 
            : 0;
        
        // Network breadth (unique skills diversity)
        $uniqueSkills = $allSkills->unique()->count();
        $skillDiversity = min(5, $uniqueSkills / 5); // Scale to 1-5
        
        // Interaction level (based on member count and connections)
        $interactionLevel = min(5, $totalConnections / 3);
        
        // Network strength (combination of connections and quality)
        $networkStrength = min(5, ($avgConnections + $avgConnectionQuality) / 2);

        return [
            'jumlah_koneksi' => round($avgConnections, 1),
            'kualitas_koneksi' => round($avgConnectionQuality, 1),
            'keluasan_jejaring' => round($networkBreadth, 1),
            'keragaman_keahlian' => round($skillDiversity, 1),
            'tingkat_interaksi' => round($interactionLevel, 1),
            'kekuatan_jejaring' => round($networkStrength, 1)
        ];
    }
}


