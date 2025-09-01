@extends('emails.layouts.base')

@section('title', 'Selamat Datang di Pasar Kolaboraya')

@section('content')
    <div class="greeting">Selamat Datang {{ $user->name }}! 🎉</div>
    
    <div class="message">
        Kami sangat senang Anda telah bergabung dengan <strong>Pasar Kolaboraya</strong> - platform kolaborasi dan koneksi profesional terbaik di Indonesia!
    </div>
    
    <div class="highlight-box">
        <p style="margin: 0; font-weight: 600; color: #2d3748;">
            🚀 Mulai perjalanan kolaborasi Anda sekarang dan temukan peluang tak terbatas!
        </p>
    </div>
    
    <div class="message">
        Dengan bergabung di Pasar Kolaboraya, Anda akan mendapatkan akses ke:
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Kolaborasi</div>
            <div class="info-value">Buat & Bergabung Project</div>
        </div>
        <div class="info-item">
            <div class="info-label">Koneksi</div>
            <div class="info-value">Jaringan Profesional</div>
        </div>
        <div class="info-item">
            <div class="info-label">Event</div>
            <div class="info-value">Workshop & Seminar</div>
        </div>
        <div class="info-item">
            <div class="info-label">Skill</div>
            <div class="info-value">Tampilkan Keahlian</div>
        </div>
    </div>
    
    <div class="message">
        <strong>Langkah selanjutnya untuk memulai:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 15px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
            <span style="margin-right: 15px; font-size: 20px;">1️⃣</span>
            <div>
                <strong>Lengkapi Profil</strong><br>
                <span style="color: #6b7280;">Tambahkan foto, bio, dan keahlian Anda</span>
            </div>
        </div>
        <div style="display: flex; align-items: center; margin: 15px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
            <span style="margin-right: 15px; font-size: 20px;">2️⃣</span>
            <div>
                <strong>Jelajahi Kolaborasi</strong><br>
                <span style="color: #6b7280;">Temukan project yang sesuai dengan minat Anda</span>
            </div>
        </div>
        <div style="display: flex; align-items: center; margin: 15px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
            <span style="margin-right: 15px; font-size: 20px;">3️⃣</span>
            <div>
                <strong>Buat Koneksi</strong><br>
                <span style="color: #6b7280;">Hubungi profesional lain untuk berkolaborasi</span>
            </div>
        </div>
    </div>
    
    <div class="button-container">
        <a href="{{ config('app.url') }}/dashboard" class="primary-button">
            🎯 Mulai Sekarang
        </a>
    </div>
    
    <div class="divider"></div>
    
    <div class="message">
        <strong>Fitur Unggulan:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">💼</span>
            <span><strong>Project Management:</strong> Kelola kolaborasi dengan tools yang powerful</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🤝</span>
            <span><strong>Skill Matching:</strong> Temukan partner berdasarkan keahlian</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">📅</span>
            <span><strong>Event Management:</strong> Buat dan ikuti event profesional</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">📊</span>
            <span><strong>Analytics:</strong> Pantau progress kolaborasi Anda</span>
        </div>
    </div>
    
    <div class="success">
        🌟 <strong>Selamat datang di komunitas kolaborasi terbaik!</strong>
    </div>
    
    <div class="message" style="margin-top: 20px; font-size: 14px; color: #6b7280;">
        Jika Anda memiliki pertanyaan atau butuh bantuan, jangan ragu untuk menghubungi tim support kami.
    </div>
@endsection

