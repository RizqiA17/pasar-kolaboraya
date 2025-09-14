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
}


