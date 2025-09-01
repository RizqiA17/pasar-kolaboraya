@extends('emails.layouts.base')

@section('title', 'Koneksi Baru: {{ $connectedUser->name }} - Pasar Kolaboraya')

@section('content')
    <div class="greeting">Halo {{ $notifiable->name }}! 🤝</div>
    
    <div class="message">
        Selamat! Anda mendapat koneksi baru di <strong>Pasar Kolaboraya</strong>. Jaringan profesional Anda semakin luas!
    </div>
    
    <div class="highlight-box">
        <p style="margin: 0; font-weight: 600; color: #2d3748;">
            🎉 Koneksi Baru: {{ $connectedUser->name }}
        </p>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">👤 Nama</div>
            <div class="info-value">{{ $connectedUser->name }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">💼 Profesi</div>
            <div class="info-value">{{ $connectedUser->profile->profession ?? 'Tidak disebutkan' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">🏢 Perusahaan</div>
            <div class="info-value">{{ $connectedUser->profile->company ?? 'Tidak disebutkan' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">📍 Lokasi</div>
            <div class="info-value">{{ $connectedUser->profile->location ?? 'Tidak disebutkan' }}</div>
        </div>
    </div>
    
    @if($connectedUser->profile && $connectedUser->profile->bio)
    <div class="message">
        <strong>Tentang {{ $connectedUser->name }}:</strong>
    </div>
    <div class="highlight-box">
        <p style="margin: 0; color: #4a5568;">
            {{ $connectedUser->profile->bio }}
        </p>
    </div>
    @endif
    
    @if($connectedUser->skills && $connectedUser->skills->count() > 0)
    <div class="message">
        <strong>Skill yang dimiliki:</strong>
    </div>
    <div style="margin: 20px 0;">
        @foreach($connectedUser->skills->take(6) as $skill)
            <span style="display: inline-block; background: #667eea; color: white; padding: 6px 12px; border-radius: 20px; margin: 5px; font-size: 12px;">
                {{ $skill->name }}
            </span>
        @endforeach
        @if($connectedUser->skills->count() > 6)
            <span style="display: inline-block; background: #e2e8f0; color: #4a5568; padding: 6px 12px; border-radius: 20px; margin: 5px; font-size: 12px;">
                +{{ $connectedUser->skills->count() - 6 }} lainnya
            </span>
        @endif
    </div>
    @endif
    
    <div class="message">
        <strong>Mengapa koneksi ini berharga:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">💡</span>
            <span>Potensi kolaborasi project yang menarik</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🌐</span>
            <span>Memperluas jaringan profesional Anda</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">📚</span>
            <span>Belajar dari pengalaman dan skill baru</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🚀</span>
            <span>Kesempatan karir dan bisnis</span>
        </div>
    </div>
    
    <div class="button-container">
        <a href="{{ url('/profile/' . $connectedUser->id) }}" class="primary-button">
            👀 Lihat Profil Lengkap
        </a>
    </div>
    
    <div class="divider"></div>
    
    <div class="message">
        <strong>Aksi yang dapat Anda lakukan:</strong>
    </div>
    
    <div style="display: flex; gap: 15px; margin: 20px 0; flex-wrap: wrap;">
        <a href="{{ url('/messages/' . $connectedUser->id) }}" class="secondary-button" style="background: #f0fff4; color: #22543d; border-color: #9ae6b4;">
            💬 Kirim Pesan
        </a>
        <a href="{{ url('/collaborations/create?with=' . $connectedUser->id) }}" class="secondary-button">
            🤝 Buat Kolaborasi
        </a>
        <a href="{{ url('/connections') }}" class="secondary-button">
            👥 Lihat Semua Koneksi
        </a>
    </div>
    
    <div class="message">
        <strong>Tips membangun koneksi yang kuat:</strong>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">💬 Komunikasi</div>
            <div class="info-value">Mulai dengan pesan yang ramah</div>
        </div>
        <div class="info-item">
            <div class="info-label">🤝 Kolaborasi</div>
            <div class="info-value">Tawarkan project bersama</div>
        </div>
        <div class="info-item">
            <div class="info-label">📅 Event</div>
            <div class="info-value">Undang ke event yang relevan</div>
        </div>
        <div class="info-item">
            <div class="info-label">💡 Value</div>
            <div class="info-value">Berikan value tanpa pamrih</div>
        </div>
    </div>
    
    <div class="success">
        🌟 <strong>Selamat! Jaringan profesional Anda semakin kuat. Manfaatkan koneksi ini untuk berkembang bersama!</strong>
    </div>
    
    <div class="message" style="text-align: center; margin-top: 30px; font-size: 14px; color: #718096;">
        Ingin menemukan lebih banyak koneksi? <a href="{{ url('/connections/discover') }}" style="color: #667eea;">Jelajahi fitur Discover</a> kami!
    </div>
@endsection
