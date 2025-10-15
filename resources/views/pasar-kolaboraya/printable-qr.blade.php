<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR Code Poster - {{ $pasarKolaboraya->name }}</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        
        .poster {
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px;
        }
        
        .poster h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .poster .subtitle {
            font-size: 1.5rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }
        
        .qr-container {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin: 40px 0;
        }
        
        .qr-container svg {
            width: 300px !important;
            height: 300px !important;
        }
        
        .instructions {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
            max-width: 500px;
        }
        
        .instructions h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        
        .instruction-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        
        .instruction-number {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: none;
            }
            
            .no-print {
                display: none !important;
            }
            
            .poster {
                width: 100% !important;
                height: 100vh !important;
                margin: 0 !important;
                padding: 40px !important;
                page-break-inside: avoid;
            }
            
            .poster h1 {
                font-size: 2.5rem !important;
            }
            
            .qr-container {
                margin: 20px 0 !important;
            }
            
            .qr-container svg {
                width: 250px !important;
                height: 250px !important;
            }
        }
    </style>
</head>
<body class="h-full bg-gray-100">
    <!-- Print Controls -->
    <div class="no-print fixed top-4 right-4 z-50">
        <div class="bg-white rounded-lg shadow-lg p-4 space-y-2">
            <button onclick="window.print()" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                🖨️ Print Poster
            </button>
            <a href="{{ route('pasar-kolaboraya.qr.download', $pasarKolaboraya->qr_code) }}" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-block text-center">
                📥 Download PNG
            </a>
            <a href="{{ route('pasar-kolaboraya.qr.registration', $pasarKolaboraya->qr_code) }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors inline-block text-center">
                ← Kembali ke QR
            </a>
        </div>
    </div>

    <!-- Poster Content -->
    <div class="poster">
        <!-- Header -->
        <div>
            <h1>{{ $pasarKolaboraya->name ?? 'Pasar Kolaboraya' }}</h1>
            <p class="subtitle">Daftar Sekarang dengan QR Code</p>
            @if(app()->environment('local'))
                <p style="font-size: 0.8rem; opacity: 0.7;">Debug: QR Code = {{ $pasarKolaboraya->qr_code ?? 'NULL' }}</p>
            @endif
        </div>

        <!-- QR Code -->
        <div class="qr-container">
            @if(isset($qrCode) && $qrCode)
                {!! $qrCode !!}
            @else
                <div style="color: red; text-align: center;">
                    <p>QR Code tidak dapat dimuat</p>
                    <p style="font-size: 0.8rem;">Silakan refresh halaman</p>
                </div>
            @endif
        </div>

        <!-- Instructions -->
        <div class="instructions">
            <h3>Cara Mendaftar:</h3>
            <div class="instruction-item">
                <div class="instruction-number">1</div>
                <span>Buka kamera smartphone</span>
            </div>
            <div class="instruction-item">
                <div class="instruction-number">2</div>
                <span>Arahkan ke QR code di atas</span>
            </div>
            <div class="instruction-item">
                <div class="instruction-number">3</div>
                <span>Klik notifikasi yang muncul</span>
            </div>
            <div class="instruction-item">
                <div class="instruction-number">4</div>
                <span>Isi form registrasi</span>
            </div>
        </div>
    </div>

    <script>
        // Auto print when opened in new tab
        if (window.location.search.includes('autoprint=1')) {
            window.onload = function() {
                setTimeout(() => {
                    window.print();
                }, 1000);
            };
        }
    </script>
</body>
</html>
