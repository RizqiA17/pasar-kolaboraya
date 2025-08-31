<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #4F46E5;
        }
        .content {
            padding: 30px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4F46E5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
    </div>
    
    <div class="content">
        <h2>Verifikasi Alamat Email Anda</h2>
        
        <p>Halo {{ $user->name }},</p>
        
        <p>Terima kasih telah mendaftar di {{ config('app.name') }}. Untuk melanjutkan, silakan verifikasi alamat email Anda dengan mengklik tombol di bawah ini:</p>
        
        <div style="text-align: center;">
            <a href="{{ $verificationUrl }}" class="button">Verifikasi Email</a>
        </div>
        
        <p>Atau, Anda dapat menyalin dan menempelkan URL berikut ke browser Anda:</p>
        <p style="word-break: break-all; color: #4F46E5;">{{ $verificationUrl }}</p>
        
        <p>Link verifikasi ini akan kadaluarsa dalam 60 menit.</p>
        
        <p>Jika Anda tidak membuat akun di {{ config('app.name') }}, Anda dapat mengabaikan email ini.</p>
    </div>
    
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.</p>
    </div>
</body>
</html>
