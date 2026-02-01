<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoriteSong;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Add song to favorites
     */
    public function add(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'music_song_id' => 'required|exists:music_songs,id'
        ]);

        // Check if it already exists
        $exists = FavoriteSong::where('user_id', $user->id)
            ->where('music_song_id', $request->music_song_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Esta canción ya está en tus favoritos');
        }

        // Add
        FavoriteSong::create([
            'user_id' => $user->id,
            'music_song_id' => $request->music_song_id,
        ]);

        return redirect()->back()->with('success', '¡Canción agregada a favoritos!');
    }

    /**
     * Remove song from favorites
     */
    public function remove(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'music_song_id' => 'required|exists:music_songs,id'
        ]);

        // Remove
        FavoriteSng::where('user_id', $user->id)
            ->where('music_song_id', $request->music_song_id)
            ->delete();

        return redirect()->back()->with('success', 'Canción eliminada de favoritos');
    }

    /**
     * Toggle favorite (add if it doesn't exist, remove if it already exists).
     * The method used by the dashboard via AJAX.
     * Returns JSON with the result.
     */
    public function toggle(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'music_song_id' => 'required|exists:music_songs,id'
        ]);

        // Search to see if it already exists
        $favorite = FavoriteSong::where('user_id', $user->id)
            ->where('music_song_id', $request->music_song_id)
            ->first();

        if ($favorite) {
            // Already exists → delete
            $favorite->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Canción eliminada de favoritos'
            ]);
        }

        // Does not exist → add
        FavoriteSong::create([
            'user_id' => $user->id,
            'music_song_id' => $request->music_song_id,
        ]);

        return response()->json([
            'status' => 'added',
            'message' => '¡Canción agregada a favoritos!'
        ]);
    }
}


