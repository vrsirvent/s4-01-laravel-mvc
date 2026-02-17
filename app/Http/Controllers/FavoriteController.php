<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoriteSong;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Toggle favorite (add if not exists, remove if exists)
     * Used by dashboard via Alpine.js, returns JSON
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'music_song_id' => 'required|exists:music_songs,id'
        ]);

        $favorite = FavoriteSong::where('user_id', $user->id)
            ->where('music_song_id', $request->music_song_id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Song removed from favorites'
            ]);
        }

        FavoriteSong::create([
            'user_id' => $user->id,
            'music_song_id' => $request->music_song_id,
        ]);

        return response()->json([
            'status' => 'added',
            'message' => 'Song added to favorites!'
        ]);
    }
}


