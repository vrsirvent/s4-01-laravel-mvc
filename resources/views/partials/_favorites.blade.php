{{-- Favorites section + instructions for use --}}
<div class="favorites">
    <h3 class="section-title section-title-pink text-lg md:text-xl mb-3 md:mb-4">⭐ FAVORITES ⭐</h3>
    
    {{-- If have favorites --}}
    <template x-if="favoriteSongs.length > 0">
        <div class="space-y-2">
            <template x-for="song in favoriteSongs" :key="'fav-' + song.id">
                <div class="favorite-song-item">
                    <div class="favorite-song-item-inner">
                        <div class="flex-1">
                            <p class="font-neon text-base text-neon-pink" x-text="song.title"></p>
                            <p class="text-xs text-gray-400">
                                <span x-text="song.artist_name"></span> • 
                                <span x-text="song.style"></span>
                            </p>
                        </div>
                        
                        {{-- Button to remove from favorites --}}
                        <button 
                            @click.stop="removeFavorite(song.id)"
                            class="favorite-btn active ml-3"
                            title="Remove from favorites">
                            <span>⭐</span>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </template>
    
    {{-- If NO have favorites --}}
    <template x-if="favoriteSongs.length === 0">
        <div class="empty-state">
            <p class="empty-state-icon">💖</p>
            <p class="font-neon text-lg md:text-xl empty-state-title text-neon-pink">NO FAVORITES</p>
            <p class="text-xs md:text-sm">Click ☆ on any song to add it to favorites</p>
        </div>
    </template>
</div>


