{{-- Song catalog (MOTO mode) and artist catalog (CAR mode) --}}
<div class="catalog">
    <h3 class="section-title section-title-cyan text-lg md:text-xl mb-3 md:mb-4">⭐ CATALOG ⭐</h3>

    {{-- MOTO: see songs --}}
    <div x-show="selectedMode === 'moto'" x-cloak>
        <div x-show="availableSongs.length > 0">
            <div class="space-y-2">
                <template x-for="song in availableSongs" :key="song.id">
                    <div class="song-item" 
                        :class="{ 'selected': isSongSelected(song.id) }">
                        <div class="song-item-inner"
                            :class="{ 'bg-gray-700': isSongSelected(song.id) }">
                            <div class="flex-1 song-selection-area"
                                :class="{ 'opacity-50 cursor-not-allowed': !selectedQuantity }"
                                @click="selectedQuantity && !isLocked ? toggleSongSelection(song.id) : (selectedQuantity ? null : alert('Please select quantity from traffic light first'))">
                                <p class="font-neon text-base text-neon-cyan" x-text="song.title"></p>
                                <p class="text-xs text-gray-400">
                                    <span x-text="song.artist_name"></span> • 
                                    <span x-text="song.style"></span>
                                </p>
                            </div>
                            
                            {{-- Favorite button --}}
                            <button 
                                @click.stop="addFavorite(song.id)"
                                :disabled="isFavorite(song.id)"
                                class="favorite-btn ml-3"
                                :class="{ 'active': isFavorite(song.id) }"
                                title="Add to favorites">
                                <span x-text="isFavorite(song.id) ? '⭐' : '☆'"></span>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    
    {{-- CAR: see artists --}}
    <div x-show="selectedMode === 'car'" x-cloak>
        <div x-show="availableArtists.length > 0">
            <div class="space-y-2">
                <template x-for="artist in availableArtists" :key="artist.id">
                    <div class="artist-item"
                        :class="{ 'selected': selectedArtist === artist.id, 'opacity-50 cursor-not-allowed': isLocked }"
                        @click.stop="!isLocked ? selectArtist(artist.id) : null">
                        <div class="artist-item-inner"
                            :class="{ 'bg-gray-700': selectedArtist === artist.id }">
                            <div class="flex-1">
                                <p class="font-neon text-base text-neon-purple" x-text="artist.name"></p>
                                <p class="text-xs text-gray-400">
                                    <span x-text="artist.songs_count"></span> songs
                                </p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    
    {{-- Empty --}}
    <div x-show="!selectedMode" x-cloak>
        <div class="empty-state">
            <p class="empty-state-icon">🎵</p>
            <p class="font-neon text-lg md:text-xl empty-state-title text-neon-cyan">SELECT MODE</p>
            <p class="text-xs md:text-sm">Choose MOTO or CAR to see the catalog</p>
        </div>
    </div>
</div>


