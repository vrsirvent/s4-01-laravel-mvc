<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    // use HasFactory;

    protected $fillable = [
        'user_id',
        'jukebox_token_id',
        'songs_used',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'jukebox_token_id' => 'integer',
        'songs_used' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    //  User token belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // User token belongs to a jukebox token type
    public function jukeboxToken()
    {
        return $this->belongsTo(JukeboxToken::class);
    }

    // Helper methods

    /**
     * Check if token has remaining songs
     * @return bool
     */
    public function hasRemainingSongs()
    {
        $maxSongs = $this->jukeboxToken->song_quantity ?? 0;
        return $this->songs_used < $maxSongs;
    }

    /**
     * Use one song from this token
     * @return bool
     */
    public function useSong()
    {
        $maxSongs = $this->jukeboxToken->song_quantity ?? 0;
        if ($this->songs_used < $maxSongs) {
            $this->songs_used++;
            return $this->save();
        }
        return false;
    }

    /**
     * Get token type name
     * @return string
     */
    public function getTokenName()
    {
        return $this->jukeboxToken->name ?? 'Unknown';
    }

    // Query scopes

    /* Scope: Only active tokens (with remaining songs)*/
    public function scopeActive($query)
    {
        return $query->whereRaw('songs_used < (SELECT song_quantity FROM jukebox_tokens WHERE jukebox_tokens.id = user_tokens.jukebox_token_id)');
    }

}

