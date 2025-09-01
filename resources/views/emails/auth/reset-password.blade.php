@extends('emails.layouts.base')

@section('title', 'Reset Password - Pasar Kolaboraya')

@section('content')
    <div class="greeting">Halo {{ $user->name }}! 🔐</div>
    
    <div class="message">
        Kami menerima permintaan untuk mereset password akun <strong>Pasar Kolaboraya</strong> Anda.
    </div>
    
    <div class="highlight-box">
        <p style="margin: 0; font-weight: 600; color: #2d3748;">
            🔒 Reset Password Akun
        </p>
    </div>
    
    <div class="message">
        Untuk melanjutkan proses reset password, silakan klik tombol di bawah ini:
    </div>
    
    <div class="button-container">
        <a href="{{ $resetUrl }}" class="primary-button">
            🔑 Reset Password Sekarang
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
        <strong>Langkah setelah reset password:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">1️⃣</span>
            <span>Klik link reset password di atas</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">2️⃣</span>
            <span>Masukkan password baru yang kuat</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">3️⃣</span>
            <span>Konfirmasi password baru</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">4️⃣</span>
            <span>Login dengan password baru</span>
        </div>
    </div>
    
    <div class="message">
        <strong>Tips Password yang Aman:</strong>
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
            <div class="info-value">Tidak sama dengan akun lain</div>
        </div>
        <div class="info-item">
            <div class="info-label">Update</div>
            <div class="info-value">Ganti secara berkala</div>
        </div>
    </div>
    
    <div class="warning">
        ⚠️ <strong>Keamanan:</strong> Jika Anda tidak meminta reset password ini, segera ubah password akun Anda dan hubungi tim support kami.
    </div>
    
    <div class="message">
        Setelah berhasil reset password, Anda dapat kembali mengakses semua fitur Pasar Kolaboraya dengan aman.
    </div>
    
    <div class="success">
        🔐 <strong>Jaga selalu keamanan akun Anda untuk pengalaman kolaborasi yang aman dan nyaman!</strong>
    </div>
@endsection
