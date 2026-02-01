<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusicalStyle extends Model
{

    protected $fillable = [
        'name',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    // Musical style has many songs (One to Many)
    public function musicSongs()
    {
        return $this->hasMany(MusicSong::class);
    }

    /**
     * Helper methods - Get total play count for all style's songs
     * @return int
     */
    public function getTotalPlayCount()
    {
        return $this->musicSongs()->sum('play_count');
    }

    /**
     * Get most played song of this style
     * @return \App\Models\MusicSong|null
     */
    public function getMostPlayedSong()
    {
        return $this->musicSongs()->orderBy('play_count', 'desc')->first();
    }

    /**
     * Get songs count
     * @return int
     */
    public function getSongsCount()
    {
        return $this->musicSongs()->count();
    }

    /**
     * Get unique artists that have songs in this style
     * @return int
     */
    public function getArtistsCount()
    {
        return $this->musicSongs()
            ->distinct()
            ->count('artist_id');
    }
}


