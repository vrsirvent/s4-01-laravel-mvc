<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JukeboxToken extends Model
{
    // use HasFactory;

    protected $fillable = [
        'name',
        'song_quantity',
        'price',
        'stock',
    ];

    protected $casts = [
        'song_quantity' => 'integer',
        'price' => 'float',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships

    // Token has many user purchases (One to Many)
    public function userTokens()
    {
        return $this->hasMany(UserToken::class);
    }

    // Helper methods  

    /**
     * Check if token is available (has stock)
     * @return bool
     */
    public function isAvailable()
    {
        return $this->stock > 0;
    }

    /**
     * Decrease stock by one
     * @return bool
     */
    public function decreaseStock()
    {
        if ($this->stock > 0) {
            $this->stock--;
            return $this->save();
        }
        return false;
    }

    /**
     * Get formatted price
     * @return string
     */
    public function getFormattedPrice()
    {
        return '$' . number_format($this->price, 2);
    }

    // Query scopes

    //  Scope: Only available tokens (with stock)
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

}

