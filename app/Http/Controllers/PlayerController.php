<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserToken;
use App\Models\MusicSong;
use App\Models\JukeboxToken; 
use App\Models\Artist;      
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    /**
     * Consumir token y obtener canciones para reproducir
     */
    public function consumeToken(Request $request)
    {
        $user = Auth::user();

        // LOG: Ver que datos llegan
        \Log::info('===== CONSUME TOKEN REQUEST =====');
        \Log::info('Mode:', [$request->input('mode')]);
        \Log::info('Quantity:', [$request->input('quantity')]);
        \Log::info('Song IDs:', [$request->input('song_ids')]);
        \Log::info('Artist ID:', [$request->input('artist_id')]);
        \Log::info('All data:', $request->all());
        \Log::info('================================');
        
        // Validacion manual mas clara
        $mode = $request->input('mode');
        
        if (!in_array($mode, ['moto', 'car'])) {
            \Log::error('Invalid mode');
            return response()->json(['error' => 'Invalid mode'], 400);
        }
        
        if ($mode === 'moto') {
            // Modo MOTO: reproducir canciones seleccionadas
            $quantity = $request->input('quantity');
            $songIds = $request->input('song_ids', []);
            
            \Log::info('MOTO - Validating quantity and songs');
            
            if (!in_array($quantity, [1, 3, 5])) {
                return response()->json(['error' => 'Invalid quantity'], 400);
            }
            
            if (empty($songIds) || !is_array($songIds)) {
                return response()->json(['error' => 'song_ids required'], 400);
            }
            
            if (count($songIds) != $quantity) {
                return response()->json([
                    'error' => "You must select exactly {$quantity} songs"
                ], 400);
            }
            
            // Buscar token disponible
            $tokenName = "moto_{$quantity}";
            $token = JukeboxToken::where('name', $tokenName)->first();
            
            if (!$token) {
                return response()->json(['error' => 'Token not found'], 404);
            }
            
            // Buscar token del usuario (mas antiguo primero)
            $userToken = UserToken::where('user_id', $user->id)
                ->where('jukebox_token_id', $token->id)
                ->where('songs_used', '<', $token->song_quantity)
                ->orderBy('created_at', 'asc')
                ->first();
            
            if (!$userToken) {
                return response()->json([
                    'error' => "You don't have any {$tokenName} tokens available"
                ], 400);
            }
            
            // Consumir token (marcar como usado completamente)
            $userToken->songs_used = $token->song_quantity;
            $userToken->save();
            
            // Obtener canciones
            $songs = MusicSong::whereIn('id', $songIds)
                ->with(['artist', 'musicalStyle'])
                ->get()
                ->map(function($song) {
                    return [
                        'id' => $song->id,
                        'title' => $song->title,
                        'artist_name' => $song->artist->name,
                        'style' => $song->musicalStyle->name,
                        'length' => $song->length,
                        'url_file' => $song->url_file ? asset('storage/' . $song->url_file) : null,
                    ];
                });
            
            // Incrementar play_count
            MusicSong::whereIn('id', $songIds)->increment('play_count');
            
            \Log::info('MOTO - Success, returning songs');
            
            return response()->json([
                'success' => true,
                'message' => "Token {$tokenName} consumed successfully",
                'songs' => $songs,
                'mode' => 'moto'
            ]);
            
        } else {
            // Modo CAR: reproducir todas las canciones del artista
            $artistId = $request->input('artist_id');
            
            \Log::info('CAR - Artist ID received:', [$artistId]);
            
            if (empty($artistId)) {
                \Log::error('CAR - Artist ID is empty!');
                return response()->json(['error' => 'artist_id is required'], 400);
            }
            
            // Buscar token CAR
            $token = JukeboxToken::where('name', 'car')->first();
            
            if (!$token) {
                \Log::error('CAR - Token not found in database');
                return response()->json(['error' => 'CAR token not found'], 404);
            }
            
            \Log::info('CAR - Token found:', ['id' => $token->id]);
            
            // Buscar token del usuario
            $userToken = UserToken::where('user_id', $user->id)
                ->where('jukebox_token_id', $token->id)
                ->where('songs_used', '<', $token->song_quantity)
                ->orderBy('created_at', 'asc')
                ->first();
            
            if (!$userToken) {
                \Log::error('CAR - No user tokens available');
                return response()->json([
                    'error' => "You don't have any CAR tokens available"
                ], 400);
            }
            
            \Log::info('CAR - User token found, consuming...');
            
            // Consumir token (incrementar songs_used)
            $userToken->songs_used++;
            $userToken->save();
            
            \Log::info('CAR - Fetching songs for artist:', [$artistId]);
            
            // Obtener todas las canciones del artista
            $songs = MusicSong::where('artist_id', $artistId)
                ->with(['artist', 'musicalStyle'])
                ->orderBy('title')
                ->get()
                ->map(function($song) {
                    return [
                        'id' => $song->id,
                        'title' => $song->title,
                        'artist_name' => $song->artist->name,
                        'style' => $song->musicalStyle->name,
                        'length' => $song->length,
                        'url_file' => $song->url_file ? asset('storage/' . $song->url_file) : null,
                    ];
                });
            
            \Log::info('CAR - Songs found:', ['count' => $songs->count()]);
            
            // Incrementar play_count
            MusicSong::where('artist_id', $artistId)->increment('play_count');
            
            \Log::info('CAR - Success, returning songs');
            
            return response()->json([
                'success' => true,
                'message' => 'Token CAR consumed successfully',
                'songs' => $songs,
                'mode' => 'car'
            ]);
        }
    }
}
