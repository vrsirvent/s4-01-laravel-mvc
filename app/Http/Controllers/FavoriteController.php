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
        
        // if exist already
        $exists = FavoriteSong::where('user_id', $user->id)
            ->where('music_song_id', $request->music_song_id)
            ->exists();
        
        if ($exists) {
            return redirect()->back()->with('error', 'This song is already in your favorites');
        }
        
        // Add to favorites
        FavoriteSong::create([
            'user_id' => $user->id,
            'music_song_id' => $request->music_song_id,
        ]);
        
        return redirect()->back()->with('success', 'Song added to favorites!');
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
        
        // Remove from favorites
        FavoriteSong::where('user_id', $user->id)
            ->where('music_song_id', $request->music_song_id)
            ->delete();
        
        return redirect()->back()->with('success', 'Song removed from favorites');
    }
    
    /**
     * Favorite (add or remove)
     */
    public function toggle(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'music_song_id' => 'required|exists:music_songs,id'
        ]);
        
        // if exists already
        $favorite = FavoriteSong::where('user_id', $user->id)
            ->where('music_song_id', $request->music_song_id)
            ->first();
        
        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Song removed from favorites'
            ]);
        } else {
            // Add to favorites
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
}
