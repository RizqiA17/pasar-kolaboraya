<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pasar Kolaboraya') }}</title>

    <link rel="icon" href="{{ Storage::url('web/pasar-kolaboraya-logo-2025.webp') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <div id="safari-warning"
        style="display: none; position: absolute; top: 0; left: 0; padding-inline: 12px; width: 100%; z-index: 99998; background: #fffbe6; color: #856404; border-bottom: 1px solid #ffeeba; text-align: center; padding: 10px; font-size: 15px; font-weight: 500; box-shadow: 0 2px 6px #0001;">
        <div class="w-full h-fit relative px-12">
            Kami mendeteksi Anda tidak menggunakan Chrome atau Firefox. Untuk pengalaman terbaik, silakan gunakan
            browser
            Chrome atau Firefox versi terbaru.
            <button id="close-warning"
                style="margin-left:10px;background:none;border:none;font-weight:bold;cursor:pointer;position: absolute;right: 12px;top: 50%;transform: translateY(-50%);border: solid 2px orange;padding: 2px;border-radius: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px"
                    fill="#856404">
                    <path
                        d="m291-240-51-51 189-189-189-189 51-51 189 189 189-189 51 51-189 189 189 189-51 51-189-189-189 189Z" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        (function() {
            function getBrowserMeta() {
                var ua = navigator.userAgent;
                var M = ua.match(
                    /(Opera|OPR|Edg|Edge|Chrome|CriOS|Firefox|FxiOS|Safari|SamsungBrowser|MSIE|Trident)\/?\s*(\d+\.?\d*)/i
                ) || [];
                var browser = (M[1] || "");
                var version = (M[2] || "0");

                if (/trident/i.test(browser)) {
                    var tem2 = ua.match(/rv:(\d+\.?\d*)/i);
                    return {
                        name: 'IE',
                        version: tem2 ? tem2[1] : version
                    };
                }
                if (browser === 'Chrome') {
                    if (/Edg/i.test(ua)) return {
                        name: 'Edge',
                        version: (ua.match(/Edg\/(\d+\.?\d*)/i) || [])[1] || "0"
                    };
                    if (/OPR/i.test(ua)) return {
                        name: 'Opera',
                        version: (ua.match(/OPR\/(\d+\.?\d*)/i) || [])[1] || "0"
                    };
                    if (/SamsungBrowser/i.test(ua)) return {
                        name: 'Samsung Internet',
                        version: (ua.match(/SamsungBrowser\/(\d+\.?\d*)/i) || [])[1] || "0"
                    };
                }
                if (/Safari/.test(browser) && !/Chrome|Chromium|OPR|Edg|SamsungBrowser|CriOS|FxiOS|OPiOS|EdgiOS/.test(
                        ua)) {
                    var safariVer = (ua.match(/Version\/(\d+\.?\d*)/) || [])[1] || version;
                    return {
                        name: 'Safari',
                        version: safariVer
                    };
                }
                return {
                    name: browser,
                    version
                };
            }

            function isOldVersion() {
                var meta = getBrowserMeta();

                function verN(str) {
                    return Number(str.split('.')[0] || 0) + (Number(str.split('.')[1] || 0) / 100);
                }
                var v = verN(meta.version);
                if (meta.name.indexOf('Chrome') !== -1 && v <= 110) return true;
                if (meta.name === 'Edge' && v <= 110) return true;
                if (meta.name === 'Opera' && v <= 96) return true;
                if (meta.name === 'Firefox' && v <= 127) return true;
                if (meta.name === 'Safari' && v <= 16.3) return true;
                if (meta.name === 'Samsung Internet') return true;
                if (meta.name === 'IE' || meta.name === 'MSIE' || /trident/i.test(navigator.userAgent)) return true;
                return false;
            }

            // tampilkan warning jika belum pernah di-hide
            if (!localStorage.getItem('hideSafariWarning')) {
                var meta = getBrowserMeta();
                var notChromeOrFirefox = !(meta.name.includes('Chrome') || meta.name.includes('Firefox'));
                if (notChromeOrFirefox || isOldVersion()) {
                    document.getElementById('safari-warning').style.display = 'block';
                }
            }

            // tombol close
            document.getElementById('close-warning')?.addEventListener('click', function() {
                document.getElementById('safari-warning').style.display = 'none';
                localStorage.setItem('hideSafariWarning', 'true');
            });
        })();
    </script>

    {{-- Decorative SVG Elements --}}
    {{-- <x-decorative-svgs /> --}}

    {{ $slot }}
</body>

</html>
