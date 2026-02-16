<x-app-layout>
    <div class="py-4 md:py-8">
        <div class="container mx-auto px-2 md:px-4">
            <div class="jukebox max-w-7xl mx-auto">
                
                <!-- Jukebox Top -->
                <div class="jukebox-top">
                    <div class="top-arch"></div>
                    <div class="top-lights">
                        <x-category-carousel />
                    </div>
                    <div class="jukebox-title">
                        <h1>ARTISTS CATALOG</h1>
                        <p class="subtitle">Discover our musicians</p>
                    </div>

                    <div class="credits">
                        <p class="text-xs text-gray-400">Total artists:</p>
                        <p class="font-neon text-xl md:text-2xl text-neon-purple">{{ $allArtists->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">in catalog</p>
                    </div>
                </div>
                
                <!-- Main -->
                <div class="flex">
                    <!-- Left Speaker -->
                    <div class="side-panel hidden lg:flex">
                        <div class="speaker"></div>
                        <div class="neon-bar"></div>
                    </div>

                    <!-- Center -->
                    <div class="flex-1 p-3 md:p-6">
                        <h3 class="section-title section-title-purple text-lg md:text-xl mb-4 md:mb-6">
                            ⭐ OUR ARTISTS ⭐
                        </h3>
                        
                        {{-- Music style filter --}}
                        <div class="mb-4 md:mb-6 filter-container">
                            <p class="font-neon mb-3 text-center text-sm md:text-base text-neon-yellow">FILTER BY MUSIC STYLE:</p>
                            <div class="flex flex-wrap justify-center gap-2 sm:gap-3">
                                {{-- ALL button --}}
                                <a href="{{ route('artist', ['search' => request('search')]) }}" 
                                   class="control-btn text-xs sm:text-sm btn-padding-sm {{ !request('style') ? 'active' : '' }}">
                                    ALL
                                </a>
                                
                                {{-- Dynamic style buttons --}}
                                @if(isset($allArtists) && $allArtists->isNotEmpty())
                                    @php
                                        $allStyles = $allArtists->flatMap(function($artist) {
                                            return $artist['styles'] ?? [];
                                        })->unique()->sort()->values();
                                    @endphp
                                    @foreach($allStyles as $style)
                                        <a href="{{ route('artist', ['style' => $style, 'search' => request('search')]) }}" 
                                           class="control-btn text-xs sm:text-sm btn-padding-sm {{ request('style') == $style ? 'active' : '' }}">
                                            {{ strtoupper($style) }}
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Artists catalog --}}
                        <div class="catalog artists-view">
                            <div class="h-96 overflow-scroll">
                                @if($allArtists->count() > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                                        @foreach($allArtists as $artist)
                                            <div class="artist-card pointer-events-none">
                                                <div class="artist-card-header">
                                                    <div class="artist-avatar">🎤</div>
                                                    <div class="flex-1">
                                                        <p class="font-neon text-lg md:text-xl text-neon-purple">{{ $artist['name'] }}</p>
                                                        <p class="text-xs text-gray-400">{{ $artist['styles_text'] }}</p>
                                                    </div>
                                                </div>
                                                
                                                <p class="text-sm text-gray-300 mb-4 artist-description">
                                                    {{ $artist['description'] ?? 'No description available' }}
                                                </p>
                                                
                                                <div class="artist-stats">
                                                    <div class="artist-stat">
                                                        <span class="artist-stat-icon">💿</span>
                                                        <span class="artist-stat-value">{{ $artist['songs_count'] }}</span>
                                                        <span class="artist-stat-label">songs</span>
                                                    </div>
                                                    <div class="artist-stat">
                                                        <span class="artist-stat-icon">🔢</span>
                                                        <span class="artist-stat-value">{{ $artist['total_plays'] }}</span>
                                                        <span class="artist-stat-label">plays</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="artist-card-empty">
                                        <div class="empty-state-icon">🎤</div>
                                        <p class="font-neon mb-2 text-lg md:text-xl text-neon-purple">NO ARTISTS FOUND</p>
                                        <p class="text-xs md:text-sm text-gray-400 mb-4">No artists found with the selected filter</p>
                                        <div class="text-xs md:text-sm text-gray-600">
                                            <p>💿 0 songs</p>
                                            <p class="mt-1">🔢 0 plays</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Artist search --}}
                        <div class="mt-4 md:mt-6 mb-4 md:mb-6 search-container-purple">
                            <form method="GET" action="{{ route('artist') }}">
                                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                    @if(request('search') || request('style'))
                                        <a href="{{ route('artist') }}" class="control-btn w-full sm:w-auto btn-padding-lg bg-gray-600">
                                            ❌ CLEAR
                                        </a>
                                    @endif
                                    <input 
                                        type="text" 
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Search artist by name..." 
                                        class="search-input-purple w-full sm:flex-1"
                                    >
                                    <button type="submit" class="control-btn w-full sm:w-auto btn-padding-lg">
                                        🔍 SEARCH
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="side-panel hidden lg:flex">
                        <div class="speaker"></div>
                        <div class="neon-bar"></div>
                    </div>
                </div>

                <div class="footer-info">
                    <div class="max-w-3xl mx-auto text-center">
                        <p class="font-neon text-sm md:text-base text-neon-yellow mb-1">CAR MODE</p>
                        <p class="text-xs md:text-sm text-gray-400">Use CAR mode to play all songs from an artist</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


