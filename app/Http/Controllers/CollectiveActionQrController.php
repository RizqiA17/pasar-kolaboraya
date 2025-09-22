<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CollectiveAction;
use Illuminate\Support\Facades\Log;
use App\Models\CollectiveActionUser;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $qrUrl = $collectiveAction->qr_code;
        
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

        if($collectiveAction->qr_code == ''){
            $collectiveAction->qr_code = Str::random(6);
            $collectiveAction->save();
        }
        $qrUrl = $collectiveAction->qr_code;
        
        return view('collective-action.qr-show', compact('collectiveAction', 'qrUrl'));
    }


    /**
     * Process scanned QR code and redirect to join form
     */
    public function processScan(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string'
        ]);

        $qrData = $request->input('qr_data');
        
        // Extract collective action ID from QR code URL
        $collectiveActionId = CollectiveAction::where('qr_code', $qrData)->value('id');
        
        if (!$collectiveActionId) {
            return redirect()->route('collective-action.qr.scanner')
                ->with('error', 'QR code tidak valid. Pastikan QR code adalah untuk bergabung aksi kolektif.');
        }

        // Find collective action
        $collectiveAction = CollectiveAction::find($collectiveActionId);
        
        if (!$collectiveAction) {
            return redirect()->route('collective-action.qr.scanner')
                ->with('error', 'Aksi kolektif tidak ditemukan.');
        }

        // Check if collective action is active
        if ($collectiveAction->status !== 'active') {
            return redirect()->route('collective-action.qr.scanner')
                ->with('error', 'Aksi kolektif tidak aktif.');
        }

        // Check if user is already a member
        if (Auth::check()) {
            $existingMember = $collectiveAction->users()
                ->where('user_id', Auth::id())
                ->first();
            
            if ($existingMember) {
                if ($existingMember->pivot->status === 'active') {
                    return redirect()->route('collective-action.qr.scanner')
                        ->with('error', 'Anda sudah menjadi anggota aksi kolektif ini.');
                }
                
                if ($existingMember->pivot->status === 'pending') {
                    return redirect()->route('collective-action.qr.scanner')
                        ->with('error', 'Permintaan bergabung Anda sedang menunggu persetujuan.');
                }
            }
        }

        // Redirect to join form
        return redirect()->route('collective-action.join', $collectiveAction);
    }

    /**
     * Extract collective action ID from QR code URL
     */
    private function extractCollectiveActionIdFromQr($qrCode)
    {
        // Expected format: /collective-actions/{id}/join
        if (preg_match('/\/collective-actions\/(\d+)\/join/', $qrCode, $matches)) {
            return $matches[1];
        }
        
        // Also handle full URLs
        if (preg_match('/collective-actions\/(\d+)\/join/', $qrCode, $matches)) {
            return $matches[1];
        }
        
        return null;
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
