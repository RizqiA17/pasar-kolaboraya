<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'created_by',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public static function getActiveSurvey()
    {
        return static::where('is_active', true)->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getResources()
    {
        return $this->responses
            ->flatMap(fn($r) => $r['sumber_daya_disumbangkan'] ?? [])
            ->unique()
            ->values()
            ->all();
    }

    public function getResponsesCount()
    {
        return $this->responses()->count();
    }

    public function getAverageScores()
    {
        $responses = $this->responses;

        if ($responses->isEmpty()) {
            return [
                'koneksi' => 0,
                'kolaborasi' => 0,
                'aksi' => 0,
            ];
        }

        return [
            'koneksi' => [
                'jumlah_koneksi' => round($responses->avg('jumlah_koneksi'), 2),
                'rata_kualitas_koneksi' => round($responses->avg('rata_kualitas_koneksi'), 2),
                'keluasan_jejaring' => round($responses->avg('keluasan_jejaring'), 2),
            ],
            'kolaborasi' => [
                'kualitas_kolaborasi' => round($responses->avg('kualitas_kolaborasi'), 2),
                'keragaman_kolaborator' => round($responses->avg('keragaman_kolaborator'), 2),
                'jumlah_proyek_kolaborasi' => round($responses->avg('jumlah_proyek_kolaborasi'), 2),
                'tingkat_kolaborasi' => round($responses->avg('tingkat_kolaborasi'), 2),
                'sumber_daya_disumbangkan' => count($responses
                    ->flatMap(fn($r) => $r['sumber_daya_disumbangkan'] ?? [])
                    ->unique()
                    ->values()
                    ->all(), )
            ],
            'aksi' => [
                'jumlah_aksi_besar' => round($responses->avg('jumlah_aksi_besar'), 2),
                'jumlah_aksi_sedang' => round($responses->avg('jumlah_aksi_sedang'), 2),
                'jumlah_aksi_kecil' => round($responses->avg('jumlah_aksi_kecil'), 2),
            ]
        ];
    }
}
