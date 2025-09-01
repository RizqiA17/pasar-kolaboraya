@extends('emails.layouts.base')

@section('title', 'Undangan Kolaborasi: ' . $collaboration->title)

@section('content')
    <div class="greeting">Halo {{ $notifiable->name }}! 🤝</div>
    
    <div class="message">
        <strong>{{ $inviter->name }}</strong> mengundang Anda untuk bergabung dalam kolaborasi menarik di <strong>Pasar Kolaboraya</strong>!
    </div>
    
    <div class="highlight-box">
        <p style="margin: 0; font-weight: 600; color: #2d3748;">
            🚀 Undangan Kolaborasi: <strong>{{ $collaboration->title }}</strong>
        </p>
    </div>
    
    <div class="message">
        <strong>Detail Kolaborasi:</strong>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Judul</div>
            <div class="info-value">{{ $collaboration->title }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Kategori</div>
            <div class="info-value">{{ $collaboration->category ?? 'Umum' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Status</div>
            <div class="info-value">Draft/Planning</div>
        </div>
        <div class="info-item">
            <div class="info-label">Pemilik</div>
            <div class="info-value">{{ $inviter->name }}</div>
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
    
    <div class="message">
        <strong>Mengapa kolaborasi ini menarik untuk Anda:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">💼</span>
            <span><strong>Skill Match:</strong> Project ini sesuai dengan keahlian Anda</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🤝</span>
            <span><strong>Networking:</strong> Bekerja sama dengan profesional lain</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">📈</span>
            <span><strong>Growth:</strong> Tingkatkan portfolio dan pengalaman</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🌟</span>
            <span><strong>Opportunity:</strong> Potensi project dan penghasilan</span>
        </div>
    </div>
    
    <div class="message">
        <strong>Langkah selanjutnya:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 15px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
            <span style="margin-right: 15px; font-size: 20px;">1️⃣</span>
            <div>
                <strong>Lihat Detail</strong><br>
                <span style="color: #6b7280;">Pelajari lebih lanjut tentang kolaborasi ini</span>
            </div>
        </div>
        <div style="display: flex; align-items: center; margin: 15px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
            <span style="margin-right: 15px; font-size: 20px;">2️⃣</span>
            <div>
                <strong>Diskusi</strong><br>
                <span style="color: #6b7280;">Ajukan pertanyaan kepada pemilik project</span>
            </div>
        </div>
        <div style="display: flex; align-items: center; margin: 15px 0; padding: 15px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #667eea;">
            <span style="margin-right: 15px; font-size: 20px;">3️⃣</span>
            <div>
                <strong>Bergabung</strong><br>
                <span style="color: #6b7280;">Terima undangan dan mulai berkolaborasi</span>
            </div>
        </div>
    </div>
    
    <div class="button-container">
        <a href="{{ config('app.url') }}/collaborations/{{ $collaboration->id }}" class="primary-button">
            🔍 Lihat Detail Kolaborasi
        </a>
    </div>
    
    <div class="divider"></div>
    
    <div class="message">
        <strong>Tentang {{ $inviter->name }}:</strong>
    </div>
    
    <div style="background: #f0fff4; padding: 15px; border-radius: 8px; border: 1px solid #9ae6b4; margin: 20px 0;">
        <p style="margin: 0; color: #22543d;">
            <strong>Profesi:</strong> {{ $inviter->profile->profession ?? 'Profesional' }}<br>
            <strong>Perusahaan:</strong> {{ $inviter->profile->company ?? 'Tidak disebutkan' }}<br>
            <strong>Lokasi:</strong> {{ $inviter->profile->location ?? 'Tidak disebutkan' }}
        </p>
    </div>
    
    <div class="success">
        🤝 <strong>Jangan lewatkan kesempatan berkolaborasi yang menarik ini!</strong>
    </div>
    
    <div class="message" style="margin-top: 20px; font-size: 14px; color: #6b7280;">
        Jika Anda tidak tertarik dengan kolaborasi ini, Anda dapat menolak undangan dengan sopan melalui platform.
    </div>
@endsection
