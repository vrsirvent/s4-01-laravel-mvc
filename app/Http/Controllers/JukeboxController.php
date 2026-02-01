<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JukeboxToken;
use App\Models\UserToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class JukeboxController extends Controller
{
    /**
     * View of the main dashboard
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        // Search term from the catalog form
        $search = $request->input('search');

        // Tokens available for purchase (from the database)
        $availableTokens = JukeboxToken::orderBy('song_quantity')->get();

        // Tokens held by the user, grouped by type
        $userTokensRaw = UserToken::where('user_id', $user->id)
            ->with('jukeboxToken')
            ->get();

        // Active token counter by type
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

        // User balance (DB)
        $userMoney = \DB::table('users')->where('id', $user->id)->value('money') ?? 0;

        // Songs and artists filtered by search
        $allSongs = $this->getFilteredSongs($search);
        $allArtists = $this->getFilteredArtists($search);

        // User's favorite songs
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

        // Favorite song IDs (to mark as active star in the catalog)
        $favoriteIds = $favoriteSongs->pluck('id')->toArray();

        return view('dashboard', compact(
            'availableTokens',
            'tokenCounts',
            'userMoney',
            'allSongs',
            'allArtists',
            'favoriteSongs',
            'favoriteIds',
            'search'
        ));
    }

    /**
     * Get searched songs. By song or artist.
     *
     * @param string|null $search
     * @return Collection
     */
    private function getFilteredSongs(?string $search): Collection
    {
        $query = \App\Models\MusicSong::with(['artist', 'musicalStyle'])
            ->orderBy('title');

        // If search exists, filter by song or artist
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhereHas('artist', fn($artistQuery) => $artistQuery->where('name', 'like', '%' . $search . '%'));
            });
        }

        // Array with the data needed by the view
        return $query->get()->map(function($song) {
            return [
                'id' => $song->id,
                'title' => $song->title,
                'artist_name' => $song->artist->name,
                'style' => $song->musicalStyle->name,
                'length' => $song->length,
                'url_file' => $song->url_file ? asset('storage/' . $song->url_file) : null,
            ];
        });
    }

    /**
     * Get searched artists. Only artists that have at least one song.
     *
     * @param string|null $search
     * @return Collection
     */
    private function getFilteredArtists(?string $search): Collection
    {
        // Only artists with songs
        $query = \App\Models\Artist::has('musicSongs')
            ->withCount('musicSongs')
            ->orderBy('name');

        // If there is a search, filter by artist
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Array with the data needed by the view
        return $query->get()->map(function($artist) {
            return [
                'id' => $artist->id,
                'name' => $artist->name,
                'songs_count' => $artist->music_songs_count,
                'description' => $artist->description,
            ];
        });
    }

    /**
     * Token purchase process
     */
    public function purchaseToken(Request $request)
    {
        $user = Auth::user();

        // Validate ID token
        $request->validate([
            'jukebox_token_id' => 'required|exists:jukebox_tokens,id'
        ]);

        // Token you want to buy
        $token = JukeboxToken::findOrFail($request->jukebox_token_id);

        // Current balance
        $userMoney = \DB::table('users')->where('id', $user->id)->value('money') ?? 0;

        // Validate balance
        if ($userMoney < $token->price) {
            return redirect()->route('dashboard')
                ->with('error', 'Insufficient balance. You need €' . number_format($token->price, 2) . ' but you only have €' . number_format($userMoney, 2));
        }

        // Validate stock
        if ($token->stock <= 0) {
            return redirect()->route('dashboard')
                ->with('error', 'This token is sold out.');
        }

        // Complete the purchase
        \DB::transaction(function () use ($user, $token) {
            // Discount money
            \DB::table('users')
                ->where('id', $user->id)
                ->decrement('money', $token->price);

            // Discount stock
            $token->decrement('stock');

            // Create record
            UserToken::create([
                'user_id' => $user->id,
                'jukebox_token_id' => $token->id,
                'songs_used' => 0,
            ]);
        });

        return redirect()->route('dashboard');
    }
}


