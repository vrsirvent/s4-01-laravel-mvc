<x-app-layout>
    <div class="py-4 md:py-8" x-data="songCatalog()">
        <div class="container mx-auto px-2 md:px-4">
            <div class="jukebox max-w-7xl mx-auto">
                
                <div class="jukebox-top">
                    <div class="top-arch"></div>
                    <div class="top-lights">
                        <div class="category-carousel">
                            <span class="category category-1">JAZZ</span>
                            <span class="category category-2">ROCK</span>
                            <span class="category category-3">BLUES</span>
                            <span class="category category-4">SOUL</span>
                            <span class="category category-5">SWING</span>
                            <span class="category category-6">POP</span>
                        </div>
                    </div>
                    <div class="jukebox-title">
                        <h1>SONGS CATALOG</h1>
                        <p class="subtitle">Explore our musical catalog</p>
                    </div>

                    <div class="credits">
                        <p class="text-xs text-gray-400">Total in catalog:</p>
                        <p class="font-neon text-xl md:text-2xl text-neon-cyan" x-text="filteredSongs.length"></p>
                        <p class="text-xs text-gray-400 mt-1">songs</p>
                    </div>
                </div>

                <div class="flex">
                    <div class="side-panel hidden lg:flex">
                        <div class="speaker"></div>
                        <div class="neon-bar"></div>
                    </div>

                    <div class="flex-1 p-3 md:p-6">
                        
                        {{-- Music styles --}}
                        <div class="mb-4 md:mb-6 filter-container">
                            <p class="font-neon mb-3 text-center text-sm md:text-base text-neon-yellow">SORT BY MUSIC STYLE:</p>
                            <div class="flex flex-wrap justify-center gap-2 sm:gap-3">
                                <button @click="selectStyle(null)" 
                                    :class="{ 'active': selectedStyle === null }"
                                    class="control-btn text-xs sm:text-sm btn-padding-sm">ALL</button>
                                
                                {{-- Music styles: Buttons from backend --}}
                                @if(isset($allSongs) && $allSongs->isNotEmpty())
                                    @php
                                        $styles = $allSongs->pluck('style')->unique()->sort()->values();
                                    @endphp
                                    @foreach($styles as $style)
                                        <button @click="selectStyle('{{ $style }}')" 
                                            :class="{ 'active': selectedStyle === '{{ $style }}' }"
                                            class="control-btn text-xs sm:text-sm btn-padding-sm">{{ strtoupper($style) }}</button>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Song catalog --}}
                        <div class="catalog">
                            <h3 class="section-title section-title-cyan text-base md:text-lg mb-3">⭐ FULL CATALOG ⭐</h3>
                            
                            {{-- Container with fixed height and scroll --}}
                            <div class="h-96 overflow-y-auto pr-2" style="scrollbar-width: thin; scrollbar-color: rgba(34, 211, 238, 0.5) rgba(17, 24, 39, 0.5);">
                                <template x-if="filteredSongs.length > 0">
                                    <div class="space-y-2">
                                        <template x-for="song in filteredSongs" :key="song.id">
                                            <div class="song-item">
                                                <div class="song-item-inner">
                                                    <div class="flex-1">
                                                        <p class="font-neon text-base text-neon-cyan" x-text="song.title"></p>
                                                        <p class="text-xs text-gray-400">
                                                            <span x-text="song.artist_name"></span> • 
                                                            <span x-text="song.style"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                
                                <template x-if="filteredSongs.length === 0">
                                    <div class="empty-state">
                                        <p class="empty-state-icon">🎵</p>
                                        <p class="font-neon text-lg md:text-xl empty-state-title text-neon-cyan">NO SONGS FOUND</p>
                                        <p class="text-sm md:text-base">No songs found with the selected filter</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Search UNDER CONSTRUCTION --}}
                        <div class="mt-4 md:mt-6 mb-4 md:mb-6 search-container-cyan">
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                <input type="text" 
                                    placeholder="Search by title ...  (UNDER CONSTRUCTION)" 
                                    class="search-input-cyan w-full sm:flex-1">
                                <button class="control-btn w-full sm:w-auto btn-padding-lg">SEARCH</button>
                            </div>
                        </div>

                    </div>

                    <div class="side-panel hidden lg:flex">
                        <div class="speaker"></div>
                        <div class="neon-bar"></div>
                    </div>
                </div>

                <div class="footer-info">
                    <div class="max-w-3xl mx-auto text-center">
                        <p class="font-neon text-sm md:text-base text-neon-yellow mb-1">INSTRUCTION</p>
                        <p class="text-xs md:text-sm text-gray-400">Navigate the catalog, search for your favorite songs and filter by musical style</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function songCatalog() {
        return {
            allSongs: @json($allSongs ?? []),
            filteredSongs: [],
            selectedStyle: null,
            availableStyles: [],
            
            init() {
                // Extract unique styles (from the backend)
                const stylesArray = this.allSongs.map(s => s.style);
                console.log('🎨 All styles (with duplicates):', stylesArray);
                console.log('🎨 Total songs:', this.allSongs.length);
                
                this.availableStyles = [...new Set(stylesArray)].sort();
                console.log('🎨 Unique styles:', this.availableStyles);
                console.log('🎨 Unique styles count:', this.availableStyles.length);
                
                // Show all songs initially
                this.filteredSongs = this.allSongs;
            },
            
            selectStyle(style) {
                this.selectedStyle = style;
                this.filterSongs();
            },
            
            filterSongs() {
                this.filteredSongs = this.selectedStyle === null
                    ? this.allSongs
                    : this.allSongs.filter(s => s.style === this.selectedStyle);
            }
        }
    }
    </script>
</x-app-layout>


