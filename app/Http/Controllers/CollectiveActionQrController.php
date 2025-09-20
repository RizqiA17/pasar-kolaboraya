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

        // Generate static QR code URL
        $qrUrl = route('collective-action.qr.join', $collectiveAction->id);
        
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

        $qrUrl = route('collective-action.qr.join', $collectiveAction->id);
        
        return view('collective-action.qr-show', compact('collectiveAction', 'qrUrl'));
    }

    /**
     * Handle QR code scan - redirect to join form
     */
    public function handleQrJoin(CollectiveAction $collectiveAction)
    {
        // Check if collective action is active
        if ($collectiveAction->status !== 'active') {
            return redirect()->route('collective-action.browse')
                ->with('error', 'Aksi kolektif tidak aktif');
        }

        // Check if user is already a member
        if (Auth::check()) {
            $existingMember = CollectiveActionUser::where('collective_action_id', $collectiveAction->id)
                ->where('user_id', Auth::id())
                ->first();
            
            if ($existingMember) {
                if ($existingMember->status === 'active') {
                    return redirect()->route('collective-action.show', $collectiveAction)
                        ->with('info', 'Anda sudah menjadi anggota aksi kolektif ini');
                }
                
                if ($existingMember->status === 'pending') {
                    return redirect()->route('collective-action.show', $collectiveAction)
                        ->with('info', 'Permintaan bergabung Anda sedang menunggu persetujuan');
                }
            }
        }

        // Redirect to join form
        return redirect()->route('collective-action.join', $collectiveAction);
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

        $qrUrl = route('collective-action.qr.join', $collectiveAction->id);
        
        return response()->json([
            'success' => true,
            'collective_action_id' => $collectiveAction->id,
            'collective_action_title' => $collectiveAction->title,
            'qr_url' => $qrUrl,
            'join_url' => route('collective-action.join', $collectiveAction),
        ]);
    }

    /**
     * Show QR scanner page
     */
    public function showScanner()
    {
        return view('collective-action.qr-scanner');
    }

    /**
     * Process scanned QR code
     */
    public function processScan(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        $qrData = $request->input('qr_data');
        
        // Extract collective action ID from URL
        if (preg_match('/collective-action\/qr\/join\/(\d+)/', $qrData, $matches)) {
            $collectiveActionId = $matches[1];
            
            try {
                $collectiveAction = CollectiveAction::findOrFail($collectiveActionId);
                return redirect()->route('collective-action.qr.join', $collectiveAction);
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', 'Aksi kolektif tidak ditemukan');
            }
        }

        return redirect()->back()
            ->with('error', 'QR code tidak valid');
    }
}
