<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyResponse extends Model
{
    protected $fillable = [
        'survey_id',
        'user_id',
        // Kategori Koneksi
        'jumlah_koneksi',
        'jumlah_koneksi_alasan',
        'rata_kualitas_koneksi',
        'rata_kualitas_koneksi_alasan',
        'keluasan_jejaring',
        'keluasan_jejaring_alasan',
        // Kategori Kolaborasi
        'kualitas_kolaborasi',
        'kualitas_kolaborasi_alasan',
        'keragaman_kolaborator',
        'keragaman_kolaborator_alasan',
        'jumlah_proyek_kolaborasi',
        'jumlah_proyek_kolaborasi_alasan',
        'tingkat_kolaborasi',
        'tingkat_kolaborasi_alasan',
        'sumber_daya_disumbangkan',
        'sumber_daya_disumbangkan_alasan',
        // Kategori Aksi
        'jumlah_aksi_besar',
        'jumlah_aksi_besar_alasan',
        'jumlah_aksi_sedang',
        'jumlah_aksi_sedang_alasan',
        'jumlah_aksi_kecil',
        'jumlah_aksi_kecil_alasan',
    ];

    protected $casts = [
        'sumber_daya_disumbangkan' => 'array',
    ];

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSumberDayaOptions()
    {
        return [
            'dana' => 'Dana',
            'keahlian' => 'Keahlian',
            'infrastruktur' => 'Infrastruktur',
            'akses_pasar' => 'Akses Pasar',
            'relasi' => 'Relasi',
            'teknologi' => 'Teknologi',
        ];
    }

    public function getKeluasanJejaringLabel()
    {
        $labels = [
            1 => 'Lokal',
            2 => 'Kabupaten',
            3 => 'Provinsi',
            4 => 'Nasional',
            5 => 'Internasional',
        ];

        return $labels[$this->keluasan_jejaring] ?? 'Tidak Diketahui';
    }

    public static function getKeluasanJejaringOptions()
    {
        return [
            1 => '1 - Lokal',
            2 => '2 - Kabupaten',
            3 => '3 - Provinsi',
            4 => '4 - Nasional',
            5 => '5 - Internasional',
        ];
    }
}
