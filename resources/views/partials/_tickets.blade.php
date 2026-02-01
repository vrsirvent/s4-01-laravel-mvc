{{-- MY TICKETS: User's active tokens --}}
<div class="mt-4 md:mt-6 fichas-container">
    <h3 class="section-title section-title-yellow text-lg md:text-xl mb-3 md:mb-4">🎟️ MY TICKETS</h3>                                                      
    <div class="flex flex-wrap justify-center md:justify-around items-center gap-4 md:gap-6">
        {{-- MOTO 1 --}}
        <div class="ficha-item w-full sm:w-auto">
            <p class="ficha-label text-sm md:text-base text-neon-red">🏍️ MOTO 1</p>
            <p class="ficha-count text-xl md:text-2xl text-neon-red" x-text="userTokens['moto_1'] || 0"></p>
            <p class="ficha-text">tokens</p>
        </div>

        <div class="separator-vertical separator-50 hidden md:block"></div>

        {{-- CAR --}}
        <div class="ficha-item w-full sm:w-auto">
            <p class="ficha-label text-sm md:text-base text-neon-purple">🚗 CAR</p>
            <p class="ficha-count text-xl md:text-2xl text-neon-purple" x-text="userTokens['car'] || 0"></p>
            <p class="ficha-text">tokens</p>
        </div>

        <div class="separator-vertical separator-50 hidden md:block"></div>

        {{-- MOTO 3 --}}
        <div class="ficha-item w-full sm:w-auto">
            <p class="ficha-label text-sm md:text-base text-neon-yellow">🏍️ MOTO 3</p>
            <p class="ficha-count text-xl md:text-2xl text-neon-yellow" x-text="userTokens['moto_3'] || 0"></p>
            <p class="ficha-text">tokens</p>
        </div>

        <div class="separator-vertical separator-50 hidden md:block"></div>

        {{-- MOTO 5 --}}
        <div class="ficha-item w-full sm:w-auto">
            <p class="ficha-label text-sm md:text-base text-neon-green">🏍️ MOTO 5</p>
            <p class="ficha-count text-xl md:text-2xl text-neon-green" x-text="userTokens['moto_5'] || 0"></p>
            <p class="ficha-text">tokens</p>
        </div>
    </div>
</div>


