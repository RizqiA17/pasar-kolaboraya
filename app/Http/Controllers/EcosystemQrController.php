<?php

namespace App\Http\Controllers;

use App\Models\Ecosystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

class EcosystemQrController extends Controller
{
    /**
     * Generate QR code for ecosystem joining
     */
    public function generateQr(Ecosystem $ecosystem)
    {
        // Check if user is the creator of the ecosystem
        if (Auth::id() !== $ecosystem->creator_id) {
            abort(403, 'Hanya pemilik ekosistem yang dapat membuat QR code');
        }

        // Generate static QR code URL - redirect to join form
        $qrUrl = $ecosystem->qr_code;
        
        // Generate QR code as SVG
        $qrSvg = QrCode::size(300)
            ->format('svg')
            ->generate($qrUrl);

        return response()->json([
            'success' => true,
            'qr_url' => $qrUrl,
            'qr_svg' => $qrSvg,
            'ecosystem_name' => $ecosystem->ecosystem_title,
        ]);
    }

    /**
     * Show QR code for ecosystem joining
     */
    public function showQr(Ecosystem $ecosystem)
    {
        // Check if user is the creator of the ecosystem
        if (Auth::id() !== $ecosystem->creator_id) {
            abort(403, 'Hanya pemilik ekosistem yang dapat melihat QR code');
        }

        if($ecosystem->qr_code == ''){
            $ecosystem->qr_code = \Str::random(6);
            $ecosystem->save();
        }

        $qrUrl = $ecosystem->qr_code;

        return view('ecosystem.qr-show', compact('ecosystem', 'qrUrl'));
    }


    /**
     * Get QR code data for API
     */
    public function getQrData(Ecosystem $ecosystem)
    {
        // Check if user is the creator of the ecosystem
        if (Auth::id() !== $ecosystem->creator_id) {
            abort(403, 'Hanya pemilik ekosistem yang dapat mengakses data QR code');
        }

        $qrUrl = route('ecosystem.join', $ecosystem);
        
        return response()->json([
            'success' => true,
            'ecosystem_id' => $ecosystem->id,
            'ecosystem_name' => $ecosystem->ecosystem_title,
            'qr_url' => $qrUrl,
            'join_url' => route('ecosystem.join', $ecosystem),
        ]);
    }
}
