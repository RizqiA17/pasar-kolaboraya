# Flow Diagram - Tombol Berkontribusi

## Flow untuk Ekosistem

```mermaid
flowchart TD
    A[User melihat ekosistem] --> B{User sudah login?}
    B -->|Tidak| C[Tampilkan tombol Bergabung]
    B -->|Ya| D{User dapat bergabung?}
    D -->|Tidak| E{User komunitas?}
    E -->|Ya| F[Tampilkan pesan: Hanya dapat terhubung]
    E -->|Tidak| G{Ekosistem penuh?}
    G -->|Ya| H[Tampilkan: Ekosistem Penuh]
    G -->|Tidak| I[Status lain]
    D -->|Ya| J{User sudah bergabung?}
    J -->|Tidak| K[Tampilkan tombol Bergabung]
    J -->|Ya| L{Status user?}
    L -->|accepted| M[Tampilkan tombol Berkontribusi]
    L -->|pending| N[Tampilkan status: Menunggu Persetujuan]
    L -->|rejected| O[Tampilkan status: Ditolak]
    
    M --> P[Redirect ke ecosystem.contribute]
    K --> Q[Redirect ke halaman join]
```

## Flow untuk Aksi Kolektif

```mermaid
flowchart TD
    A[User melihat aksi kolektif] --> B{User sudah login?}
    B -->|Tidak| C[Tampilkan tombol Lihat Detail]
    B -->|Ya| D{User sudah terdaftar?}
    D -->|Tidak| E{User dapat bergabung?}
    E -->|Ya| F{User dapat join?}
    F -->|Ya| G[Tampilkan tombol Bergabung + Lihat Detail]
    F -->|Tidak| H[Tampilkan tombol Lihat Detail saja]
    E -->|Tidak| I[Tampilkan tombol Lihat Detail saja]
    D -->|Ya| J{Status user?}
    J -->|active| K[Tampilkan tombol Berkontribusi + Lihat Detail]
    J -->|pending_approval| L[Tampilkan status: Menunggu Persetujuan]
    J -->|rejected| M[Tampilkan status: Ditolak]
    J -->|inactive| N[Tampilkan status: Tidak Aktif]
    
    K --> O[Redirect ke collective-action.contribute]
    G --> P[Redirect ke halaman join]
```

## Kondisi Status User

### Ekosistem
- **accepted**: User sudah diterima → Tombol "Berkontribusi"
- **pending**: User menunggu persetujuan → Status badge
- **rejected**: User ditolak → Status badge

### Aksi Kolektif
- **active**: User sudah aktif → Tombol "Berkontribusi" + "Lihat Detail"
- **pending_approval**: User menunggu persetujuan → Status badge
- **rejected**: User ditolak → Status badge
- **inactive**: User tidak aktif → Status badge

## Routes yang Digunakan

- `ecosystem.contribute` - Halaman kontribusi ekosistem
- `collective-action.contribute` - Halaman kontribusi aksi kolektif
- `ecosystem.join` - Halaman bergabung ekosistem
- `collective-action.join` - Halaman bergabung aksi kolektif
