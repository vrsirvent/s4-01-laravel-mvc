<x-app-layout>
    <div class="py-4 md:py-8">
        <div class="container mx-auto px-2 md:px-4">
            <div class="jukebox max-w-7xl mx-auto">
                <!-- Jukebox Top -->
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
                        <p class="subtitle">Sorry, the page you're looking for doesn't exist.</p>
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
                    <div class="flex-1 p-3 md:p-6 flex flex-col items-center justify-center" style="min-height: 420px;">
                        <h3 class="section-title text-lg md:text-xl mb-6 md:mb-8" style="color: var(--neon-red); text-shadow: 0 0 10px var(--neon-red);">
                            ⭐ PAGE NOT FOUND ⭐
                        </h3>
                        <div class="category-item category-red pointer-events-none" style="max-width: 560px; width: 100%; justify-content: center; text-align: center; flex-direction: column; gap: 16px;">
                            <p class="font-neon text-neon-red" style="font-size: 4rem; line-height: 1; text-shadow: 0 0 20px var(--neon-red), 0 0 40px var(--neon-red), 0 0 80px var(--neon-red); animation: neon-flicker 2s infinite;">ERROR 404</p>
                            <div style="width: 80px; height: 2px; background: linear-gradient(to right, transparent, var(--neon-red), transparent); margin: 0 auto;"></div>
                            <div>
                                <p class="category-name text-neon-magenta" style="font-size: 1.25rem; color: var(--neon-magenta); text-shadow: 0 0 10px var(--neon-magenta);">The page you're looking for has been removed, renamed, or was never here.</p>
                            </div>
                            <p style="font-size: 3rem; filter: drop-shadow(0 0 8px var(--neon-red));">💿</p>
                        </div>
                        <a href="{{ route('dashboard') }}" class="auth-button-danger mt-8 inline-block" style="pointer-events: auto;">
                            ⏮ BACK TO HOME
                        </a>
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
                        <p class="font-neon text-sm md:text-base text-neon-yellow mb-1">✨ DON'T WORRY</p>
                        <p class="text-xs md:text-sm text-gray-400">Use the navigation above to find what you're looking for</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


