@extends('emails.layouts.base')

@section('title', 'Verifikasi Email - Pasar Kolaboraya')

@section('content')
    <div class="greeting">Halo {{ $user->name }}! 👋</div>
    
    <div class="message">
        Selamat datang di <strong>Pasar Kolaboraya</strong>! Kami senang Anda telah bergabung dengan platform kolaborasi dan koneksi terbaik.
    </div>
    
    <div class="highlight-box">
        <p style="margin: 0; font-weight: 600; color: #2d3748;">
            🎯 Langkah selanjutnya: Verifikasi alamat email Anda untuk mengaktifkan akun dan mulai berkolaborasi!
        </p>
    </div>
    
    <div class="message">
        Untuk memverifikasi alamat email Anda, silakan klik tombol di bawah ini:
    </div>
    
    <div class="button-container">
        <a href="{{ $verificationUrl }}" class="primary-button">
            ✨ Verifikasi Email Sekarang
        </a>
    </div>
    
    <div class="divider"></div>
    
    <div class="message">
        <strong>Alternatif:</strong> Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan menempelkan URL berikut ke browser Anda:
    </div>
    
    <div class="url-text">
        {{ $verificationUrl }}
    </div>
    
    <div class="warning">
        ⏰ <strong>Penting:</strong> Link verifikasi ini akan kadaluarsa dalam <strong>60 menit</strong>.
    </div>
    
    <div class="message">
        Setelah verifikasi, Anda akan dapat:
    </div>
    
    @if(in_array($user->user_type, ['tamu', 'komunitas']))
        {{-- Hanya tampilkan bagian koneksi untuk tamu dan komunitas --}}
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Koneksi</div>
                <div class="info-value">Jaringan Profesional</div>
            </div>
        </div>
    @else
        {{-- Tampilkan semua fitur untuk partisipan --}}
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Kolaborasi</div>
                <div class="info-value">Bergabung ke Ekosistem</div>
            </div>
            <div class="info-item">
                <div class="info-label">Koneksi</div>
                <div class="info-value">Jaringan Profesional</div>
            </div>
            <div class="info-item">
                <div class="info-label">Aksi</div>
                <div class="info-value">Ikuti Aksi Kolektif</div>
            </div>
            <div class="info-item">
                <div class="info-label">Skill</div>
                <div class="info-value">Tampilkan Keahlian</div>
            </div>
        </div>
    @endif
    
    <div class="message">
        Jika Anda tidak membuat akun di Pasar Kolaboraya, Anda dapat mengabaikan email ini dengan aman.
    </div>
    
    <div class="success">
        🚀 <strong>Bersiaplah untuk memulai perjalanan kolaborasi yang luar biasa!</strong>
    </div>
@endsection
