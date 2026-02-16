<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'other_information', 
        'money',

    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'money' => 'decimal:2', 
        ];
    }

    // Relationships

    // User has many favorite songs (Many to Many)
    public function favoriteSongs()
    {
        return $this->belongsToMany(
            MusicSong::class,
            'favorite_songs',
            'user_id',
            'music_song_id'
        )->withTimestamps();
    }

    // User has many tokens (One to Many)
    public function userTokens()
    {
        return $this->hasMany(UserToken::class);
    }

   // Helper methods

    /**
     * @param int $songId
     * @return bool
     */
    public function hasFavorite($songId)
    {
        return $this->favoriteSongs()->where('music_song_id', $songId)->exists();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableTokens()
    {
        return $this->userTokens()->where('quantity', '>', 0)->get();
    }

    /**
     * @param float $amount
     * @return bool
     */
    public function hasEnoughMoney($amount)
    {
        return $this->money >= $amount;
    }

}

