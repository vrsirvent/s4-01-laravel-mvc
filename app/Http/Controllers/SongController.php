<?php

namespace App\Http\Controllers;

use App\Models\MusicSong;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SongController extends Controller
{
    /**
     * Display the songs catalog with optional filters
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $styleFilter = $request->input('style');

        $songs = $this->getFilteredSongs($search);
        $allSongs = $this->mapSongsData($songs);

        if ($styleFilter) {
            $allSongs = $this->filterByStyle($allSongs, $styleFilter);
        }

        return view('song', [
            'allSongs' => $allSongs,
        ]);
    }

    /**
     * Get songs filtered by search
     *
     * @param string|null $search
     * @return Collection
     */
    private function getFilteredSongs(?string $search): Collection
    {
        $query = MusicSong::with(['artist', 'musicalStyle'])
            ->orderBy('title');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhereHas('artist', function($artistQuery) use ($search) {
                      $artistQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        return $query->get();
    }

    /**
     * Mapping song data with artist and style information
     *
     * @param Collection $songs
     * @return Collection
     */
    private function mapSongsData(Collection $songs): Collection
    {
        return $songs->map(function (MusicSong $song): array {
            return [
                'id' => $song->id,
                'title' => $song->title,
                'artist_name' => $song->artist->name,
                'artist_id' => $song->artist_id,
                'style' => $this->formatStyleName($song->musicalStyle->name),
                'style_id' => $song->musical_style_id,
                'length' => $song->length,
                'formatted_duration' => $song->getFormattedDuration(),
                'play_count' => $song->play_count,
            ];
        });
    }

    /**
     * Format musical style name (capitalize first letter)
     *
     * @param string|null $name
     * @return string
     */
    private function formatStyleName(?string $name): string
    {
        return ucfirst(strtolower(trim($name ?? '')));
    }

    /**
     * Filter songs by musical style
     *
     * @param Collection $songs
     * @param string $styleFilter
     * @return Collection
     */
    private function filterByStyle(Collection $songs, string $styleFilter): Collection
    {
        return $songs->filter(function (array $song) use ($styleFilter): bool {
            return $song['style'] === $styleFilter;
        });
    }
}


