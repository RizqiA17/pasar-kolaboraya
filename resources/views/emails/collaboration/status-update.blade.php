@extends('emails.layouts.base')

@section('title', 'Update Status Kolaborasi - Pasar Kolaboraya')

@section('content')
    <div class="greeting">Halo {{ $notifiable->name }}! 📢</div>
    
    <div class="message">
        Ada update status untuk kolaborasi <strong>"{{ $collaboration->title }}"</strong> yang perlu Anda ketahui.
    </div>
    
    <div class="highlight-box">
        <p style="margin: 0; font-weight: 600; color: #2d3748;">
            🔄 Update Status Kolaborasi
        </p>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Judul Kolaborasi</div>
            <div class="info-value">{{ $collaboration->title }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Member</div>
            <div class="info-value">{{ $user->name }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Aksi</div>
            <div class="info-value">
                @if($action === 'accepted')
                    <span style="color: #22543d;">✅ Menerima</span>
                @else
                    <span style="color: #c53030;">❌ Menolak</span>
                @endif
            </div>
        </div>
        <div class="info-item">
            <div class="info-label">Status</div>
            <div class="info-value">
                @if($status === 'accepted')
                    <span style="color: #22543d;">Diterima</span>
                @else
                    <span style="color: #c53030;">Ditolak</span>
                @endif
            </div>
        </div>
    </div>
    
    @if($action === 'accepted')
    <div class="success">
        🎉 <strong>Selamat!</strong> {{ $user->name }} telah bergabung dengan kolaborasi Anda. Tim kolaborasi Anda semakin kuat!
    </div>
    
    <div class="message">
        Dengan bergabungnya {{ $user->name }}, kolaborasi ini akan mendapatkan:
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">💪</span>
            <span>Diversitas skill dan pengalaman</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🤝</span>
            <span>Perspektif dan ide baru</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🚀</span>
            <span>Potensi hasil yang lebih besar</span>
        </div>
    </div>
    
    @else
    <div class="warning">
        ℹ️ <strong>Informasi:</strong> {{ $user->name }} telah menolak undangan kolaborasi Anda.
    </div>
    
    <div class="message">
        Jangan khawatir! Ini adalah hal yang normal dalam dunia kolaborasi. Anda masih dapat:
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🔍</span>
            <span>Mencari member lain yang sesuai</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">📝</span>
            <span>Menyempurnakan deskripsi kolaborasi</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">💡</span>
            <span>Mengembangkan ide kolaborasi lebih lanjut</span>
        </div>
    </div>
    @endif
    
    <div class="button-container">
        <a href="{{ url('/collaborations/' . $collaboration->id) }}" class="primary-button">
            👀 Lihat Detail Kolaborasi
        </a>
    </div>
    
    <div class="divider"></div>
    
    <div class="message">
        <strong>Langkah selanjutnya yang dapat Anda lakukan:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">📧</span>
            <span>Kirim pesan selamat datang ke member baru (jika diterima)</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">📋</span>
            <span>Review dan update rencana kolaborasi</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🎯</span>
            <span>Mulai eksekusi project kolaborasi</span>
        </div>
    </div>
    
    <div class="success">
        🚀 <strong>Terus semangat dalam membangun kolaborasi yang luar biasa!</strong>
    </div>
@endsection
