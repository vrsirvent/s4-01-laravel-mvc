<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MusicSong;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    // See all songs
    public function index()
    {
        $user = Auth::user();
        
        // Have all songs with artist and style
        $allSongs = MusicSong::with(['artist', 'musicalStyle'])
            ->orderBy('title')
            ->get()
            ->map(function($song) {
                return [
                    'id' => $song->id,
                    'title' => $song->title,
                    'artist_name' => $song->artist->name,
                    // Style: First capital letter and use lowercase for the rest
                    'style' => ucfirst(strtolower(trim($song->musicalStyle->name))),
                ];
            });
        
        return view('song', [
            'allSongs' => $allSongs,
        ]);
    }
}


