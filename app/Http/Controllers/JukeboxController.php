<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JukeboxToken;
use App\Models\UserToken;
use Illuminate\Support\Facades\Auth;

class JukeboxController extends Controller
{
    /**
     * Dashboard view
     */
    public function index()
    {
        $user = Auth::user();
        
        // Have tokens for buy (BD)
        $availableTokens = JukeboxToken::orderBy('song_quantity')->get();
        
        // Have tokens that the user has grouped by type
        $userTokensRaw = UserToken::where('user_id', $user->id)
            ->with('jukeboxToken')
            ->get();
        
        // Array counter token token type
        $tokenCounts = [];
        
        foreach ($availableTokens as $token) {
            $activeTokens = $userTokensRaw->filter(function($userToken) use ($token) {
                if ($userToken->jukebox_token_id == $token->id) {
                    if ($token->song_quantity == 0) {
                        return true;
                    }
                    return $userToken->songs_used < $token->song_quantity;
                }
                return false;
            })->count();
            
            $tokenCounts[$token->name] = $activeTokens;
        }

        // User credit (read DB)
        $userMoney = \DB::table('users')->where('id', $user->id)->value('money') ?? 0;

        // MOTO - have all songs
        $allSongs = \App\Models\MusicSong::with(['artist', 'musicalStyle'])
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

        // CAR - have all artists
        $allArtists = \App\Models\Artist::has('musicSongs')
            ->withCount('musicSongs')
            ->orderBy('name')
            ->get()
            ->map(function($artist) {
                return [
                    'id' => $artist->id,
                    'name' => $artist->name,
                    'songs_count' => $artist->music_songs_count,
                    'description' => $artist->description,
                ];
            });

        //  CAR - have songs by artist (grouped)
        $songsByArtist = \App\Models\MusicSong::with(['artist', 'musicalStyle'])
            ->get()
            ->groupBy('artist_id')
            ->map(function($songs) {
                return $songs->map(function($song) {
                    return [
                        'id' => $song->id,
                        'title' => $song->title,
                        'artist_name' => $song->artist->name,
                        'style' => $song->musicalStyle->name,
                        'length' => $song->length,
                        'url_file' => $song->url_file ? asset('storage/' . $song->url_file) : null,
                    ];
                })->values();
            });

        // Have user's favorite songs
        $favoriteSongs = $user->favoriteSongs()
            ->with(['artist', 'musicalStyle'])
            ->orderBy('favorite_songs.created_at', 'desc')
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

        // IDs favorites songs
        $favoriteIds = $favoriteSongs->pluck('id')->toArray();

        // Current song
        $currentSong = null;

        return view('dashboard', compact(
            'availableTokens',
            'tokenCounts',
            'currentSong',
            'userMoney',
            'allSongs',
            'allArtists',
            'songsByArtist',
            'favoriteSongs',
            'favoriteIds'
        ));
    }

    /**
     * Buy token process
     */
    public function purchaseToken(Request $request)
    {
        $user = Auth::user();
        
        // Validate that the token ID was sent
        $request->validate([
            'jukebox_token_id' => 'required|exists:jukebox_tokens,id'
        ]);
        
        //  Receive token you want to buy
        $token = JukeboxToken::findOrFail($request->jukebox_token_id);
        
        // Receive current user's balance
        $userMoney = \DB::table('users')->where('id', $user->id)->value('money') ?? 0;
        
        // Validate that the user has sufficient funds
        if ($userMoney < $token->price) {
            return redirect()->route('dashboard')
                ->with('error', 'Insufficient balance. You need €' . number_format($token->price, 2) . ' but you only have €' . number_format($userMoney, 2));
        }

        // Validate that there is stock available
        if ($token->stock <= 0) {
            return redirect()->route('dashboard')
                ->with('error', 'This token is out of stock.');
        }
        
        // Complete the purchase (transaction)
        \DB::transaction(function () use ($user, $token) {
            // Subtract money from the user
            \DB::table('users')
                ->where('id', $user->id)
                ->decrement('money', $token->price);
            
            // 2. Subtract stock from the token
            $token->decrement('stock');
            
            // 3. Create record in user_tokens
            UserToken::create([
                'user_id' => $user->id,
                'jukebox_token_id' => $token->id,
                'songs_used' => 0,
            ]);
        });
        
        return redirect()->route('dashboard');
    }

}
