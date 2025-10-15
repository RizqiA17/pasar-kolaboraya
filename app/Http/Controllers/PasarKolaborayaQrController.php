<?php

namespace App\Http\Controllers;

use App\Models\PasarKolaboraya;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PasarKolaborayaQrController extends Controller
{
    /**
     * Show QR code for Pasar Kolaboraya registration
     */
    public function showRegistrationQr($code = null)
    {
        // Find Pasar Kolaboraya by QR code or use default
        $pasarKolaboraya = null;
        if ($code) {
            $pasarKolaboraya = PasarKolaboraya::where('qr_code', $code)
                ->where('status', 'active')
                ->first();
        }
        
        // If no specific pasar found, use the first active one
        if (!$pasarKolaboraya) {
            $pasarKolaboraya = PasarKolaboraya::where('status', 'active')->first();
        }

        if (!$pasarKolaboraya) {
            abort(404, 'Pasar Kolaboraya tidak ditemukan');
        }

        // Generate QR code if not exists
        if (!$pasarKolaboraya->qr_code) {
            $pasarKolaboraya->qr_code = 'PK_' . $pasarKolaboraya->id . '_' . \Str::random(8);
            $pasarKolaboraya->save();
        }

        // Generate registration URL using QR code
        $registrationUrl = route('register.pasar-kolaboraya', ['code' => $pasarKolaboraya->qr_code]);
        
        // Generate QR code
        $qrCode = QrCode::size(300)
            ->format('svg')
            ->generate($registrationUrl);

        return view('pasar-kolaboraya.qr-registration', [
            'pasarKolaboraya' => $pasarKolaboraya,
            'registrationUrl' => $registrationUrl,
            'qrCode' => $qrCode,
        ]);
    }

    /**
     * Generate QR code data as JSON
     */
    public function getQrData($code = null)
    {
        // Find Pasar Kolaboraya by QR code or use default
        $pasarKolaboraya = null;
        if ($code) {
            $pasarKolaboraya = PasarKolaboraya::where('qr_code', $code)
                ->where('status', 'active')
                ->first();
        }
        
        // If no specific pasar found, use the first active one
        if (!$pasarKolaboraya) {
            $pasarKolaboraya = PasarKolaboraya::where('status', 'active')->first();
        }

        if (!$pasarKolaboraya) {
            return response()->json(['error' => 'Pasar Kolaboraya tidak ditemukan'], 404);
        }

        // Generate QR code if not exists
        if (!$pasarKolaboraya->qr_code) {
            $pasarKolaboraya->qr_code = 'PK_' . $pasarKolaboraya->id . '_' . \Str::random(8);
            $pasarKolaboraya->save();
        }

        // Generate registration URL using QR code
        $registrationUrl = route('register.pasar-kolaboraya', ['code' => $pasarKolaboraya->qr_code]);

        return response()->json([
            'pasar_kolaboraya' => [
                'id' => $pasarKolaboraya->id,
                'name' => $pasarKolaboraya->name,
                'description' => $pasarKolaboraya->description,
                'status' => $pasarKolaboraya->status,
            ],
            'registration_url' => $registrationUrl,
            'qr_code_data' => $registrationUrl,
        ]);
    }

    /**
     * Download QR code as PNG for printing
     */
    public function downloadQr($code = null)
    {
        // Find Pasar Kolaboraya by QR code or use default
        $pasarKolaboraya = null;
        if ($code) {
            $pasarKolaboraya = PasarKolaboraya::where('qr_code', $code)
                ->where('status', 'active')
                ->first();
        }
        
        // If no specific pasar found, use the first active one
        if (!$pasarKolaboraya) {
            $pasarKolaboraya = PasarKolaboraya::where('status', 'active')->first();
        }

        if (!$pasarKolaboraya) {
            abort(404, 'Pasar Kolaboraya tidak ditemukan');
        }

        // Generate QR code if not exists
        if (!$pasarKolaboraya->qr_code) {
            $pasarKolaboraya->qr_code = 'PK_' . $pasarKolaboraya->id . '_' . \Str::random(8);
            $pasarKolaboraya->save();
        }

        // Generate registration URL using QR code
        $registrationUrl = route('register.pasar-kolaboraya', ['code' => $pasarKolaboraya->qr_code]);
        
        // Generate QR code as PNG (higher resolution for printing)
        $qrCode = QrCode::size(800)
            ->format('png')
            ->margin(2)
            ->generate($registrationUrl);

        // Generate filename
        $filename = 'QR-Registrasi-' . str_replace(' ', '-', $pasarKolaboraya->name) . '-' . date('Y-m-d') . '.png';
        
        return response($qrCode)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    /**
     * Show printable QR code poster
     */
    public function showPrintableQr($code = null)
    {
        // Find Pasar Kolaboraya by QR code or use default
        $pasarKolaboraya = null;
        if ($code) {
            $pasarKolaboraya = PasarKolaboraya::where('qr_code', $code)
                ->where('status', 'active')
                ->first();
        }
        
        // If no specific pasar found, use the first active one
        if (!$pasarKolaboraya) {
            $pasarKolaboraya = PasarKolaboraya::where('status', 'active')->first();
        }

        if (!$pasarKolaboraya) {
            abort(404, 'Pasar Kolaboraya tidak ditemukan');
        }

        // Generate QR code if not exists
        if (!$pasarKolaboraya->qr_code) {
            $pasarKolaboraya->qr_code = 'PK_' . $pasarKolaboraya->id . '_' . \Str::random(8);
            $pasarKolaboraya->save();
        }

        // Generate registration URL using QR code
        $registrationUrl = route('register.pasar-kolaboraya', ['code' => $pasarKolaboraya->qr_code]);
        
        try {
            // Generate QR code (high resolution for printing)
            $qrCode = QrCode::size(600)
                ->format('svg')
                ->margin(2)
                ->generate($registrationUrl);
        } catch (\Exception $e) {
            \Log::error('QR Code generation failed for printable view', [
                'pasar_kolaboraya_id' => $pasarKolaboraya->id,
                'qr_code' => $pasarKolaboraya->qr_code,
                'error' => $e->getMessage()
            ]);
            abort(500, 'Gagal generate QR code');
        }

        return view('pasar-kolaboraya.printable-qr', [
            'pasarKolaboraya' => $pasarKolaboraya,
            'registrationUrl' => $registrationUrl,
            'qrCode' => $qrCode,
        ]);
    }
}