@extends('emails.layouts.base')

@section('content')
<div style="text-align: center; padding: 40px 20px;">
    <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 30px; border-radius: 12px; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 28px; font-weight: bold;">🎉 Selamat! Akun Anda Telah Disetujui</h1>
        <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">{{ config('app.name') }}</p>
    </div>

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 30px;">
        <h2 style="color: #1f2937; margin-bottom: 20px;">Halo {{ $user->name }}!</h2>
        
        <p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
            Kami senang memberitahu Anda bahwa pendaftaran Anda telah <strong>disetujui</strong> untuk bergabung dengan {{ config('app.name') }}!
        </p>

        <div style="background: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="color: #1f2937; margin: 0 0 15px 0; font-size: 18px;">Detail Akun Anda:</h3>
            <div style="text-align: left;">
                <p style="margin: 8px 0; color: #4b5563;"><strong>Tipe User:</strong> {{ $user->user_type_label }}</p>
                @if($assignedRole)
                    <p style="margin: 8px 0; color: #4b5563;"><strong>Peran yang Ditetapkan:</strong> {{ ucfirst($assignedRole) }}</p>
                @endif
                <p style="margin: 8px 0; color: #4b5563;"><strong>Email:</strong> {{ $user->email }}</p>
                <p style="margin: 8px 0; color: #4b5563;"><strong>Tanggal Disetujui:</strong> {{ $user->approved_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        @if($assignedRole)
            <div style="background: #f0f9ff; border: 1px solid #0ea5e9; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #0c4a6e; margin: 0 0 15px 0;">🎯 Penjelasan Peran Anda</h4>
                <div style="color: #0369a1; text-align: left;">
                    @if($assignedRole === 'Pemimpin Komunitas')
                        <p style="margin: 0 0 10px 0;"><strong>Pemimpin Komunitas:</strong> Anda akan memimpin dan mengkoordinasikan kegiatan komunitas, membuat keputusan strategis, dan memastikan visi komunitas tercapai. Sebagai pemimpin, Anda memiliki akses penuh untuk mengelola anggota dan program komunitas.</p>
                    @elseif($assignedRole === 'Anggota Aktif')
                        <p style="margin: 0 0 10px 0;"><strong>Anggota Aktif:</strong> Anda akan berpartisipasi aktif dalam kegiatan komunitas, memberikan kontribusi nyata, dan mendukung program-program yang ada. Sebagai anggota aktif, Anda dapat mengakses semua fitur komunitas dan berpartisipasi dalam aksi kolektif.</p>
                    @elseif($assignedRole === 'Relawan')
                        <p style="margin: 0 0 10px 0;"><strong>Relawan:</strong> Anda akan memberikan waktu dan tenaga secara sukarela untuk mendukung berbagai kegiatan dan program komunitas. Sebagai relawan, Anda dapat memilih kegiatan yang sesuai dengan minat dan kemampuan Anda.</p>
                    @elseif($assignedRole === 'Mentor')
                        <p style="margin: 0 0 10px 0;"><strong>Mentor:</strong> Anda akan membimbing dan memberikan pengalaman serta pengetahuan kepada anggota komunitas yang lebih junior. Sebagai mentor, Anda memiliki tanggung jawab untuk membantu pengembangan anggota lain.</p>
                    @elseif($assignedRole === 'Koordinator Event')
                        <p style="margin: 0 0 10px 0;"><strong>Koordinator Event:</strong> Anda akan mengorganisir dan mengelola berbagai acara dan kegiatan komunitas dari perencanaan hingga eksekusi. Sebagai koordinator event, Anda memiliki akses khusus untuk mengelola acara komunitas.</p>
                    @elseif($assignedRole === 'Kontributor Konten')
                        <p style="margin: 0 0 10px 0;"><strong>Kontributor Konten:</strong> Anda akan membuat dan berbagi konten berkualitas untuk mendukung visi dan misi komunitas. Sebagai kontributor konten, Anda dapat berbagi pengetahuan dan pengalaman melalui berbagai media.</p>
                    @elseif($assignedRole === 'Pengamat')
                        <p style="margin: 0 0 10px 0;"><strong>Pengamat:</strong> Anda akan mengikuti perkembangan komunitas dan memberikan masukan konstruktif untuk perbaikan. Sebagai pengamat, Anda dapat memberikan feedback berharga untuk kemajuan komunitas.</p>
                    @else
                        <p style="margin: 0 0 10px 0;"><strong>{{ $assignedRole }}:</strong> Anda telah ditetapkan sebagai {{ $assignedRole }} dalam komunitas. Silakan hubungi administrator jika Anda memerlukan penjelasan lebih lanjut tentang peran ini.</p>
                    @endif
                </div>
            </div>
        @endif

        @if($user->user_type === 'partisipan')
            <div style="background: #ecfdf5; border: 1px solid #10b981; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #065f46; margin: 0 0 10px 0;">✨ Akses Penuh Tersedia</h4>
                <p style="color: #047857; margin: 0; font-size: 14px;">
                    Sebagai partisipan, Anda dapat mengakses semua fitur termasuk ekosistem dan aksi kolektif.
                </p>
            </div>
        @else
            <div style="background: #fef3c7; border: 1px solid #f59e0b; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #92400e; margin: 0 0 10px 0;">🔗 Akses Terbatas</h4>
                <p style="color: #b45309; margin: 0; font-size: 14px;">
                    Sebagai {{ strtolower($user->user_type_label) }}, Anda dapat terhubung dengan pengguna lain, 
                    namun tidak dapat mengakses ekosistem dan aksi kolektif.
                </p>
            </div>
        @endif

        <div style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); padding: 30px; border-radius: 12px; margin: 30px 0; text-align: center;">
            <h3 style="color: white; margin: 0 0 15px 0; font-size: 20px;">🎉 Selamat! Akun Anda Siap Digunakan</h3>
            <p style="color: rgba(255, 255, 255, 0.9); margin: 0 0 20px 0; font-size: 16px;">
                Klik tombol di bawah ini untuk masuk ke akun Anda dan mulai menjelajahi platform
            </p>
            <a href="{{ route('login') }}" 
               style="display: inline-block; background: white; color: #1d4ed8; padding: 15px 40px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                🚀 Masuk ke Akun Saya
            </a>
        </div>

        <div style="background: #f9fafb; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h4 style="color: #1f2937; margin: 0 0 15px 0;">📋 Langkah Selanjutnya Setelah Login:</h4>
            <ol style="color: #4b5563; padding-left: 20px; margin: 0; text-align: left;">
                <li style="margin-bottom: 8px;"><strong>Lengkapi Profil:</strong> Isi informasi profil Anda untuk memaksimalkan pengalaman di platform</li>
                <li style="margin-bottom: 8px;"><strong>Pilih Peran:</strong> Tentukan peran spesifik Anda dalam komunitas (jika belum ditetapkan)</li>
                <li style="margin-bottom: 8px;"><strong>Jelajahi Fitur:</strong> Temukan fitur-fitur yang tersedia sesuai dengan tipe akun Anda</li>
                <li style="margin-bottom: 8px;"><strong>Terhubung:</strong> Mulai terhubung dengan pengguna lain dan bergabung dalam komunitas</li>
                @if($user->user_type === 'partisipan')
                <li style="margin-bottom: 8px;"><strong>Ekosistem & Aksi Kolektif:</strong> Akses penuh ke ekosistem dan berpartisipasi dalam aksi kolektif</li>
                @endif
            </ol>
        </div>
    </div>

    <div style="background: #f9fafb; padding: 20px; border-radius: 8px; text-align: left;">
        <h4 style="color: #1f2937; margin: 0 0 15px 0;">💡 Tips untuk Memulai:</h4>
        <ul style="color: #4b5563; padding-left: 20px; margin: 0;">
            <li style="margin-bottom: 8px;">Pastikan Anda menggunakan email dan kata sandi yang sama saat registrasi</li>
            <li style="margin-bottom: 8px;">Jika lupa kata sandi, gunakan fitur "Lupa Password" di halaman login</li>
            <li style="margin-bottom: 8px;">Jelajahi dashboard untuk memahami fitur-fitur yang tersedia</li>
            <li style="margin-bottom: 8px;">Jangan ragu untuk menghubungi support jika memerlukan bantuan</li>
        </ul>
    </div>
</div>
@endsection
