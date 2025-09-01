@extends('emails.layouts.base')

@section('title', 'Reset Password - Pasar Kolaboraya')

@section('content')
    <div class="greeting">Halo {{ $user->name }}! 🔐</div>
    
    <div class="message">
        Kami menerima permintaan untuk mereset password akun <strong>Pasar Kolaboraya</strong> Anda.
    </div>
    
    <div class="highlight-box">
        <p style="margin: 0; font-weight: 600; color: #2d3748;">
            🔑 Klik tombol di bawah untuk membuat password baru yang aman!
        </p>
    </div>
    
    <div class="message">
        Untuk melanjutkan proses reset password, silakan klik tombol di bawah ini:
    </div>
    
    <div class="button-container">
        <a href="{{ $resetUrl }}" class="primary-button">
            🔒 Reset Password Sekarang
        </a>
    </div>
    
    <div class="divider"></div>
    
    <div class="message">
        <strong>Alternatif:</strong> Jika tombol di atas tidak berfungsi, Anda dapat menyalin dan menempelkan URL berikut ke browser Anda:
    </div>
    
    <div class="url-text">
        {{ $resetUrl }}
    </div>
    
    <div class="warning">
        ⏰ <strong>Penting:</strong> Link reset password ini akan kadaluarsa dalam <strong>60 menit</strong>.
    </div>
    
    <div class="message">
        <strong>Tips Keamanan Password:</strong>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Panjang</div>
            <div class="info-value">Minimal 8 karakter</div>
        </div>
        <div class="info-item">
            <div class="info-label">Kompleksitas</div>
            <div class="info-value">Huruf + Angka + Simbol</div>
        </div>
        <div class="info-item">
            <div class="info-label">Unik</div>
            <div class="info-value">Jangan gunakan di tempat lain</div>
        </div>
        <div class="info-item">
            <div class="info-label">Update</div>
            <div class="info-value">Ganti secara berkala</div>
        </div>
    </div>
    
    <div class="message">
        Jika Anda tidak meminta reset password, Anda dapat mengabaikan email ini dengan aman. Password Anda tidak akan berubah.
    </div>
    
    <div class="success">
        🛡️ <strong>Jaga selalu keamanan akun Anda!</strong>
    </div>
@endsection
