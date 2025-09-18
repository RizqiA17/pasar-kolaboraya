<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class RegistrationKey extends Model
{
    protected $fillable = [
        'key',
        'user_type',
        'description',
        'is_active',
        'usage_count',
        'max_usage',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->key)) {
                $model->key = static::generateUniqueKey();
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isUsageLimitReached(): bool
    {
        return $this->max_usage && $this->usage_count >= $this->max_usage;
    }

    public function canBeUsed(): bool
    {
        return $this->is_active && !$this->isExpired() && !$this->isUsageLimitReached();
    }

    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    public function getUserTypeLabelAttribute(): string
    {
        return match($this->user_type) {
            'partisipan' => 'Partisipan',
            'tamu' => 'Tamu',
            'komunitas' => 'Komunitas',
            default => 'Unknown'
        };
    }

    public static function generateUniqueKey(): string
    {
        do {
            // Generate a more user-friendly key format: TYPE-XXXX-XXXX-XXXX
            $prefix = strtoupper(Str::random(4));
            $suffix1 = strtoupper(Str::random(4));
            $suffix2 = strtoupper(Str::random(4));
            $suffix3 = strtoupper(Str::random(4));
            $key = "{$prefix}-{$suffix1}-{$suffix2}-{$suffix3}";
        } while (static::where('key', $key)->exists());
        
        return $key;
    }
}
