<x-app-layout>
<div class="py-4 md:py-8">
    <div class="container mx-auto px-2 md:px-4">

        {{-- Success/error messages --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-900 border border-green-500 text-green-100 rounded-lg">
                <p class="font-neon text-center">✅ {{ session('success') }}</p>
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-900 border border-red-500 text-red-100 rounded-lg">
                <p class="font-neon text-center">❌ {{ session('error') }}</p>
            </div>
        @endif
        
        <div class="jukebox max-w-7xl mx-auto" x-data="jukeboxApp()" x-init="init()">
                
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
                        <h1>CITY JUKEBOX</h1>
                        <p class="subtitle">Welcome, {{ Auth::user()->name }}</p>
                    </div>

                    <div class="info-panel">
                        <p class="text-xs text-gray-400">Current selection:</p>
                        <p class="font-neon text-sm text-gray-500" id="quantityText">No selection</p>
                        <p class="font-neon text-sm mt-1 text-gray-500" id="modeText">No mode</p>
                    </div>

                    <div class="credits">
                        <p class="credits-label">CREDIT:</p>
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
                        <p class="text-xs md:text-sm text-gray-400">Navigate the catalog, find your favorite songs and mark them with</p>
                        <h4 class="font-neon text-base md:text-lg mb-2 md:mb-3 text-neon-cyan mt-4">HOW TO USE</h4>
                        <ol class="list-decimal list-inside text-xs md:text-sm instructions-list">
                            <li>- Choose the mode: Motorcycle for individual songs or Car for the entire artist</li>
                            <li>- Use the traffic light to select the quantity (1, 3, or 5 songs)</li>
                            <li>- Select songs from the catalog or favorites</li>
                            <li>- Play your selection with the controls</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


