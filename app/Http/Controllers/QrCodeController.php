<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    /**
     * Generate QR code for authenticated user
     */
    public function generate()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        
        // Generate new QR code
        $newQrCode = $user->generateQrCode();
        $qrCodeData = $user->getQrCodeData();
        
        // Generate QR code as SVG
        $qrCodeSvg = QrCode::size(300)
            ->format('svg')
            ->generate($qrCodeData['qr_code']);
        
        return response()->json([
            'success' => true,
            'qr_code' => $qrCodeData['qr_code'],
            'qr_code_svg' => $qrCodeSvg,
            'user_name' => $qrCodeData['user_name'],
            'user_email' => $qrCodeData['user_email'],
            'generated_at' => $qrCodeData['generated_at'],
            'expires_at' => $qrCodeData['expires_at'],
            'message' => 'QR code berhasil di-generate ulang'
        ]);
    }
    
    /**
     * Display QR code page for user
     */
    public function show()
    {
        $user = Auth::user();
        $qrCodeData = $user->getQrCodeData();
        
        // Generate QR code SVG server-side
        $qrCodeSvg = QrCode::size(256)
            ->format('svg')
            ->generate($qrCodeData['qr_code']);
        
        return view('qr-code.show', compact('qrCodeData', 'qrCodeSvg'));
    }
    
    /**
     * Validate QR code (for admin scanner)
     */
    public function validate(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);
        
        $qrCode = $request->qr_code;
        
        // Find user by QR code
        $user = User::where('qr_code', $qrCode)->first();
        
        if (!$user) {
            return response()->json([
                'valid' => false,
                'message' => 'QR code tidak valid atau tidak ditemukan'
            ], 404);
        }
        
        // Check if QR code is still valid (not expired)
        if (!$user->isQrCodeValid()) {
            return response()->json([
                'valid' => false,
                'message' => 'QR code sudah expired. Silakan generate ulang.'
            ], 410);
        }
        
        return response()->json([
            'valid' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'qr_code_generated_at' => $user->qr_code_generated_at,
            ],
            'message' => 'QR code valid. User dapat masuk ke Pasar Kolaboraya.'
        ]);
    }
    
    /**
     * Grant access to Pasar Kolaboraya after QR validation
     */
    public function grantAccess(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
            'pasar_kolaboraya_id' => 'required|exists:pasar_kolaborayas,id'
        ]);
        
        $qrCode = $request->qr_code;
        $pasarKolaborayaId = $request->pasar_kolaboraya_id;
        
        // Find user by QR code
        $user = User::where('qr_code', $qrCode)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'QR code tidak valid atau tidak ditemukan'
            ], 404);
        }
        
        // Check if QR code is still valid
        if (!$user->isQrCodeValid()) {
            return response()->json([
                'success' => false,
                'message' => 'QR code sudah expired. Silakan generate ulang.'
            ], 410);
        }
        
        // Find Pasar Kolaboraya
        $pasarKolaboraya = \App\Models\PasarKolaboraya::find($pasarKolaborayaId);
        
        if (!$pasarKolaboraya) {
            return response()->json([
                'success' => false,
                'message' => 'Pasar Kolaboraya tidak ditemukan'
            ], 404);
        }
        
        // Check if Pasar Kolaboraya is active
        if ($pasarKolaboraya->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Pasar Kolaboraya tidak aktif'
            ], 400);
        }
        
        // Check if user is already a member of this Pasar Kolaboraya
        $existingMembership = $pasarKolaboraya->users()->where('user_id', $user->id)->first();
        
        if ($existingMembership) {
            if ($existingMembership->pivot->status === 'accepted') {
                return response()->json([
                    'success' => false,
                    'message' => 'User sudah menjadi anggota Pasar Kolaboraya ini'
                ], 400);
            } else {
                // Update existing pending membership to accepted
                $pasarKolaboraya->users()->updateExistingPivot($user->id, [
                    'status' => 'accepted',
                    'joined_at' => now(),
                    'responded_at' => now(),
                ]);
            }
        } else {
            // Add user to Pasar Kolaboraya
            $pasarKolaboraya->users()->attach($user->id, [
                'status' => 'accepted',
                'role' => 'member',
                'invited_by' => Auth::id(),
                'join_reason' => 'QR Code Access Grant',
                'joined_at' => now(),
                'responded_at' => now(),
            ]);
        }
        
        // Set as active Pasar Kolaboraya for user
        $user->setActivePasarKolaboraya($pasarKolaboraya);
        
        // Log the access grant
        Log::info('QR Code Access Granted', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'qr_code' => $qrCode,
            'pasar_kolaboraya_id' => $pasarKolaboraya->id,
            'pasar_kolaboraya_name' => $pasarKolaboraya->name,
            'granted_by' => Auth::user()->name ?? 'System',
            'granted_at' => now(),
        ]);
        
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'pasar_kolaboraya' => [
                'id' => $pasarKolaboraya->id,
                'name' => $pasarKolaboraya->name,
                'description' => $pasarKolaboraya->description,
            ],
            'message' => 'Akses berhasil diberikan kepada ' . $user->name . ' untuk Pasar Kolaboraya: ' . $pasarKolaboraya->name
        ]);
    }
}