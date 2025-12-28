<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ConnectionQrService
{
    public static function create(
        int $userId,
        int $pasarId,
        string $type,
        ?string $targetUserId = null,
        int $ttlSeconds = 120
    ): array {
        $store = Cache::store('redis');

        // ===============================
        // 1. INVALIDATE QR LAMA (jika ada)
        // ===============================
        $activeKey = self::activeKey($userId, $pasarId, $type);
        $oldQrCode = $store->get($activeKey);

        if ($oldQrCode) {
            $store->forget(self::key($oldQrCode));
        }

        // ===============================
        // 2. BUAT QR BARU
        // ===============================
        $qrCode = Str::random(6);

        $data = [
            'qr_code' => $qrCode,
            'user_id' => $userId,
            'pasar_id' => $pasarId,
            'type' => $type,
            'target_user_id' => $targetUserId,
            'is_used' => false,
            'expires_at' => now()->addSeconds($ttlSeconds)->timestamp,
        ];

        // Simpan QR data
        $store->put(
            self::key($qrCode),
            $data,
            $ttlSeconds
        );

        // ===============================
        // 3. SET QR SEBAGAI AKTIF
        // ===============================
        $store->put(
            $activeKey,
            $qrCode,
            $ttlSeconds
        );

        return $data;
    }

    public static function get(string $qrCode): ?array
    {
        return Cache::store('redis')->get(self::key($qrCode));
    }

    public static function markUsed(string $qrCode): void
    {
        $store = Cache::store('redis');
        $data = self::get($qrCode);

        if (!$data) {
            return;
        }

        $data['is_used'] = true;

        $ttl = max(1, $data['expires_at'] - now()->timestamp);

        $store->put(
            self::key($qrCode),
            $data,
            $ttl
        );

        // ===============================
        // 4. HAPUS INDEX AKTIF
        // ===============================
        $store->forget(
            self::activeKey(
                $data['user_id'],
                $data['pasar_id'],
                $data['type']
            )
        );
    }

    public static function key(string $qrCode): string
    {
        return "connection:qr:{$qrCode}";
    }

    public static function activeKey(int $userId, int $pasarId, string $type): string
    {
        return "connection:qr:active:{$userId}:{$pasarId}:{$type}";
    }
}
