<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JukeboxToken;
use App\Models\UserToken;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class JukeboxController extends Controller
{
    /**
     * Main dashboard view
     * 
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $search = $request->input('search');

        $availableTokens = JukeboxToken::orderBy('song_quantity')->get();

        $userTokensRaw = UserToken::where('user_id', $user->id)
            ->with('jukeboxToken')
            ->get();

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

        $userMoney = $user->money ?? 0;

        $allSongs = $this->getFilteredSongs($search);
        $allArtists = $this->getFilteredArtists($search);

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
     * Get filtered songs by search (title or artist)
     * 
     * @param string|null $search
     * @return Collection
     */
    private function getFilteredSongs(?string $search): Collection
    {
        $query = \App\Models\MusicSong::with(['artist', 'musicalStyle'])
            ->orderBy('title');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhereHas('artist', fn($artistQuery) => $artistQuery->where('name', 'like', '%' . $search . '%'));
            });
        }

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
     * Get filtered artists that have at least one song
     * 
     * @param string|null $search
     * @return Collection
     */
    private function getFilteredArtists(?string $search): Collection
    {
        $query = \App\Models\Artist::has('musicSongs')
            ->withCount('musicSongs')
            ->orderBy('name');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

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
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function purchaseToken(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'jukebox_token_id' => 'required|exists:jukebox_tokens,id'
        ]);

        $token = JukeboxToken::findOrFail($request->jukebox_token_id);

        if ($user->money < $token->price) {
            return redirect()->route('dashboard')
                ->with('error', 'Insufficient balance. You need €' . number_format($token->price, 2) . ' but you only have €' . number_format($user->money, 2));
        }

        if ($token->stock <= 0) {
            return redirect()->route('dashboard')
                ->with('error', 'This token is sold out.');
        }

        $user->decrement('money', $token->price);
        $token->decrement('stock');

        UserToken::create([
            'user_id' => $user->id,
            'jukebox_token_id' => $token->id,
            'songs_used' => 0,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Token successfully purchased! ' . $token->name);
    }
}


