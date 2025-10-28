<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Http\Resources\Api\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Get user data from QR code
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getByQr(Request $request): JsonResponse
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        try {
            // Find user by QR code with optimized eager loading
            $user = User::with([
                'profile.peran',
                'profile.interests',
                'profile.skills',
                'profile.contributions'
            ])
            ->where('qr_code', $request->qr_code)
            ->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found with provided QR code',
                ], 404);
            }

            // Check if QR code is still valid
            if (!$user->isQrCodeValid()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'QR code has expired',
                ], 400);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User data retrieved successfully',
                'data' => new UserResource($user),
            ], 200);

        } catch (\Exception $e) {
            Log::error('API Error - Get User by QR', [
                'error' => $e->getMessage(),
                'qr_code' => $request->qr_code,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while retrieving user data',
            ], 500);
        }
    }

    /**
     * Get user data by ID
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function getById(int $id): JsonResponse
    {
        try {
            // Find user by ID with optimized eager loading
            $user = User::with([
                'profile.peran',
                'profile.interests',
                'profile.skills',
                'profile.contributions'
            ])
            ->find($id);

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User data retrieved successfully',
                'data' => new UserResource($user),
            ], 200);

        } catch (\Exception $e) {
            Log::error('API Error - Get User by ID', [
                'error' => $e->getMessage(),
                'user_id' => $id,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while retrieving user data',
            ], 500);
        }
    }

    /**
     * Get paginated list of users
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
            'approval_status' => 'nullable|in:pending,approved,rejected',
            'user_type' => 'nullable|in:partisipan,tamu,komunitas',
            'is_ecosystem_builder' => 'nullable|boolean',
            'search' => 'nullable|string|max:255',
        ]);

        try {
            $perPage = $request->input('per_page', 15);
            $page = $request->input('page', 1);

            // Build query with optimized eager loading
            $query = User::with([
                'profile.peran',
                'profile.interests',
                'profile.skills',
                'profile.contributions'
            ]);

            // Apply filters
            if ($request->filled('approval_status')) {
                $query->where('approval_status', $request->approval_status);
            }

            if ($request->filled('user_type')) {
                $query->where('user_type', $request->user_type);
            }

            if ($request->filled('is_ecosystem_builder')) {
                $query->where('is_ecosystem_builder', $request->boolean('is_ecosystem_builder'));
            }

            // Apply search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('organization_name', 'like', "%{$search}%");
                });
            }

            // Order by created_at descending for consistency
            $query->orderBy('created_at', 'desc');

            // Paginate results
            $users = $query->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'status' => 'success',
                'message' => 'Users retrieved successfully',
                'data' => UserResource::collection($users),
                'meta' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total(),
                    'from' => $users->firstItem(),
                    'to' => $users->lastItem(),
                ],
                'links' => [
                    'first' => $users->url(1),
                    'last' => $users->url($users->lastPage()),
                    'prev' => $users->previousPageUrl(),
                    'next' => $users->nextPageUrl(),
                ],
            ], 200);

        } catch (\Exception $e) {
            Log::error('API Error - Get Users Index', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while retrieving users',
            ], 500);
        }
    }
}

