<?php

namespace App\Http\Controllers;

use App\Models\MusicalStyle;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class MusicalStyleController extends Controller
{
    /**
     * Filtered musical styles listing
     * 
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        
        $styles = $this->getFilteredStyles($search);
        $allStyles = $this->mapStylesData($styles);
        
        return view('musical-style', [
            'allStyles' => $allStyles,
        ]);
    }
    
    /**
     * Get music styles filtered by search
     * 
     * @param string|null $search
     * @return Collection
     */
    private function getFilteredStyles(?string $search): Collection
    {
        $query = MusicalStyle::withCount('musicSongs')
            ->with('musicSongs.artist') 
            ->orderBy('name'); 
        
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        return $query->get();
    }
    
    /**
     * Mapping musical style data with artists and statistics
     * 
     * @param Collection $styles
     * @return Collection
     */
    private function mapStylesData(Collection $styles): Collection
    {
        return $styles->map(function (MusicalStyle $style): array {
            $artists = $this->extractUniqueArtists($style);
            
            return [
                'id' => $style->id,
                'name' => $style->name,
                'description' => $style->description,
                'songs_count' => $style->music_songs_count, 
                'artists_count' => count($artists),  
                'artists' => $artists,
                'artists_text' => implode(', ', $artists),  
            ];
        });
    }
    
    /**
     * Having the artist of a musical stye
     * 
     * @param MusicalStyle $style
     * @return array
     */
    private function extractUniqueArtists(MusicalStyle $style): array
    {
        return $style->musicSongs
            ->pluck('artist.name') 
            ->unique() 
            ->filter() 
            ->map(fn(?string $name): string => ucfirst(strtolower(trim($name))))
            ->sort()  
            ->values() 
            ->toArray();  
    }
}

