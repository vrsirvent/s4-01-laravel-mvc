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
                        <h1>SONGS CATALOG</h1>
                        <p class="subtitle">Explore our musical catalog</p>
                    </div>

                    <div class="credits">
                        <p class="text-xs text-gray-400">Total in catalog:</p>
                        <p class="font-neon text-xl md:text-2xl text-neon-cyan">{{ $allSongs->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">songs</p>
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
                        <h3 class="section-title section-title-cyan text-base md:text-lg mb-3">
                            ⭐ FULL CATALOG ⭐
                        </h3>

                        {{-- Music styles --}}
                        <div class="mb-4 md:mb-6 filter-container">
                            <p class="font-neon mb-3 text-center text-sm md:text-base text-neon-yellow">SORT BY MUSIC STYLE:</p>
                            <div class="flex flex-wrap justify-center gap-2 sm:gap-3">
                                {{-- ALL button --}}
                                <a href="{{ route('song', ['search' => request('search')]) }}" 
                                   class="control-btn text-xs sm:text-sm btn-padding-sm {{ !request('style') ? 'active' : '' }}">
                                    ALL
                                </a>
                                
                                {{-- Music styles: Buttons from backend --}}
                                @if(isset($allSongs) && $allSongs->isNotEmpty())
                                    @php
                                        $styles = $allSongs->pluck('style')->unique()->sort()->values();
                                    @endphp
                                    @foreach($styles as $style)
                                        <a href="{{ route('song', ['style' => $style, 'search' => request('search')]) }}" 
                                           class="control-btn text-xs sm:text-sm btn-padding-sm {{ request('style') == $style ? 'active' : '' }}">
                                            {{ strtoupper($style) }}
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Song catalog --}}
                        <div class="catalog" style="border-color: var(--neon-cyan);">    
                            <div class="h-96">
                                @if($allSongs->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($allSongs as $song)
                                            <div class="song-item pointer-events-none">
                                                <div class="song-item-inner">
                                                    <div class="flex-1 search-input-cyan">
                                                        <p class="font-neon text-base text-neon-cyan">{{ $song['title'] }}</p>
                                                        <p class="text-xs text-gray-400">
                                                            {{ $song['artist_name'] }} • {{ $song['style'] }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- Empty state -->
                                    <div class="empty-state">
                                        <p class="empty-state-icon">🎵</p>
                                        <p class="font-neon text-lg md:text-xl empty-state-title text-neon-cyan">NO SONGS FOUND</p>
                                        <p class="text-sm md:text-base">No songs found with the selected filter</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Search --}}
                        <div class="mt-4 md:mt-6 mb-4 md:mb-6 search-container-cyan">
                            <form method="GET" action="{{ route('song') }}">
                                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                    @if(request('search') || request('style'))
                                        <a href="{{ route('song') }}" class="control-btn w-full sm:w-auto btn-padding-lg bg-gray-600">
                                            ❌ CLEAR
                                        </a>
                                    @endif
                                    <input 
                                        type="text" 
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Search by title or artist..." 
                                        class="search-input-cyan w-full sm:flex-1"
                                    >
                                    <button type="submit" class="control-btn w-full sm:w-auto btn-padding-lg">🔍 SEARCH</button>
                                </div>
                            </form>
                        </div>

                    </div>

                    <!-- Right Speaker -->
                    <div class="side-panel hidden lg:flex">
                        <div class="speaker"></div>
                        <div class="neon-bar"></div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="footer-info">
                    <div class="max-w-3xl mx-auto text-center">
                        <p class="font-neon text-sm md:text-base text-neon-yellow mb-1">INSTRUCTION</p>
                        <p class="text-xs md:text-sm text-gray-400">Navigate the catalog, search for your favorite songs and filter by musical style</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


