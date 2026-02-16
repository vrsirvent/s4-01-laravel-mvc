<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    // use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    
    // Artist has many songs (One to Many)
    public function musicSongs()
    {
        return $this->hasMany(MusicSong::class);
    }

    /**
     * Helper methods - Get total play count for all artist's songs
     * @return int
     */
    public function getTotalPlayCount()
    {
        return $this->musicSongs()->sum('play_count');
    }

    /**
     * Get most played song of this artist
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
}
