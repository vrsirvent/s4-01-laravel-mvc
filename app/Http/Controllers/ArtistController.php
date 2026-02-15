<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ArtistController extends Controller
{
    /**
     * Filtered artists listing
     *  
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $styleFilter = $request->input('style');
        
        $artists = $this->getFilteredArtists($search);
        $allArtists = $this->mapArtistsData($artists);
        
        if ($styleFilter) {
            $allArtists = $this->filterByStyle($allArtists, $styleFilter);
        }
        
        return view('artist', [
            'allArtists' => $allArtists,
        ]);
    }

    /**
     * Get artists filtered by search
     * 
     * @param string|null $search
     * @return Collection
     */
    private function getFilteredArtists(?string $search): Collection
    {
        $query = Artist::withCount('musicSongs')
            ->with('musicSongs.musicalStyle')
            ->orderBy('name');
        
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        return $query->get();
    }

    /**
     * Mapping artist data with styles and statistics
     * 
     * @param Collection $artists
     * @return Collection
     */
    private function mapArtistsData(Collection $artists): Collection
    {
        return $artists->map(function (Artist $artist): array {
            $styles = $this->extractUniqueStyles($artist);
            
            return [
                'id' => $artist->id,
                'name' => $artist->name,
                'description' => $artist->description,
                'songs_count' => $artist->music_songs_count,
                'total_plays' => $artist->getTotalPlayCount(),
                'styles' => $styles,
                'styles_text' => implode(', ', $styles),
            ];
        });
    }

    /**
     * Having the musical style of an artist
     * 
     * @param Artist $artist
     * @return array
     */
    private function extractUniqueStyles(Artist $artist): array
    {
        return $artist->musicSongs
            ->pluck('musicalStyle.name')
            ->unique()
            ->filter()
            ->map(fn(?string $name): string => ucfirst(strtolower(trim($name))))
            ->sort()
            ->values()
            ->toArray();
    }

    /**
     * Filter artists by musical style
     * 
     * @param Collection $artists
     * @param string $styleFilter
     * @return Collection
     */
    private function filterByStyle(Collection $artists, string $styleFilter): Collection
    {
        return $artists->filter(function (array $artist) use ($styleFilter): bool {
            return in_array($styleFilter, $artist['styles']);
        });
    }
}


