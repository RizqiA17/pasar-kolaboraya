<?php

namespace App\Http\Controllers;

use App\Models\CollectiveAction;
use App\Models\CollectiveActionLike;
use App\Models\Ecosystem;
use App\Models\EcosystemLike;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle like for collective action
     */
    public function toggleCollectiveActionLike(CollectiveAction $collectiveAction)
    {
        $user = Auth::user();
        
        if (!$user->canLike()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk melakukan like.'
            ], 403);
        }

        $existingLike = CollectiveActionLike::where('user_id', $user->id)
            ->where('collective_action_id', $collectiveAction->id)
            ->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            $isLiked = false;
        } else {
            // Like
            CollectiveActionLike::create([
                'user_id' => $user->id,
                'collective_action_id' => $collectiveAction->id,
            ]);
            $isLiked = true;
        }

        $likeCount = $collectiveAction->likes()->count();

        return response()->json([
            'success' => true,
            'isLiked' => $isLiked,
            'likeCount' => $likeCount,
            'message' => $isLiked ? 'Berhasil menyukai aksi kolektif!' : 'Berhasil menghapus like!'
        ]);
    }

    /**
     * Toggle like for ecosystem
     */
    public function toggleEcosystemLike(Ecosystem $ecosystem)
    {
        $user = Auth::user();
        
        if (!$user->canLike()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk melakukan like.'
            ], 403);
        }

        $existingLike = EcosystemLike::where('user_id', $user->id)
            ->where('ecosystem_id', $ecosystem->id)
            ->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            $isLiked = false;
        } else {
            // Like
            EcosystemLike::create([
                'user_id' => $user->id,
                'ecosystem_id' => $ecosystem->id,
            ]);
            $isLiked = true;
        }

        $likeCount = $ecosystem->likes()->count();

        return response()->json([
            'success' => true,
            'isLiked' => $isLiked,
            'likeCount' => $likeCount,
            'message' => $isLiked ? 'Berhasil menyukai ekosistem!' : 'Berhasil menghapus like!'
        ]);
    }

    /**
     * Get like status for collective action
     */
    public function getCollectiveActionLikeStatus(CollectiveAction $collectiveAction)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => true,
                'isLiked' => false,
                'likeCount' => $collectiveAction->likes()->count(),
                'canLike' => false
            ]);
        }

        return response()->json([
            'success' => true,
            'isLiked' => $collectiveAction->isLikedBy($user),
            'likeCount' => $collectiveAction->likes()->count(),
            'canLike' => $user->canLike()
        ]);
    }

    /**
     * Get like status for ecosystem
     */
    public function getEcosystemLikeStatus(Ecosystem $ecosystem)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => true,
                'isLiked' => false,
                'likeCount' => $ecosystem->likes()->count(),
                'canLike' => false
            ]);
        }

        return response()->json([
            'success' => true,
            'isLiked' => $ecosystem->isLikedBy($user),
            'likeCount' => $ecosystem->likes()->count(),
            'canLike' => $user->canLike()
        ]);
    }
}
