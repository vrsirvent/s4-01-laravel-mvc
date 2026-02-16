<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusicSong extends Model
{

    // use HasFactory;

    protected $fillable = [
        'title',
        'length',
        'url_file',
        'play_count',
        'artist_id',
        'musical_style_id',
    ];

    protected $casts = [
        'length' => 'decimal:2', 
        'play_count' => 'integer',
        'artist_id' => 'integer',
        'musical_style_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    
    /**
     * Song belongs to an artist (Many to One)
     */
    public function artist() {
        return $this->belongsTo(Artist::class);
    }

    /**
     * Song belongs to a musical style (Many to One)
     */
    public function musicalStyle() {
        return $this->belongsTo(MusicalStyle::class);
    }

    /**
     * Song can be favorited by many users (Many to Many)
     */
    public function favoritedByUsers() {
        return $this->belongsToMany(
            User::class,
            'favorite_songs',
            'music_song_id',
            'user_id'
        )->withTimestamps();
    }

    // Helper methods 

    /**
     * Increment play count
     * @return bool
     */
    public function incrementPlayCount() {
        $this->play_count++;
        return $this->save();
    }

    /**
     * Get formatted duration (MM:SS)
     * @return string
     */
    public function getFormattedDuration() {
        $minutes = floor($this->length / 60);
        $seconds = $this->length % 60;
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Check if song is favorited by a specific user
     * @param int $userId
     * @return bool
     */
    public function isFavoritedBy($userId) {
        return $this->favoritedByUsers()->where('user_id', $userId)->exists();
    }

    // Query scopes (Reusable) 

    /**
     * Scope: Filter by artist
     */
    public function scopeByArtist($query, $artistId) {
        return $query->where('artist_id', $artistId);
    }

    /**
     * Scope: Filter by musical style
     */
    public function scopeByStyle($query, $styleId) {
        return $query->where('musical_style_id', $styleId);
    }

    /**
     * Scope: Most played songs
     */
    public function scopeMostPlayed($query) {
        return $query->orderBy('play_count', 'desc');
    }
}


