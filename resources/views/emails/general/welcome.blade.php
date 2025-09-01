@extends('emails.layouts.base')

@section('title', 'Selamat Datang di Pasar Kolaboraya! 🎉')

@section('content')
    <div class="greeting">Selamat Datang {{ $user->name }}! 🎊</div>
    
    <div class="message">
        Kami sangat senang Anda telah bergabung dengan <strong>Pasar Kolaboraya</strong> - platform kolaborasi dan koneksi terbaik untuk para profesional kreatif!
    </div>
    
    <div class="highlight-box">
        <p style="margin: 0; font-weight: 600; color: #2d3748;">
            🚀 Anda siap memulai perjalanan kolaborasi yang luar biasa!
        </p>
    </div>
    
    <div class="message">
        <strong>Yang dapat Anda lakukan di Pasar Kolaboraya:</strong>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">🤝 Kolaborasi</div>
            <div class="info-value">Buat & Bergabung Project</div>
        </div>
        <div class="info-item">
            <div class="info-label">🌐 Koneksi</div>
            <div class="info-value">Jaringan Profesional</div>
        </div>
        <div class="info-item">
            <div class="info-label">📅 Event</div>
            <div class="info-value">Ikuti & Buat Event</div>
        </div>
        <div class="info-item">
            <div class="info-label">💡 Skill</div>
            <div class="info-value">Tampilkan Keahlian</div>
        </div>
    </div>
    
    <div class="button-container">
        <a href="{{ url('/dashboard') }}" class="primary-button">
            🏠 Mulai Jelajahi Dashboard
        </a>
    </div>
    
    <div class="divider"></div>
    
    <div class="message">
        <strong>Langkah awal yang disarankan:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 15px 0;">
            <span style="margin-right: 15px; font-size: 20px;">1️⃣</span>
            <div>
                <strong>Lengkapi Profil Anda</strong><br>
                <span style="color: #718096; font-size: 14px;">Tambahkan foto, bio, dan skill yang Anda miliki</span>
            </div>
        </div>
        <div style="display: flex; align-items: center; margin: 15px 0;">
            <span style="margin-right: 15px; font-size: 20px;">2️⃣</span>
            <div>
                <strong>Jelajahi Kolaborasi</strong><br>
                <span style="color: #718096; font-size: 14px;">Lihat project yang sedang berlangsung dan bergabunglah</span>
            </div>
        </div>
        <div style="display: flex; align-items: center; margin: 15px 0;">
            <span style="margin-right: 15px; font-size: 20px;">3️⃣</span>
            <div>
                <strong>Buat Koneksi</strong><br>
                <span style="color: #718096; font-size: 14px;">Temukan dan hubungi profesional lain</span>
            </div>
        </div>
        <div style="display: flex; align-items: center; margin: 15px 0;">
            <span style="margin-right: 15px; font-size: 20px;">4️⃣</span>
            <div>
                <strong>Ikuti Event</strong><br>
                <span style="color: #718096; font-size: 14px;">Bergabung dengan event menarik di komunitas</span>
            </div>
        </div>
    </div>
    
    <div class="message">
        <strong>Fitur Unggulan:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🎯</span>
            <span><strong>Smart Matching:</strong> Sistem AI yang menghubungkan Anda dengan kolaborator yang tepat</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">📊</span>
            <span><strong>Progress Tracking:</strong> Pantau kemajuan kolaborasi secara real-time</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🔔</span>
            <span><strong>Smart Notifications:</strong> Update otomatis untuk semua aktivitas penting</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">📱</span>
            <span><strong>Mobile Friendly:</strong> Akses dari mana saja dengan responsif</span>
        </div>
    </div>
    
    <div class="button-container">
        <a href="{{ url('/profile/edit') }}" class="secondary-button">
            ✏️ Edit Profil
        </a>
        <a href="{{ url('/collaborations') }}" class="secondary-button">
            🔍 Lihat Kolaborasi
        </a>
        <a href="{{ url('/connections') }}" class="secondary-button">
            👥 Temukan Koneksi
        </a>
    </div>
    
    <div class="success">
        🌟 <strong>Selamat bergabung dengan komunitas Pasar Kolaboraya! Bersiaplah untuk menciptakan sesuatu yang luar biasa bersama!</strong>
    </div>
    
    <div class="message" style="text-align: center; margin-top: 30px; font-size: 14px; color: #718096;">
        Jika Anda memiliki pertanyaan, tim support kami siap membantu!<br>
        Email: support@pasar-kolaboraya.com
    </div>
@endsection
