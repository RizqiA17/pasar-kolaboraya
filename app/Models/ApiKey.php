<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    protected $fillable = [
        'name',
        'key',
        'secret',
        'is_active',
        'last_used_at',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Generate new API key pair
     */
    public static function generate($name = 'API Key')
    {
        $key = 'pk_' . Str::random(32);
        $secret = Str::random(64);

        return self::create([
            'name' => $name,
            'key' => $key,
            'secret' => $secret,
            'is_active' => true,
            'expires_at' => now()->addYear(), // Expire in 1 year
        ]);
    }

    /**
     * Find API key by key
     */
    public static function findByKey($key)
    {
        return self::where('key', $key)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();
    }

    /**
     * Update last used timestamp
     */
    public function markAsUsed()
    {
        $this->update(['last_used_at' => now()]);
    }

    /**
     * Check if API key is valid
     */
    public function isValid()
    {
        return $this->is_active && 
               ($this->expires_at === null || $this->expires_at > now());
    }
}

