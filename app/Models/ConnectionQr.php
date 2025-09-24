<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ConnectionQr extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'qr_code',
        'type',
        'target_qr_code',
        'pasar_kolaboraya_id',
        'expires_at',
        'is_used',
        'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pasarKolaboraya()
    {
        return $this->belongsTo(PasarKolaboraya::class);
    }

    public function targetQr()
    {
        return $this->belongsTo(ConnectionQr::class, 'target_qr_code', 'qr_code');
    }

    /**
     * Generate a new connection QR code
     */
    public static function generateQrCode($userId, $pasarKolaborayaId, $type = 'initiator', $targetQrCode = null): self
    {
        $qrCode = ''.Str::random(6);
        
        return self::create([
            'user_id' => $userId,
            'qr_code' => $qrCode,
            'type' => $type,
            'target_qr_code' => $targetQrCode,
            'pasar_kolaboraya_id' => $pasarKolaborayaId,
            'expires_at' => now()->addMinute(5), // 5 minute expiry
        ]);
    }

    /**
     * Check if QR code is still valid
     */
    public function isValid(): bool
    {
        return !$this->is_used && $this->expires_at->isFuture();
    }

    /**
     * Mark QR as used
     */
    public function markAsUsed(): void
    {
        $this->update([
            'is_used' => true,
            'used_at' => now(),
        ]);
    }

    /**
     * Clean up expired QRs
     */
    public static function cleanupExpired(): int
    {
        return self::where('expires_at', '<', now())->delete();
    }

    /**
     * Get active QR for user
     */
    public static function getActiveQrForUser($userId, $pasarKolaborayaId, $type = 'initiator'): ?self
    {
        return self::where('user_id', $userId)
            ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('type', $type)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();
    }

    /**
     * Create or refresh QR for user
     */
    public static function createOrRefreshQr($userId, $pasarKolaborayaId, $type = 'initiator', $targetQrCode = null): self
    {
        // Clean up any existing QRs for this user
        self::where('user_id', $userId)
            ->where('pasar_kolaboraya_id', $pasarKolaborayaId)
            ->where('type', $type)
            ->delete();

        return self::generateQrCode($userId, $pasarKolaborayaId, $type, $targetQrCode);
    }
}