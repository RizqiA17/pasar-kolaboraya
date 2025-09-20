<?php

namespace App\Http\Controllers;

use App\Models\CollectiveAction;
use App\Models\CollectiveActionUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;

class CollectiveActionQrController extends Controller
{
    /**
     * Generate QR code for collective action joining
     */
    public function generateQr(CollectiveAction $collectiveAction)
    {
        // Check if user is the creator of the collective action
        if (Auth::id() !== $collectiveAction->created_by) {
            abort(403, 'Hanya pembuat aksi kolektif yang dapat membuat QR code');
        }

        // Generate static QR code URL - redirect directly to join form
        $qrUrl = route('collective-action.join', $collectiveAction);
        
        // Generate QR code as SVG
        $qrSvg = QrCode::size(300)
            ->format('svg')
            ->generate($qrUrl);

        return response()->json([
            'success' => true,
            'qr_url' => $qrUrl,
            'qr_svg' => $qrSvg,
            'collective_action_title' => $collectiveAction->title,
        ]);
    }

    /**
     * Show QR code for collective action joining
     */
    public function showQr(CollectiveAction $collectiveAction)
    {
        // Check if user is the creator of the collective action
        if (Auth::id() !== $collectiveAction->created_by) {
            abort(403, 'Hanya pembuat aksi kolektif yang dapat melihat QR code');
        }

        $qrUrl = route('collective-action.join', $collectiveAction);
        
        return view('collective-action.qr-show', compact('collectiveAction', 'qrUrl'));
    }


    /**
     * Get QR code data for API
     */
    public function getQrData(CollectiveAction $collectiveAction)
    {
        // Check if user is the creator of the collective action
        if (Auth::id() !== $collectiveAction->created_by) {
            abort(403, 'Hanya pembuat aksi kolektif yang dapat mengakses data QR code');
        }

        $qrUrl = route('collective-action.join', $collectiveAction);
        
        return response()->json([
            'success' => true,
            'collective_action_id' => $collectiveAction->id,
            'collective_action_title' => $collectiveAction->title,
            'qr_url' => $qrUrl,
            'join_url' => route('collective-action.join', $collectiveAction),
        ]);
    }

}
