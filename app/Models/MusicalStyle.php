<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicalStyle extends Model
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

    // Musical style has many songs (One to Many) 
    public function musicSongs()
    {
        return $this->hasMany(MusicSong::class);
    }

    /* Helper Methods - Get total songs count for this style */

    /**
     * @return int
     */
    public function getSongsCount()
    {
        return $this->musicSongs()->count();
    }

    /**
     * Get most popular songs of this style
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTopSongs($limit = 10)
    {
        return $this->musicSongs()
                    ->orderBy('play_count', 'desc')
                    ->limit($limit)
                    ->get();
    }

}

