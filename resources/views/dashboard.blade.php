<x-app-layout>
<div class="py-4 md:py-8">
    <div class="container mx-auto px-2 md:px-4">
        
        {{-- Success/error messages --}}
        <x-success-error-message />        
        
        <div class="jukebox max-w-7xl mx-auto" x-data="jukeboxApp()" x-init="init()">
                
                <div class="jukebox-top">
                    <div class="top-arch"></div>
                    <div class="top-lights">
                        <x-category-carousel />
                    </div>

                    <div class="jukebox-title">
                        <h1>CITY JUKEBOX</h1>
                        <p class="subtitle">Welcome, {{ Auth::user()->name }}</p>
                    </div>

                    <div class="info-panel">
                        <p class="text-xs text-gray-400">Current selection:</p>
                        <p class="font-neon text-sm text-gray-500" id="quantityText">No selection</p>
                        <p class="font-neon text-sm mt-1 text-gray-500" id="modeText">No mode</p>
                    </div>

                    <div class="credits">
                        <p class="credits-label">BALANCE:</p>
                        <p class="credits-amount">€ {{ number_format($userMoney, 2) }}</p>
                    </div>
                </div>

                <div class="flex">
                    <div class="side-panel hidden lg:flex">
                        <div class="speaker"></div>
                        <div class="neon-bar"></div>
                    </div>

                    <div class="flex-1 p-3 md:p-6">
                        {{-- Visual player + Alpine script --}}
                        @include('partials._player')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            {{-- Songs and artists catalog --}}
                            @include('partials._catalog')
                            {{-- Favorites --}}
                            @include('partials._favorites')
                        </div>

                        {{-- Search --}}
                        @include('partials._search')
                        {{-- User's active tokens --}}
                        @include('partials._tickets')
                        {{-- Buy tokens --}}
                        @include('partials._buy-tokens')
                    </div>

                    <div class="side-panel hidden lg:flex">
                        <div class="speaker"></div>
                        <div class="neon-bar"></div>
                    </div>
                </div>
                <!-- Footer -->
                <div class="footer-info">
                    <div class="max-w-3xl mx-auto text-center">
                        <p class="font-neon text-sm md:text-base text-neon-yellow mb-1">INSTRUCTION</p>
                        <p class="text-xs md:text-sm text-gray-400">Browse the catalog, find your favorite songs, and mark them with a star</p>
                        <h4 class="font-neon text-base md:text-lg mb-2 md:mb-3 text-neon-green mt-4">HOW TO USE</h4>
                        <ol class="text-xs md:text-sm text-gray-400">
                            <li>1.- Buy tokens with your available balance</li> 
                            <li>2.- Choose the mode: Motorcycle for individual songs or Car for the entire artist</li>
                            <li>3.- Use the traffic light to select the quantity (1, 3, or 5 songs)</li>
                            <li>4.- Select songs from the catalog</li>
                            <li>5.- Play your selection with the controls</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


