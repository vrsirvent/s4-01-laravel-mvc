<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteSong extends Model
{
    // use HasFactory;

    protected $fillable = [
        'user_id',
        'music_song_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'music_song_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    // Favorite belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Favorite belongs to a song
    public function musicSong()
    {
        return $this->belongsTo(MusicSong::class);
    }

}

