@extends('emails.layouts.base')

@section('title', 'Update Status Kolaborasi: ' . $collaboration->title)

@section('content')
    <div class="greeting">Halo {{ $notifiable->name }}! 📊</div>
    
    <div class="message">
        Ada update status untuk kolaborasi <strong>{{ $collaboration->title }}</strong> di <strong>Pasar Kolaboraya</strong>.
    </div>
    
    @if($action == 'accepted')
        <div class="highlight-box" style="background: #f0fff4; border-left-color: #9ae6b4;">
            <p style="margin: 0; font-weight: 600; color: #22543d;">
                ✅ Kolaborasi Diterima!
            </p>
        </div>
    @elseif($action == 'declined')
        <div class="highlight-box" style="background: #fff5f5; border-left-color: #fed7d7;">
            <p style="margin: 0; font-weight: 600; color: #c53030;">
                ❌ Kolaborasi Ditolak
            </p>
        </div>
    @elseif($action == 'completed')
        <div class="highlight-box" style="background: #f0fff4; border-left-color: #9ae6b4;">
            <p style="margin: 0; font-weight: 600; color: #22543d;">
                🎉 Kolaborasi Selesai!
            </p>
        </div>
    @elseif($action == 'cancelled')
        <div class="highlight-box" style="background: #fff5f5; border-left-color: #fed7d7;">
            <p style="margin: 0; font-weight: 600; color: #c53030;">
                🚫 Kolaborasi Dibatalkan
            </p>
        </div>
    @else
        <div class="highlight-box">
            <p style="margin: 0; font-weight: 600; color: #2d3748;">
                📝 Update Status Kolaborasi
            </p>
        </div>
    @endif
    
    <div class="message">
        <strong>Detail Update:</strong>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Judul</div>
            <div class="info-value">{{ $collaboration->title }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Status Baru</div>
            <div class="info-value">{{ ucfirst($status) }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Aksi</div>
            <div class="info-value">{{ ucfirst($action) }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Oleh</div>
            <div class="info-value">{{ $user->name }}</div>
        </div>
    </div>
    
    <div class="message">
        <strong>Deskripsi Kolaborasi:</strong>
    </div>
    
    <div style="background: #f8fafc; padding: 20px; border-radius: 8px; border-left: 4px solid #667eea; margin: 20px 0;">
        <p style="margin: 0; color: #4a5568; line-height: 1.6;">
            {{ $collaboration->description ?? 'Deskripsi kolaborasi akan ditampilkan di sini.' }}
        </p>
    </div>
    
    @if($action == 'accepted')
        <div class="message">
            <strong>Selamat! Kolaborasi telah dimulai. Langkah selanjutnya:</strong>
        </div>
        
        <div style="margin: 20px 0;">
            <div style="display: flex; align-items: center; margin: 15px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
                <span style="margin-right: 15px; font-size: 20px;">1️⃣</span>
                <div>
                    <strong>Rapat Awal</strong><br>
                    <span style="color: #6b7280;">Jadwalkan meeting untuk membahas detail project</span>
                </div>
            </div>
            <div style="display: flex; align-items: center; margin: 15px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
                <span style="margin-right: 15px; font-size: 20px;">2️⃣</span>
                <div>
                    <strong>Timeline</strong><br>
                    <span style="color: #6b7280;">Buat jadwal dan milestone project</span>
                </div>
            </div>
            <div style="display: flex; align-items: center; margin: 15px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
                <span style="margin-right: 15px; font-size: 20px;">3️⃣</span>
                <div>
                    <strong>Komunikasi</strong><br>
                    <span style="color: #6b7280;">Gunakan fitur chat untuk koordinasi tim</span>
                </div>
            </div>
        </div>
        
        <div class="success">
            🚀 <strong>Bersiaplah untuk menciptakan sesuatu yang luar biasa bersama!</strong>
        </div>
        
    @elseif($action == 'declined')
        <div class="message">
            <strong>Kolaborasi ditolak. Jangan khawatir, masih ada banyak kesempatan lain!</strong>
        </div>
        
        <div style="margin: 20px 0;">
            <div style="display: flex; align-items: center; margin: 10px 0;">
                <span style="margin-right: 10px;">💡</span>
                <span><strong>Feedback:</strong> Pertimbangkan untuk meminta feedback dari {{ $user->name }}</span>
            </div>
            <div style="display: flex; align-items: center; margin: 10px 0;">
                <span style="margin-right: 10px;">🔍</span>
                <span><strong>Jelajahi:</strong> Lihat kolaborasi lain yang mungkin sesuai</span>
            </div>
            <div style="display: flex; align-items: center; margin: 10px 0;">
                <span style="margin-right: 10px;">📈</span>
                <span><strong>Improve:</strong> Tingkatkan proposal untuk kesempatan berikutnya</span>
            </div>
        </div>
        
        <div class="warning">
            💪 <strong>Setiap penolakan adalah pembelajaran untuk kesuksesan berikutnya!</strong>
        </div>
        
    @elseif($action == 'completed')
        <div class="message">
            <strong>Selamat! Kolaborasi telah berhasil diselesaikan!</strong>
        </div>
        
        <div style="margin: 20px 0;">
            <div style="display: flex; align-items: center; margin: 10px 0;">
                <span style="margin-right: 10px;">🎯</span>
                <span><strong>Review:</strong> Berikan feedback dan testimoni</span>
            </div>
            <div style="display: flex; align-items: center; margin: 10px 0;">
                <span style="margin-right: 10px;">📸</span>
                <span><strong>Portfolio:</strong> Tambahkan ke portfolio Anda</span>
            </div>
            <div style="display: flex; align-items: center; margin: 10px 0;">
                <span style="margin-right: 10px;">🤝</span>
                <span><strong>Referensi:</strong> Gunakan sebagai referensi untuk project berikutnya</span>
            </div>
        </div>
        
        <div class="success">
            🏆 <strong>Selamat atas penyelesaian project yang sukses!</strong>
        </div>
        
    @elseif($action == 'cancelled')
        <div class="message">
            <strong>Kolaborasi telah dibatalkan. Berikut beberapa hal yang dapat Anda lakukan:</strong>
        </div>
        
        <div style="margin: 20px 0;">
            <div style="display: flex; align-items: center; margin: 10px 0;">
                <span style="margin-right: 10px;">📋</span>
                <span><strong>Evaluasi:</strong> Pelajari dari pengalaman ini</span>
            </div>
            <div style="display: flex; align-items: center; margin: 10px 0;">
                <span style="margin-right: 10px;">🔄</span>
                <span><strong>Restart:</strong> Coba kolaborasi serupa dengan pendekatan berbeda</span>
            </div>
            <div style="display: flex; align-items: center; margin: 10px 0;">
                <span style="margin-right: 10px;">🌟</span>
                <span><strong>Focus:</strong> Fokus pada project yang sedang berjalan</span>
            </div>
        </div>
        
        <div class="warning">
            🔄 <strong>Setiap pembatalan membuka pintu untuk kesempatan baru!</strong>
        </div>
    @endif
    
    <div class="button-container">
        <a href="{{ config('app.url') }}/collaborations/{{ $collaboration->id }}" class="primary-button">
            📋 Lihat Detail Kolaborasi
        </a>
    </div>
    
    <div class="divider"></div>
    
    <div class="message">
        <strong>Tim Kolaborasi:</strong>
    </div>
    
    <div style="background: #f0fff4; padding: 15px; border-radius: 8px; border: 1px solid #9ae6b4; margin: 20px 0;">
        <p style="margin: 0; color: #22543d;">
            <strong>Pemilik:</strong> {{ $user->name }}<br>
            <strong>Status:</strong> {{ ucfirst($status) }}<br>
            <strong>Update:</strong> {{ now()->format('d M Y, H:i') }}
        </p>
    </div>
    
    <div class="message" style="margin-top: 20px; font-size: 14px; color: #6b7280;">
        Jika Anda memiliki pertanyaan tentang update ini, silakan hubungi tim kolaborasi melalui platform.
    </div>
@endsection
