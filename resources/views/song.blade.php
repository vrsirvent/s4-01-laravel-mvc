<x-app-layout>
    <x-slot name="header">
        <h2 class="font-neon text-2xl md:text-3xl text-neon-cyan text-shadow-cyan">
            CATÁLOGO DE CANCIONES
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
                        <h1>CANCIONES</h1>
                        <p class="subtitle">Explora nuestro catálogo musical</p>
                    </div>

                    <div class="info-panel">
                        <p class="text-xs text-gray-400">Total en catálogo:</p>
                        <p class="font-neon text-xl md:text-2xl text-neon-cyan">0</p>
                        <p class="text-xs text-gray-400 mt-1">canciones</p>
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
                        <div class="mt-4 md:mt-6 mb-4 md:mb-6 search-container-cyan">
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                <input type="text" placeholder="🔍 Buscar por título o artista..." class="search-input-cyan w-full sm:flex-1">
                                <button class="control-btn w-full sm:w-auto btn-padding-lg">BUSCAR</button>
                            </div>
                        </div>

                        <div class="mb-4 md:mb-6 filter-container">
                            <p class="font-neon mb-3 text-center text-sm md:text-base text-neon-yellow">FILTRAR POR ESTILO:</p>
                            <div class="flex flex-wrap justify-center gap-2 sm:gap-3">
                                <button class="control-btn text-xs sm:text-sm btn-padding-sm">TODOS</button>
                                <button class="control-btn text-xs sm:text-sm btn-padding-sm">JAZZ</button>
                                <button class="control-btn text-xs sm:text-sm btn-padding-sm">ROCK</button>
                                <button class="control-btn text-xs sm:text-sm btn-padding-sm">BLUES</button>
                                <button class="control-btn text-xs sm:text-sm btn-padding-sm">SOUL</button>
                                <button class="control-btn text-xs sm:text-sm btn-padding-sm">SWING</button>
                                <button class="control-btn text-xs sm:text-sm btn-padding-sm">POP</button>
                            </div>
                        </div>

                        <div class="catalog">
                            <h3 class="section-title section-title-cyan text-base md:text-lg mb-3">★ CATÁLOGO COMPLETO ★</h3>
                            <div class="max-h-96 overflow-y-auto">
                                <div class="empty-state">
                                    <p class="empty-state-icon">🎵</p>
                                    <p class="font-neon text-lg md:text-xl empty-state-title text-neon-cyan">CATÁLOGO VACÍO</p>
                                    <p class="text-sm md:text-base">Las canciones estarán disponibles en la Parte 2 del proyecto</p>
                                    <p class="text-xs text-gray-500 mt-4">Se mostrarán aquí todas las canciones con código, artista, estilo y reproducciones</p>
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
                        <p class="font-neon text-sm md:text-base text-neon-yellow mb-1">💡 INSTRUCCIÓN</p>
                        <p class="text-xs md:text-sm text-gray-400">Navega por el catálogo, busca tus canciones favoritas y márcalas con ⭐</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


