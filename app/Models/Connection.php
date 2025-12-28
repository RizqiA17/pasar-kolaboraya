<?php

namespace App\Models;

use App\Models\Peran;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Connection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'requester_id',
        'receiver_id',
        'pasar_kolaboraya_id',
        'status',
    ];

    protected static function booted(){
        static::saved(function ($connection) {
            static::clearCache($connection->receiver);
            static::clearCache($connection->requester);
        });

        static::deleted(function ($connection) {
            static::clearCache($connection->receiver);
            static::clearCache($connection->requester);
        });
    }

    public static function clearCache($user){
        Cache::tags("stats:connections:{$user->id}:{$user->active_pasar_kolaboraya_id}")->flush();
    }

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
        $cacheKey = "connection_score:user:{$userId}:session:" . ($pasarKolaborayaId ?: 'active');
        $tags = ["connection", "connection:user:{$userId}"];

        return Cache::tags($tags)->rememberForever($cacheKey, function () use ($userId, $pasarKolaborayaId) {
            $user = User::find($userId);
            if (!$user) {
                return self::emptyScore();
            }

            $pasarKolaborayaId = self::resolveSession($user, $pasarKolaborayaId);
            if (!$pasarKolaborayaId) {
                return self::emptyScore();
            }

            $connections = self::getAcceptedConnections($userId, $pasarKolaborayaId);
            if ($connections->isEmpty()) {
                return self::emptyScore();
            }

            $connectedUsers = self::extractConnectedUsers($connections, $userId);
            $metrics = self::calculateRoleDiversity($connectedUsers);

            return [
                'diversity_score' => $metrics['diversity_score'],
                'koneksi_score' => $metrics['diversity_score'],
                'details' => [
                    'accepted_connections' => $connections->count(),
                    'connected_users_count' => $connectedUsers->count(),
                    'role_categories' => $metrics['role_categories'],
                    'unique_roles_count' => $metrics['unique_roles'],
                    'total_roles_in_database' => $metrics['total_roles'],
                    'role_coverage_percentage' => $metrics['diversity_score'],
                ]
            ];
        });
    }

    public static function getConnectionQualityMetrics($userId, $pasarKolaborayaId = null)
    {
        $cacheKey = "connection_quality:user:{$userId}:session:" . ($pasarKolaborayaId ?: 'active');
        $tags = ["connection", "connection:user:{$userId}"];

        return Cache::tags($tags)->rememberForever($cacheKey, function () use ($userId, $pasarKolaborayaId) {
            $user = User::find($userId);
            if (!$user) {
                return self::emptyQuality();
            }

            $pasarKolaborayaId = self::resolveSession($user, $pasarKolaborayaId);
            if (!$pasarKolaborayaId) {
                return self::emptyQuality();
            }

            $connections = self::getAcceptedConnections($userId, $pasarKolaborayaId);
            if ($connections->isEmpty()) {
                return self::emptyQuality();
            }

            $connectedUsers = self::extractConnectedUsers($connections, $userId);
            $metrics = self::calculateRoleDiversity($connectedUsers);

            return [
                'jumlah_koneksi' => $connections->count(),
                'kualitas_koneksi' => $metrics['diversity_score'],
                'keragaman_peran' => $metrics['diversity_score'],
                'jumlah_peran_unik' => $metrics['unique_roles'],
                'total_peran_database' => $metrics['total_roles'],
                'persentase_cakupan' => $metrics['diversity_score'],
            ];
        });
    }

    /**
     * Helpers
     */

    public static function clearUserConnectionCache($userId)
    {
        Cache::tags("connection:user:{$userId}")->flush();
    }

    private static function resolveSession($user, $pasarKolaborayaId)
    {
        return $pasarKolaborayaId ?: $user->active_pasar_kolaboraya_id;
    }

    private static function emptyScore()
    {
        return [
            'diversity_score' => 0,
            'koneksi_score' => 0,
            'details' => ['total_roles_in_database' => Peran::count()]
        ];
    }

    private static function emptyQuality()
    {
        return [
            'jumlah_koneksi' => 0,
            'kualitas_koneksi' => 0,
            'keragaman_peran' => 0,
            'jumlah_peran_unik' => 0,
            'total_peran_database' => 0,
            'persentase_cakupan' => 0
        ];
    }

    private static function getAcceptedConnections($userId, $sessionId)
    {
        return Connection::where('pasar_kolaboraya_id', $sessionId)
            ->where('status', 'accepted')
            ->where(function ($q) use ($userId) {
                $q->where('requester_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->with(['requester.profile.peran', 'receiver.profile.peran'])
            ->get();
    }

    private static function extractConnectedUsers($connections, $userId)
    {
        return $connections->map(function ($c) use ($userId) {
            return $c->requester_id == $userId ? $c->receiver : $c->requester;
        })->unique('id')->values();
    }

    private static function calculateRoleDiversity($connectedUsers)
    {
        $totalRoles = Peran::count();
        $roleCategories = [];
        $uniqueRoles = [];

        foreach ($connectedUsers as $user) {
            $role = $user->profile->peran->nama ?? null;
            if ($role) {
                $roleCategories[$role] = ($roleCategories[$role] ?? 0) + 1;
                $uniqueRoles[$role] = true;
            }
        }

        $uniqueCount = count($uniqueRoles);

        $diversityScore = ($totalRoles > 0)
            ? round(($uniqueCount / $totalRoles) * 100, 1)
            : 0;

        return [
            'diversity_score' => $diversityScore,
            'role_categories' => $roleCategories,
            'unique_roles' => $uniqueCount,
            'total_roles' => $totalRoles
        ];
    }

}


