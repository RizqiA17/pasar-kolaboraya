@extends('emails.layouts.base')

@section('title', 'Koneksi Baru: ' . $connectedUser->name)

@section('content')
    <div class="greeting">Halo {{ $notifiable->name }}! 👋</div>
    
    <div class="message">
        Selamat! Anda telah berhasil terhubung dengan <strong>{{ $connectedUser->name }}</strong> di <strong>Pasar Kolaboraya</strong>!
    </div>
    
    <div class="highlight-box">
        <p style="margin: 0; font-weight: 600; color: #2d3748;">
            🤝 Koneksi Baru Berhasil Dibuat!
        </p>
    </div>
    
    <div class="message">
        <strong>Profil {{ $connectedUser->name }}:</strong>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Profesi</div>
            <div class="info-value">{{ $connectedUser->profile->profession ?? 'Profesional' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Perusahaan</div>
            <div class="info-value">{{ $connectedUser->profile->company ?? 'Tidak disebutkan' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Lokasi</div>
            <div class="info-value">{{ $connectedUser->profile->location ?? 'Tidak disebutkan' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Status</div>
            <div class="info-value">Terkoneksi</div>
        </div>
    </div>
    
    @if($connectedUser->profile->bio)
    <div class="message">
        <strong>Bio:</strong>
    </div>
    
    <div style="background: #f8fafc; padding: 20px; border-radius: 8px; border-left: 4px solid #667eea; margin: 20px 0;">
        <p style="margin: 0; color: #4a5568; line-height: 1.6;">
            {{ $connectedUser->profile->bio }}
        </p>
    </div>
    @endif
    
    <div class="message">
        <strong>Keahlian {{ $connectedUser->name }}:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        @if($connectedUser->skills && $connectedUser->skills->count() > 0)
            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                @foreach($connectedUser->skills->take(6) as $skill)
                    <span style="background: #667eea; color: white; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 500;">
                        {{ $skill->name }}
                    </span>
                @endforeach
                @if($connectedUser->skills->count() > 6)
                    <span style="background: #e2e8f0; color: #4a5568; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 500;">
                        +{{ $connectedUser->skills->count() - 6 }} lagi
                    </span>
                @endif
            </div>
        @else
            <p style="color: #6b7280; font-style: italic;">Belum ada keahlian yang ditambahkan</p>
        @endif
    </div>
    
    <div class="message">
        <strong>Yang dapat Anda lakukan sekarang:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 15px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
            <span style="margin-right: 15px; font-size: 20px;">1️⃣</span>
            <div>
                <strong>Kirim Pesan</strong><br>
                <span style="color: #6b7280;">Mulai percakapan dan kenali lebih dekat</span>
            </div>
        </div>
        <div style="display: flex; align-items: center; margin: 15px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
            <span style="margin-right: 15px; font-size: 20px;">2️⃣</span>
            <div>
                <strong>Lihat Portfolio</strong><br>
                <span style="color: #6b7280;">Lihat karya dan project yang telah dibuat</span>
            </div>
        </div>
        <div style="display: flex; align-items: center; margin: 15px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
            <span style="margin-right: 15px; font-size: 20px;">3️⃣</span>
            <div>
                <strong>Kolaborasi</strong><br>
                <span style="color: #6b7280;">Ajukan project atau bergabung bersama</span>
            </div>
        </div>
    </div>
    
    <div class="button-container">
        <a href="{{ config('app.url') }}/profile/{{ $connectedUser->id }}" class="primary-button">
            👤 Lihat Profil Lengkap
        </a>
    </div>
    
    <div class="divider"></div>
    
    <div class="message">
        <strong>Tips membangun koneksi yang kuat:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">💬</span>
            <span><strong>Komunikasi Aktif:</strong> Kirim pesan secara berkala</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🎯</span>
            <span><strong>Berikan Value:</strong> Bagikan insight atau informasi berguna</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🤝</span>
            <span><strong>Kolaborasi:</strong> Bekerja sama dalam project</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🌟</span>
            <span><strong>Referensi:</strong> Rekomendasikan ke koneksi lain</span>
        </div>
    </div>
    
    <div class="success">
        🌐 <strong>Jaringan profesional Anda semakin luas!</strong>
    </div>
    
    <div class="message" style="margin-top: 20px; font-size: 14px; color: #6b7280;">
        Teruslah membangun koneksi yang bermakna untuk pertumbuhan karir dan bisnis Anda.
    </div>
@endsection
