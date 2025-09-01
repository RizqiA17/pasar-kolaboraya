@extends('emails.layouts.base')

@section('title', 'Event Baru: ' . $event->title)

@section('content')
    <div class="greeting">Halo {{ $user->name }}! 🎉</div>
    
    <div class="message">
        Ada event menarik yang baru saja dibuat di <strong>Pasar Kolaboraya</strong> yang mungkin sesuai dengan minat Anda!
    </div>
    
    <div class="highlight-box">
        <p style="margin: 0; font-weight: 600; color: #2d3748;">
            📅 Event baru: <strong>{{ $event->title }}</strong>
        </p>
    </div>
    
    <div class="message">
        <strong>Detail Event:</strong>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">Tanggal</div>
            <div class="info-value">{{ $event->date->format('d M Y, H:i') }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Lokasi</div>
            <div class="info-value">{{ $event->location }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Kategori</div>
            <div class="info-value">{{ $event->category->name ?? 'Umum' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">Peserta</div>
            <div class="info-value">Max {{ $event->max_participants ?? 'Unlimited' }}</div>
        </div>
    </div>
    
    <div class="message">
        <strong>Deskripsi Event:</strong>
    </div>
    
    <div style="background: #f8fafc; padding: 20px; border-radius: 8px; border-left: 4px solid #667eea; margin: 20px 0;">
        <p style="margin: 0; color: #4a5568; line-height: 1.6;">
            {{ $event->description }}
        </p>
    </div>
    
    @if($event->registration_deadline)
    <div class="warning">
        ⏰ <strong>Deadline Pendaftaran:</strong> {{ $event->registration_deadline->format('d M Y, H:i') }}
    </div>
    @endif
    
    <div class="message">
        <strong>Mengapa Anda harus ikut event ini?</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🤝</span>
            <span><strong>Networking:</strong> Temui profesional lain dengan minat yang sama</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">💡</span>
            <span><strong>Learning:</strong> Dapatkan insight dan pengetahuan baru</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🚀</span>
            <span><strong>Opportunity:</strong> Temukan peluang kolaborasi dan project</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🌟</span>
            <span><strong>Growth:</strong> Tingkatkan skill dan pengalaman Anda</span>
        </div>
    </div>
    
    <div class="button-container">
        <a href="{{ config('app.url') }}/events/{{ $event->id }}" class="primary-button">
            📋 Lihat Detail Event
        </a>
    </div>
    
    <div class="divider"></div>
    
    <div class="message">
        <strong>Event Organizer:</strong> {{ $event->organizer->name ?? 'Tim Pasar Kolaboraya' }}
    </div>
    
    <div class="success">
        🎯 <strong>Jangan lewatkan kesempatan emas ini untuk berkembang!</strong>
    </div>
    
    <div class="message" style="margin-top: 20px; font-size: 14px; color: #6b7280;">
        Jika event ini tidak sesuai dengan minat Anda, Anda dapat mengatur preferensi notifikasi di pengaturan profil.
    </div>
@endsection
