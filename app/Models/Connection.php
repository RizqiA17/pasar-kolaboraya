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
     * Focus on role diversity: roles in connections / total roles in database
     */
    public static function calculateKoneksiScore($userId, $pasarKolaborayaId = null)
    {
        $user = User::find($userId);
        if (!$user) {
            return [
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
                'diversity_score' => 0,
                'koneksi_score' => 0,
                'details' => []
            ];
        }

        // Get user's accepted connections
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

        // Get all available roles from database
        $totalRolesInDatabase = \App\Models\Peran::count();
        
        // Network Diversity (based on user roles) - only for user's connected users
        $diversityScore = 0;
        $roleCategories = [];
        $uniqueRolesInConnections = [];
        
        if ($n > 0) {
            // Get only the user's connected users with their roles
            $connectedUsers = User::whereIn('id', $connectedUserIds)
                ->with('profile.peran')
                ->get();

            // Count roles from user profiles
            foreach ($connectedUsers as $connectedUser) {
                if ($connectedUser->profile && $connectedUser->profile->peran) {
                    $roleName = $connectedUser->profile->peran->nama;
                    $roleCategories[$roleName] = ($roleCategories[$roleName] ?? 0) + 1;
                    $uniqueRolesInConnections[$roleName] = true;
                }
            }

            // Calculate diversity score as percentage of roles covered
            $uniqueRolesCount = count($uniqueRolesInConnections);
            if ($totalRolesInDatabase > 0) {
                $diversityScore = ($uniqueRolesCount / $totalRolesInDatabase) * 100;
            }
        }

        // Calculate final Koneksi score (only diversity score)
        $koneksiScore = $diversityScore;

        return [
            'diversity_score' => round($diversityScore, 1),
            'koneksi_score' => round($koneksiScore, 1),
            'details' => [
                'accepted_connections' => $acceptedConnections,
                'connected_users_count' => $n,
                'role_categories' => $roleCategories,
                'unique_roles_count' => count($uniqueRolesInConnections),
                'total_roles_in_database' => $totalRolesInDatabase,
                'role_coverage_percentage' => round($diversityScore, 1)
            ]
        ];
    }

    /**
     * Get connection quality metrics for a specific user
     * Focus on role diversity: roles in connections / total roles in database
     */
    public static function getConnectionQualityMetrics($userId, $pasarKolaborayaId = null)
    {
        $user = User::find($userId);
        if (!$user) {
            return [
                'jumlah_koneksi' => 0,
                'kualitas_koneksi' => 0,
                'keragaman_peran' => 0,
                'jumlah_peran_unik' => 0,
                'total_peran_database' => 0,
                'persentase_cakupan' => 0
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
                'keragaman_peran' => 0,
                'jumlah_peran_unik' => 0,
                'total_peran_database' => 0,
                'persentase_cakupan' => 0
            ];
        }

        // Get accepted connections
        $connections = Connection::where(function ($query) use ($userId) {
            $query->where('requester_id', $userId)
                ->orWhere('receiver_id', $userId);
        })
        ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
        ->where('status', 'accepted')
        ->with(['requester.profile.peran', 'receiver.profile.peran'])
        ->get();

        if ($connections->isEmpty()) {
            return [
                'jumlah_koneksi' => 0,
                'kualitas_koneksi' => 0,
                'keragaman_peran' => 0,
                'jumlah_peran_unik' => 0,
                'total_peran_database' => 0,
                'persentase_cakupan' => 0
            ];
        }

        // Get total roles in database
        $totalRolesInDatabase = \App\Models\Peran::count();

        // Calculate role diversity metrics
        $totalConnections = $connections->count();
        $roleCategories = [];
        $uniqueRoles = [];

        foreach ($connections as $connection) {
            // Determine which user is the connection (not the current user)
            $connectedUser = $connection->requester_id == $userId ? $connection->receiver : $connection->requester;
            
            if ($connectedUser && $connectedUser->profile && $connectedUser->profile->peran) {
                $roleName = $connectedUser->profile->peran->nama;
                $roleCategories[$roleName] = ($roleCategories[$roleName] ?? 0) + 1;
                $uniqueRoles[$roleName] = true;
            }
        }

        // Calculate diversity score as percentage of roles covered
        $uniqueRolesCount = count($uniqueRoles);
        $diversityScore = 0;
        
        if ($totalRolesInDatabase > 0) {
            $diversityScore = ($uniqueRolesCount / $totalRolesInDatabase) * 100;
        }

        // Calculate quality score based on diversity
        $qualityScore = $diversityScore;

        return [
            'jumlah_koneksi' => $totalConnections,
            'kualitas_koneksi' => round($qualityScore, 1),
            'keragaman_peran' => round($diversityScore, 1),
            'jumlah_peran_unik' => $uniqueRolesCount,
            'total_peran_database' => $totalRolesInDatabase,
            'persentase_cakupan' => round($diversityScore, 1)
        ];
    }
}


