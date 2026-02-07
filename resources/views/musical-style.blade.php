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
                        <h1>MUSICAL STYLES</h1>
                        <p class="subtitle">Browse by music genre</p>
                    </div>
                    <div class="credits">
                        <p class="text-xs text-gray-400">Available styles: </p>
                        <p class="font-neon text-xl md:text-2xl text-neon-pink">{{ $allStyles->count() }}</p>
                        <p class="text-xs text-gray-400 mt-1">genres</p>
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
                        <h3 class="section-title section-title-pink text-lg md:text-xl mb-4 md:mb-6">
                            ⭐ OUR MUSIC ⭐
                        </h3>
                        
                        <!-- Styles catalog -->
                        <div class="catalog" style="border-color: var(--neon-pink);">
                            <div class="h-96">
                                @if($allStyles->count() > 0)
                                    <div class="space-y-4 md:space-y-6">
                                        @php
                                            $categoryColors = ['cyan', 'red', 'purple', 'yellow', 'green', 'pink'];
                                            $colorIndex = 0;
                                        @endphp

                                        @foreach($allStyles as $style)
                                            @php
                                                $textColor = $categoryColors[$colorIndex % count($categoryColors)];
                                                $colorIndex++;
                                            @endphp

                                            <div class="category-item category-pink pointer-events-none">
                                                <div class="category-info">
                                                    <p class="category-name text-neon-{{ $textColor }}">{{ strtoupper($style['name']) }}</p>
                                                    <p class="category-description">{{ $style['description'] }}</p>
                                                </div>
                                                <div class="category-stats">
                                                    <p class="text-xs sm:text-sm text-white-600">🎵 {{ $style['songs_count'] }} songs</p>
                                                    <p class="text-xs sm:text-sm text-white-600 category-item-compact">🎤 {{ $style['artists_count'] }} artists</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- Empty -->
                                    <div class="category-item category-pink">
                                        <div class="category-info">
                                            <p class="category-name text-neon-cyan">NO STYLES</p>
                                            <p class="category-description text-white-600">No musical genres were found</p>
                                        </div>
                                        <div class="category-stats">
                                            <p class="text-xs sm:text-sm text-white-600">🎵 0 songs</p>
                                            <p class="text-xs sm:text-sm text-white-600 category-item-compact">🎤 0 artists</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
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
                        <p class="font-neon text-sm md:text-base text-neon-yellow mb-1">EXPLORE BY GENRE</p>
                        <p class="text-xs md:text-sm text-gray-400">Click on any category to see its songs and artists</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>


