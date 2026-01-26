<x-app-layout>
    <x-slot name="header">
        <h2 class="font-neon text-2xl md:text-3xl text-neon-purple text-shadow-purple">
            ARTISTAS
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
                        <h1>ARTISTAS</h1>
                        <p class="subtitle">Descubre a nuestros músicos</p>
                    </div>

                    <div class="info-panel">
                        <p class="text-xs text-gray-400">Total de artistas:</p>
                        <p class="font-neon text-xl md:text-2xl text-neon-purple">0</p>
                        <p class="text-xs text-gray-400 mt-1">en catálogo</p>
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
                        <div class="mt-4 md:mt-6 mb-4 md:mb-6 search-container-purple">
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                <input type="text" placeholder="🔍 Buscar artista..." class="search-input-purple w-full sm:flex-1">
                                <button class="control-btn w-full sm:w-auto btn-padding-lg">BUSCAR</button>
                            </div>
                        </div>

                        <div>
                            <h3 class="section-title section-title-purple text-lg md:text-xl mb-4 md:mb-6">★ NUESTROS ARTISTAS ★</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                                <div class="artist-card-empty">
                                    <div class="empty-state-icon">🎤</div>
                                    <p class="font-neon mb-2 text-lg md:text-xl text-neon-purple">SIN ARTISTAS</p>
                                    <p class="text-xs md:text-sm text-gray-400 mb-4">Los artistas estarán disponibles en la Parte 2</p>
                                    <div class="text-xs md:text-sm text-gray-600">
                                        <p>💿 0 canciones</p>
                                        <p class="mt-1">📢 0 reproducciones</p>
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
                        <p class="font-neon text-sm md:text-base text-neon-yellow mb-1">🚗 MODO COCHE</p>
                        <p class="text-xs md:text-sm text-gray-400">Usa el modo COCHE para reproducir todas las canciones de un artista</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

