@extends('emails.layouts.base')

@section('title', 'Event Baru: {{ $event->title }} - Pasar Kolaboraya')

@section('content')
    <div class="greeting">Halo {{ $user->name }}! 📅</div>
    
    <div class="message">
        Ada event menarik yang baru saja dibuat di <strong>Pasar Kolaboraya</strong> yang mungkin sesuai dengan minat Anda!
    </div>
    
    <div class="highlight-box">
        <p style="margin: 0; font-weight: 600; color: #2d3748;">
            🎉 Event Baru: {{ $event->title }}
        </p>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">📅 Tanggal</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">📍 Lokasi</div>
            <div class="info-value">{{ $event->location ?? 'Online' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">👥 Organizer</div>
            <div class="info-value">{{ $event->organizer->name ?? 'Tim Pasar Kolaboraya' }}</div>
        </div>
        <div class="info-item">
            <div class="info-label">🎯 Kategori</div>
            <div class="info-value">{{ $event->category->name ?? 'Umum' }}</div>
        </div>
    </div>
    
    @if($event->description)
    <div class="message">
        <strong>Deskripsi Event:</strong>
    </div>
    <div class="highlight-box">
        <p style="margin: 0; color: #4a5568;">
            {{ $event->description }}
        </p>
    </div>
    @endif
    
    <div class="message">
        <strong>Mengapa event ini menarik untuk Anda:</strong>
    </div>
    
    <div style="margin: 20px 0;">
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🎯</span>
            <span>Kategori sesuai dengan minat dan skill Anda</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🤝</span>
            <span>Kesempatan networking dengan profesional lain</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">💡</span>
            <span>Belajar hal baru dan update trend terbaru</span>
        </div>
        <div style="display: flex; align-items: center; margin: 10px 0;">
            <span style="margin-right: 10px;">🚀</span>
            <span>Potensi kolaborasi dan project baru</span>
        </div>
    </div>
    
    <div class="button-container">
        <a href="{{ url('/events/' . $event->id) }}" class="primary-button">
            📋 Lihat Detail Event
        </a>
    </div>
    
    <div class="divider"></div>
    
    <div class="message">
        <strong>Aksi yang dapat Anda lakukan:</strong>
    </div>
    
    <div style="display: flex; gap: 15px; margin: 20px 0; flex-wrap: wrap;">
        <a href="{{ url('/events/' . $event->id . '/register') }}" class="secondary-button" style="background: #f0fff4; color: #22543d; border-color: #9ae6b4;">
            ✅ Daftar Event
        </a>
        <a href="{{ url('/events/' . $event->id . '/share') }}" class="secondary-button">
            📤 Bagikan ke Teman
        </a>
        <a href="{{ url('/events/' . $event->id . '/calendar') }}" class="secondary-button">
            📅 Tambah ke Kalender
        </a>
    </div>
    
    @if($event->max_participants)
    <div class="warning">
        ⚠️ <strong>Kuota Terbatas:</strong> Event ini hanya untuk <strong>{{ $event->max_participants }} peserta</strong>. Daftar segera sebelum penuh!
    </div>
    @endif
    
    @if($event->registration_deadline)
    <div class="warning">
        ⏰ <strong>Deadline Pendaftaran:</strong> {{ \Carbon\Carbon::parse($event->registration_deadline)->format('d M Y, H:i') }}
    </div>
    @endif
    
    <div class="message">
        <strong>Event serupa yang mungkin menarik:</strong>
    </div>
    
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">📚 Workshop</div>
            <div class="info-value">Skill Development</div>
        </div>
        <div class="info-item">
            <div class="info-label">🤝 Networking</div>
            <div class="info-value">Professional Meetup</div>
        </div>
        <div class="info-item">
            <div class="info-label">💼 Conference</div>
            <div class="info-value">Industry Insights</div>
        </div>
        <div class="info-item">
            <div class="info-label">🎨 Creative</div>
            <div class="info-value">Art & Design</div>
        </div>
    </div>
    
    <div class="button-container">
        <a href="{{ url('/events') }}" class="secondary-button">
            🔍 Lihat Semua Event
        </a>
    </div>
    
    <div class="success">
        🎯 <strong>Jangan lewatkan kesempatan emas untuk belajar, networking, dan berkembang bersama komunitas Pasar Kolaboraya!</strong>
    </div>
    
    <div class="message" style="text-align: center; margin-top: 30px; font-size: 14px; color: #718096;">
        Ingin membuat event sendiri? <a href="{{ url('/events/create') }}" style="color: #667eea;">Klik di sini</a> untuk memulai!
    </div>
@endsection
