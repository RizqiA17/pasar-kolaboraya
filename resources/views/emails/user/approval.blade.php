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
            </div>
        </div>

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

        <div style="margin: 30px 0;">
            <a href="{{ route('login') }}" 
               style="display: inline-block; background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px;">
                🚀 Masuk ke Akun Anda
            </a>
        </div>

        <p style="color: #6b7280; font-size: 14px; margin-top: 20px;">
            Setelah masuk, Anda akan diminta untuk melengkapi profil Anda.
        </p>
    </div>

    <div style="background: #f9fafb; padding: 20px; border-radius: 8px; text-align: left;">
        <h4 style="color: #1f2937; margin: 0 0 15px 0;">Langkah Selanjutnya:</h4>
        <ol style="color: #4b5563; padding-left: 20px; margin: 0;">
            <li style="margin-bottom: 8px;">Masuk ke akun Anda menggunakan email dan kata sandi</li>
            <li style="margin-bottom: 8px;">Lengkapi profil Anda dengan informasi yang diperlukan</li>
            <li style="margin-bottom: 8px;">Jelajahi fitur-fitur yang tersedia sesuai tipe akun Anda</li>
            <li style="margin-bottom: 8px;">Mulai terhubung dengan pengguna lain di platform</li>
        </ol>
    </div>
</div>
@endsection
