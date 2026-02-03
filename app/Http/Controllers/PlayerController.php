<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserToken;
use App\Models\MusicSong;
use App\Models\JukeboxToken;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    /**
     * Consume tokens and obtain songs to play
     */
    public function consumeToken(Request $request)
    {
        $user = Auth::user();

        $mode = $request->input('mode');

        if (!in_array($mode, ['moto', 'car'])) {
            return response()->json(['error' => 'Invalid mode'], 400);
        }

        if ($mode === 'moto') {
            return $this->consumeMotoToken($user, $request);
        }

        return $this->consumeCarToken($user, $request);
    }

    /**
     * Consume MOTO token: plays the selected songs
     */
    private function consumeMotoToken($user, Request $request)
    {
        $quantity = $request->input('quantity');
        $songIds = $request->input('song_ids', []);

        if (!in_array($quantity, [1, 3, 5])) {
            return response()->json(['error' => 'Invalid quantity'], 400);
        }

        if (empty($songIds) || !is_array($songIds)) {
            return response()->json(['error' => 'The songs are required.'], 400);
        }

        if (count($songIds) != $quantity) {
            return response()->json([
                'error' => "You must select exactly {$quantity} songs"
            ], 400);
        }

        $tokenName = "moto_{$quantity}";
        $token = JukeboxToken::where('name', $tokenName)->first();

        if (!$token) {
            return response()->json(['error' => 'Token not found'], 404);
        }

        $userToken = UserToken::where('user_id', $user->id)
            ->where('jukebox_token_id', $token->id)
            ->where('songs_used', '<', $token->song_quantity)
            ->orderBy('created_at', 'asc')
            ->first();

        if (!$userToken) {
            return response()->json([
                'error' => "You have no tokens {$tokenName} available"
            ], 400);
        }

        $userToken->songs_used = $token->song_quantity;
        $userToken->save();

        $songs = MusicSong::whereIn('id', $songIds)
            ->with(['artist', 'musicalStyle'])
            ->get()
            ->map(function($song) {
                return $this->formatSong($song);
            });

        MusicSong::whereIn('id', $songIds)->increment('play_count');

        return response()->json([
            'success' => true,
            'message' => "Token {$tokenName} successfully consumed",
            'songs' => $songs,
            'mode' => 'moto'
        ]);
    }

    /**
     * Consume CAR token: play all songs by an artist
     */
    private function consumeCarToken($user, Request $request)
    {
        $artistId = $request->input('artist_id');

        if (empty($artistId)) {
            return response()->json(['error' => 'The artist is required'], 400);
        }

        $token = JukeboxToken::where('name', 'car')->first();

        if (!$token) {
            return response()->json(['error' => 'Token CAR not found'], 404);
        }

        $userToken = UserToken::where('user_id', $user->id)
            ->where('jukebox_token_id', $token->id)
            ->where('songs_used', '<', $token->song_quantity)
            ->orderBy('created_at', 'asc')
            ->first();

        if (!$userToken) {
            return response()->json([
                'error' => 'You have no CAR tokens available'
            ], 400);
        }

        $userToken->songs_used++;
        $userToken->save();

        $songs = MusicSong::where('artist_id', $artistId)
            ->with(['artist', 'musicalStyle'])
            ->orderBy('title')
            ->get()
            ->map(function($song) {
                return $this->formatSong($song);
            });

        MusicSong::where('artist_id', $artistId)->increment('play_count');

        return response()->json([
            'success' => true,
            'message' => 'Token CAR successfully consumed',
            'songs' => $songs,
            'mode' => 'car'
        ]);
    }

    /**
     * Format a song in an array for the JSON response
     */
    private function formatSong(MusicSong $song): array
    {
        return [
            'id' => $song->id,
            'title' => $song->title,
            'artist_name' => $song->artist->name,
            'style' => $song->musicalStyle->name,
            'length' => $song->length,
            'url_file' => $song->url_file ? asset('storage/' . $song->url_file) : null,
        ];
    }
}


