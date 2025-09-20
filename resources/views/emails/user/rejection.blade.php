@extends('emails.layouts.base')

@section('content')
<div style="text-align: center; padding: 40px 20px;">
    <div style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 30px; border-radius: 12px; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 28px; font-weight: bold;">❌ Pendaftaran Ditolak</h1>
        <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">{{ config('app.name') }}</p>
    </div>

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 30px;">
        <h2 style="color: #1f2937; margin-bottom: 20px;">Halo {{ $user->name }},</h2>
        
        <p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
            Kami menyesal memberitahu Anda bahwa pendaftaran Anda untuk bergabung dengan {{ config('app.name') }} 
            <strong>tidak dapat disetujui</strong> pada saat ini.
        </p>

        <div style="background: #fef2f2; border: 1px solid #fecaca; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h3 style="color: #991b1b; margin: 0 0 15px 0; font-size: 18px;">Detail Pendaftaran:</h3>
            <div style="text-align: left;">
                <p style="margin: 8px 0; color: #7f1d1d;"><strong>Nama:</strong> {{ $user->name }}</p>
                <p style="margin: 8px 0; color: #7f1d1d;"><strong>Email:</strong> {{ $user->email }}</p>
                <p style="margin: 8px 0; color: #7f1d1d;"><strong>Tipe User:</strong> {{ $user->user_type_label }}</p>
                <p style="margin: 8px 0; color: #7f1d1d;"><strong>Tanggal Pendaftaran:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        @if($reason)
            <div style="background: #fef3c7; border: 1px solid #f59e0b; padding: 20px; border-radius: 8px; margin: 20px 0;">
                <h4 style="color: #92400e; margin: 0 0 10px 0;">Alasan Penolakan:</h4>
                <p style="color: #b45309; margin: 0; font-size: 14px;">
                    {{ $reason }}
                </p>
            </div>
        @endif

        <div style="background: #f0f9ff; border: 1px solid #0ea5e9; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <h4 style="color: #0c4a6e; margin: 0 0 15px 0;">💡 Apa yang Bisa Anda Lakukan?</h4>
            <ul style="color: #0369a1; padding-left: 20px; margin: 0; text-align: left;">
                <li style="margin-bottom: 8px;">Hubungi administrator untuk informasi lebih lanjut</li>
                <li style="margin-bottom: 8px;">Pastikan informasi yang Anda berikan akurat dan lengkap</li>
                <li style="margin-bottom: 8px;">Coba daftar kembali di kemudian hari jika memungkinkan</li>
                <li style="margin-bottom: 8px;">Gunakan kode registrasi yang valid jika diperlukan</li>
            </ul>
        </div>

        <div style="background: linear-gradient(135deg, #6b7280, #4b5563); padding: 30px; border-radius: 12px; margin: 30px 0; text-align: center;">
            <h3 style="color: white; margin: 0 0 15px 0; font-size: 20px;">🔄 Ingin Mencoba Lagi?</h3>
            <p style="color: rgba(255, 255, 255, 0.9); margin: 0 0 20px 0; font-size: 16px;">
                Jika Anda merasa ada kesalahan atau ingin mendaftar kembali, klik tombol di bawah ini
            </p>
            <a href="{{ route('register') }}" 
               style="display: inline-block; background: white; color: #4b5563; padding: 15px 40px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                🔄 Daftar Kembali
            </a>
        </div>

        <p style="color: #6b7280; font-size: 14px; margin-top: 20px;">
            Jika Anda memiliki pertanyaan atau memerlukan bantuan, silakan hubungi tim support kami.
        </p>
    </div>

    <div style="background: #f9fafb; padding: 20px; border-radius: 8px; text-align: left;">
        <h4 style="color: #1f2937; margin: 0 0 15px 0;">Kontak Support:</h4>
        <p style="color: #4b5563; margin: 0; font-size: 14px;">
            Email: support@{{ str_replace(['http://', 'https://'], '', config('app.url')) }}<br>
            Telepon: (021) 1234-5678<br>
            Jam Kerja: Senin - Jumat, 09:00 - 17:00 WIB
        </p>
    </div>
</div>
@endsection
