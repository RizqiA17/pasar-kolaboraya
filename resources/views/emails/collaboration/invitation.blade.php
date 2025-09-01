@extends('emails.layouts.base')

@section('title', 'Undangan Kolaborasi - Pasar Kolaboraya')

@section('content')
    <div class="greeting">Halo {{ $notifiable->name }}! 🎉</div>
    
    <div class="message">
        Anda mendapat undangan kolaborasi yang menarik dari <strong>{{ $inviter->name }}</strong>!
    </div>
    
    <div class="highlight-box">
        <p style="margin: 0; font-weight: 600; color: #2d3748;">
            🤝 Undangan Kolaborasi Baru
        </p>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Judul Kolaborasi</div>
            <div class="info-value">{{ $collaboration->title }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Dari</div>
            <div class="info-value">{{ $inviter->name }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Kategori</div>
            <div class="info-value">{{ $collaboration->category ?? 'Umum' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Status</div>
            <div class="info-value">Menunggu Respon</div>
        </div>
    </div>
    
    @if($collaboration->description)
    <div class="message">
        <strong>Deskripsi Kolaborasi:</strong>
    </div>
    <div class="highlight-box">
        <p style="margin: 0; color: #4a5568;">
            {{ $collaboration->description }}
        </p>
    </div>
    @endif
    
    <div class="message">
        Kolaborasi ini bisa menjadi kesempatan besar untuk:
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">💡</span>
            <span>Mengembangkan skill dan pengalaman baru</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🌐</span>
            <span>Memperluas jaringan profesional</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🚀</span>
            <span>Menciptakan hasil yang luar biasa bersama</span>
        </div>
    </div>
    
    <div class="button-container">
        <a href="{{ url('/collaborations/' . $collaboration->id) }}" class="primary-button">
            👀 Lihat Detail Kolaborasi
        </a>
    </div>
    
    <div class="divider"></div>
    
    <div class="message">
        <strong>Aksi yang dapat Anda lakukan:</strong>
    </div>
    
    <div style="display: flex; gap: 15px; margin: 20px 0; flex-wrap: wrap;">
        <a href="{{ url('/collaborations/' . $collaboration->id . '/accept') }}" class="secondary-button" style="background: #f0fff4; color: #22543d; border-color: #9ae6b4;">
            ✅ Terima Undangan
        </a>
        <a href="{{ url('/collaborations/' . $collaboration->id . '/decline') }}" class="secondary-button" style="background: #fff5f5; color: #c53030; border-color: #fed7d7;">
            ❌ Tolak Undangan
        </a>
    </div>
    
    <div class="warning">
        ⏰ <strong>Reminder:</strong> Undangan ini akan kadaluarsa dalam <strong>7 hari</strong>. Silakan berikan respon Anda segera.
    </div>
    
    <div class="message">
        Jika Anda memiliki pertanyaan tentang kolaborasi ini, Anda dapat menghubungi <strong>{{ $inviter->name }}</strong> melalui platform kami.
    </div>
    
    <div class="success">
        🎯 <strong>Jangan lewatkan kesempatan emas untuk berkolaborasi dan berkembang bersama!</strong>
    </div>
@endsection
