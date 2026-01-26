<x-app-layout>
    <x-slot name="header">
        <h2 class="font-neon text-2xl md:text-3xl text-neon-pink text-shadow-pink">
            ESTILOS MUSICALES
        </h2>
    </x-slot>

    <div class="py-4 md:py-8">
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
                        <h1>CATEGORÍAS</h1>
                        <p class="subtitle">Explora por género musical</p>
                    </div>

                    <div class="info-panel">
                        <p class="text-xs text-gray-400">Estilos disponibles:</p>
                        <p class="font-neon text-xl md:text-2xl text-neon-pink">6</p>
                        <p class="text-xs text-gray-400 mt-1">géneros</p>
                    </div>

                    <div class="credits">
                        <p class="credits-label">CRÉDITOS:</p>
                        <p class="credits-amount">${{ number_format(Auth::user()->money ?? 0, 2) }}</p>
                    </div>
                </div>

                <div class="flex">
                    <div class="side-panel hidden lg:flex">
                        <div class="speaker"></div>
                        <div class="neon-bar"></div>
                    </div>

                    <div class="flex-1 p-3 md:p-6">
                        <div>
                            <h3 class="section-title section-title-pink text-lg md:text-xl mb-4 md:mb-6">★ GÉNEROS MUSICALES ★</h3>
                            
                            <div class="space-y-4 md:space-y-6">
                                <!-- JAZZ -->
                                <div class="category-item category-cyan">
                                    <div class="category-info">
                                        <p class="category-name text-neon-cyan">JAZZ</p>
                                        <p class="category-description">Improvisación y swing</p>
                                    </div>
                                    <div class="category-stats">
                                        <p class="text-xs sm:text-sm text-gray-600">🎵 0 canciones</p>
                                        <p class="text-xs sm:text-sm text-gray-600 category-item-compact">🎤 0 artistas</p>
                                    </div>
                                </div>

                                <!-- ROCK -->
                                <div class="category-item category-red">
                                    <div class="category-info">
                                        <p class="category-name text-neon-red">ROCK</p>
                                        <p class="category-description">Energía y rebeldía</p>
                                    </div>
                                    <div class="category-stats">
                                        <p class="text-xs sm:text-sm text-gray-600">🎵 0 canciones</p>
                                        <p class="text-xs sm:text-sm text-gray-600 category-item-compact">🎤 0 artistas</p>
                                    </div>
                                </div>

                                <!-- BLUES -->
                                <div class="category-item category-purple">
                                    <div class="category-info">
                                        <p class="category-name text-neon-purple">BLUES</p>
                                        <p class="category-description">Sentimiento y alma</p>
                                    </div>
                                    <div class="category-stats">
                                        <p class="text-xs sm:text-sm text-gray-600">🎵 0 canciones</p>
                                        <p class="text-xs sm:text-sm text-gray-600 category-item-compact">🎤 0 artistas</p>
                                    </div>
                                </div>

                                <!-- SOUL -->
                                <div class="category-item category-yellow">
                                    <div class="category-info">
                                        <p class="category-name text-neon-yellow">SOUL</p>
                                        <p class="category-description">Pasión y emoción</p>
                                    </div>
                                    <div class="category-stats">
                                        <p class="text-xs sm:text-sm text-gray-600">🎵 0 canciones</p>
                                        <p class="text-xs sm:text-sm text-gray-600 category-item-compact">🎤 0 artistas</p>
                                    </div>
                                </div>

                                <!-- SWING -->
                                <div class="category-item category-green">
                                    <div class="category-info">
                                        <p class="category-name text-neon-green">SWING</p>
                                        <p class="category-description">Ritmo y baile</p>
                                    </div>
                                    <div class="category-stats">
                                        <p class="text-xs sm:text-sm text-gray-600">🎵 0 canciones</p>
                                        <p class="text-xs sm:text-sm text-gray-600 category-item-compact">🎤 0 artistas</p>
                                    </div>
                                </div>

                                <!-- POP -->
                                <div class="category-item category-pink">
                                    <div class="category-info">
                                        <p class="category-name text-neon-pink">POP</p>
                                        <p class="category-description">Popular y pegajoso</p>
                                    </div>
                                    <div class="category-stats">
                                        <p class="text-xs sm:text-sm text-gray-600">🎵 0 canciones</p>
                                        <p class="text-xs sm:text-sm text-gray-600 category-item-compact">🎤 0 artistas</p>
                                    </div>
                                </div>
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
                        <p class="font-neon text-sm md:text-base text-neon-yellow mb-1">🎨 EXPLORA POR GÉNERO</p>
                        <p class="text-xs md:text-sm text-gray-400">Haz clic en cualquier categoría para ver sus canciones y artistas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

