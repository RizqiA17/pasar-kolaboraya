# Pilar III — Aksi Kolektif Scoring System

## Ringkasan

Sistem perhitungan kualitas aksi kolektif menggunakan 6 metrik utama untuk menilai efektivitas dan dampak dari aksi kolektif dalam platform Pasar Kolaboraya.

## Data Sumber

- `collective_actions` - Tabel aksi kolektif
- `collective_action_users` - Relasi user dengan aksi kolektif
- `collective_action_contributions` - Kontribusi untuk aksi kolektif
- `collective_action_ecosystem_invitations` - Undangan ekosistem ke aksi kolektif
- `contributions` - Master data jenis kontribusi

## 6 Metrik Utama

### 1. Action Activity Rate (Tingkat Aktivitas Aksi)
**Tujuan**: Mengukur tingkat aktivitas aksi kolektif

**Data**:
- `active` = jumlah aksi dengan status = 'active'
- `completed` = jumlah aksi dengan status = 'completed'
- `total` = jumlah total aksi

**Rumus**:
```
activity_rate = (active + completed) / total
activity_score = activity_rate * 100
```

**Implementasi**: Untuk satu aksi, skor = 100% jika status 'active' atau 'completed', 0% untuk status lain.

### 2. Scale & Scope Impact (Dampak Skala & Cakupan)
**Tujuan**: Mengukur dampak berdasarkan skala dan cakupan aksi

**Data**:
- `scale`: kecil = 1, sedang = 2, besar = 3
- `scope`: local = 1, national = 2, international = 3

**Rumus**:
```
impact_value = scale_weight * scope_weight
impact_raw = impact_value
impact_ref = 300 (nilai acuan maksimum)
impact_score = min(impact_raw / impact_ref, 1) * 100
```

**Contoh**:
- Aksi besar nasional: 3 × 2 = 6, skor = (6/300) × 100 = 2%
- Aksi kecil lokal: 1 × 1 = 1, skor = (1/300) × 100 = 0.33%

### 3. Action Participation Rate (Tingkat Partisipasi User)
**Tujuan**: Mengukur tingkat partisipasi user dalam aksi

**Data**:
- `participants` = jumlah user dengan status = 'active'
- `total_registered` = jumlah total user terdaftar

**Rumus**:
```
participation_rate = participants / total_registered
participation_score = participation_rate * 100
```

### 4. Action Ecosystem Engagement (Keterlibatan Ekosistem)
**Tujuan**: Mengukur tingkat keterlibatan ekosistem dalam aksi

**Data**:
- `accepted` = jumlah undangan ekosistem yang diterima
- `invited` = jumlah total undangan ekosistem

**Rumus**:
```
engagement_rate = accepted / invited
engagement_score = engagement_rate * 100
```

### 5. Action Contribution Completion Rate (Tingkat Penyelesaian Kontribusi)
**Tujuan**: Mengukur tingkat penyelesaian kontribusi dalam aksi

**Data**:
- `completed` = jumlah kontribusi dengan status = 'completed'
- `total` = jumlah total kontribusi

**Rumus**:
```
completion_rate = completed / total
completion_score = completion_rate * 100
```

### 6. Action Contribution Diversity (Keragaman Kontribusi)
**Tujuan**: Mengukur keragaman jenis kontribusi menggunakan HHI (Herfindahl-Hirschman Index)

**Data**:
- Hitung jumlah kontribusi per `contribution_id` (join ke tabel `contributions`)
- `sᵢ` = proporsi kontribusi tipe i
- `K` = jumlah tipe kontribusi unik

**Rumus**:
```
HHI = Σ(sᵢ²)
diversity_score = (1 - HHI) / (1 - 1/K) * 100
```

**Penjelasan**:
- HHI = 1 jika hanya ada 1 jenis kontribusi (tidak beragam)
- HHI = 1/K jika semua jenis kontribusi sama banyak (paling beragam)
- Skor diversity = 0% jika tidak beragam, 100% jika sangat beragam

## Skor Akhir

**Aksi_score** = rata-rata dari 6 metrik:
```
aksi_score = (
    activity_score + 
    impact_score + 
    participation_score + 
    engagement_score + 
    completion_score + 
    diversity_score
) / 6
```

## Implementasi

### Model CollectiveAction
```php
public function calculateAksiScore(): array
{
    // Implementasi 6 metrik
    // Return array dengan skor individual dan detail
}
```

### Model PasarKolaboraya
```php
public function calculateCollectiveActionQuality(): float
{
    // Hitung rata-rata aksi_score dari semua aksi kolektif
}
```

### AdminController
```php
private function calculateCollectiveActionQualityScore(PasarKolaboraya $pasarKolaboraya)
{
    // Implementasi untuk admin dashboard
}
```

## Contoh Hasil

```
Aksi Score: 23.8%
├── Activity Score: 0% (status: planning)
├── Impact Score: 2% (besar × nasional = 6/300)
├── Participation Score: 0% (tidak ada user aktif)
├── Engagement Score: 25% (1 dari 4 undangan diterima)
├── Completion Score: 20% (1 dari 5 kontribusi selesai)
└── Diversity Score: 96% (sangat beragam)
```

## Keunggulan Sistem

1. **Komprehensif**: Mencakup aspek aktivitas, dampak, partisipasi, dan keragaman
2. **Terukur**: Semua metrik menggunakan data kuantitatif
3. **Seimbang**: Tidak ada metrik yang mendominasi perhitungan
4. **Fleksibel**: Dapat disesuaikan dengan berbagai jenis aksi kolektif
5. **Transparan**: Detail perhitungan tersedia untuk audit

## Penggunaan

Sistem ini digunakan untuk:
- Menilai kualitas aksi kolektif individual
- Menghitung rata-rata kualitas aksi dalam Pasar Kolaboraya
- Memberikan insight untuk perbaikan aksi kolektif
- Membandingkan performa antar aksi kolektif

