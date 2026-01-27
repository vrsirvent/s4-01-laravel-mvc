<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoriteSong;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Agregar canción a favoritos
     */
    public function add(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'music_song_id' => 'required|exists:music_songs,id'
        ]);
        
        // Verificar si ya existe
        $exists = FavoriteSong::where('user_id', $user->id)
            ->where('music_song_id', $request->music_song_id)
            ->exists();
        
        if ($exists) {
            return redirect()->back()->with('error', 'This song is already in your favorites');
        }
        
        // Agregar a favoritos
        FavoriteSong::create([
            'user_id' => $user->id,
            'music_song_id' => $request->music_song_id,
        ]);
        
        return redirect()->back()->with('success', 'Song added to favorites!');
    }
    
    /**
     * Quitar canción de favoritos
     */
    public function remove(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'music_song_id' => 'required|exists:music_songs,id'
        ]);
        
        // Eliminar de favoritos
        FavoriteSong::where('user_id', $user->id)
            ->where('music_song_id', $request->music_song_id)
            ->delete();
        
        return redirect()->back()->with('success', 'Song removed from favorites');
    }
    
    /**
     * Toggle favorito (agregar o quitar)
     */
    public function toggle(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'music_song_id' => 'required|exists:music_songs,id'
        ]);
        
        // Verificar si existe
        $favorite = FavoriteSong::where('user_id', $user->id)
            ->where('music_song_id', $request->music_song_id)
            ->first();
        
        if ($favorite) {
            // Quitar de favoritos
            $favorite->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Song removed from favorites'
            ]);
        } else {
            // Agregar a favoritos
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
