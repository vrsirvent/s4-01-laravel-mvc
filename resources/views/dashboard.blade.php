<x-app-layout>
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
                        <h1>MI JUKEBOX</h1>
                        <p class="subtitle">Bienvenido, {{ Auth::user()->name }}</p>
                    </div>

                    <div class="info-panel">
                        <p class="text-xs text-gray-400">Selección actual:</p>
                        <p class="font-neon text-sm text-neon-red" id="quantityText">🔴 1 SONG</p>
                        <p class="font-neon text-sm mt-1 text-neon-cyan" id="modeText">🏍️ MOTO (SONGS)</p>
                    </div>

                    <div class="credits">
                        <p class="credits-label">CREDIT:</p>
                        <p class="credits-amount">${{ number_format(Auth::user()->money ?? 0, 2) }}</p>
                    </div>
                </div>

                <div class="flex">
                    <div class="side-panel hidden lg:flex">
                        <div class="speaker"></div>
                        <div class="neon-bar"></div>
                    </div>

                    <div class="flex-1 p-3 md:p-6">
                        <div class="visual-screen mb-4 md:mb-6">
                            <div class="stars"></div>
                            <div class="city"></div>
                            <div class="road">
                                <div class="road-line" id="roadLine"></div>
                            </div>

                            <div class="traffic-box">
                                <div class="traffic-lights">
                                    <div class="traffic-light red active" onclick="selectQuantity(1)">1</div>
                                    <div class="traffic-light yellow" onclick="selectQuantity(3)">3</div>
                                    <div class="traffic-light green" onclick="selectQuantity(5)">5</div>
                                </div>
                                <div class="traffic-pole"></div>
                            </div>

                            <div class="controls">
                                <button class="control-btn" onclick="togglePlay()">▶️ PLAY</button>
                                <button class="control-btn" onclick="pausePlay()">⏸️ PAUSE</button>
                                <button class="control-btn">⏭️ NEXT</button>
                                <button class="control-btn">🔀 SHUFFLE</button>
                            </div>

                            <div class="now-playing">
                                <h3 class="text-base md:text-lg now-playing-title">♪ Playing... ♪</h3>
                                <p class="text-sm md:text-base now-playing-subtitle">Select your music</p>
                                <p class="text-xs now-playing-hint">Use the traffic light to select quantity</p>
                            </div>

                            <div class="vehicles">
                                <div class="vehicle moto active" id="vehicleMoto" onclick="selectMode('moto')">
                                    <div class="moto-body"></div>
                                    <div class="moto-wheel back"></div>
                                    <div class="moto-wheel front"></div>
                                    <div class="moto-light" id="motoLight"></div>
                                </div>

                                <div class="vehicle car" id="vehicleCar" onclick="selectMode('car')">
                                    <div class="car-roof"></div>
                                    <div class="car-body"></div>
                                    <div class="car-wheel back"></div>
                                    <div class="car-wheel front"></div>
                                    <div class="car-headlight" id="carLight"></div>
                                    <div class="car-taillight"></div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            <div class="catalog">
                                <h3 class="section-title section-title-cyan text-lg md:text-xl mb-3 md:mb-4">🎵 CATALOG</h3>
                                
                                <div class="empty-state">
                                    <p class="empty-state-icon">🎵</p>
                                    <p class="font-neon text-lg md:text-xl empty-state-title text-neon-cyan">COMING SOON</p>
                                    <p class="text-xs md:text-sm">The catalog will be available soon</p>
                                </div>
                            </div>

                            <div class="favorites">
                                <h3 class="section-title section-title-pink text-lg md:text-xl mb-3 md:mb-4">💖 FAVORITES</h3>
                                
                                <div class="empty-state">
                                    <p class="empty-state-icon">💖</p>
                                    <p class="font-neon text-lg md:text-xl empty-state-title text-neon-pink">NO FAVORITES</p>
                                    <p class="text-xs md:text-sm">You don't have any favorite songs yet</p>
                                </div>

                                <h4 class="font-neon text-base md:text-lg mb-2 md:mb-3 text-neon-cyan">📖 HOW TO USE</h4>
                                <ol class="list-decimal list-inside text-xs md:text-sm instructions-list">
                                    <li>Use the traffic light to select quantity (1, 3 or 5 songs)</li>
                                    <li>Choose the mode: Moto for individual songs or Car for full artist</li>
                                    <li>Select songs from the catalog</li>
                                    <li>Play your selection with the controls</li>
                                </ol>
                            </div>
                        </div>

                        <!-- BUSCADOR -->
                        <div class="mt-4 md:mt-6 mb-4 md:mb-6 search-container-green">
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                <input type="text" placeholder="🔍 Search songs..." class="search-input-green w-full sm:flex-1">
                                <button class="control-btn w-full sm:w-auto btn-padding-lg">SEARCH</button>
                            </div>
                        </div>

                        <div class="mt-4 md:mt-6 fichas-container">
                            <h3 class="section-title section-title-yellow text-lg md:text-xl mb-3 md:mb-4">🎟️ MY TICKETS</h3>
                            
                            <div class="flex flex-wrap justify-center md:justify-around items-center gap-4 md:gap-6">
                                <div class="ficha-item w-full sm:w-auto">
                                    <p class="ficha-label text-sm md:text-base text-neon-red">🏍️ MOTO 1</p>
                                    <p class="ficha-count text-xl md:text-2xl text-neon-red">0</p>
                                    <p class="ficha-text">tokens</p>
                                </div>

                                <div class="separator-vertical separator-50 hidden md:block"></div>

                                <div class="ficha-item w-full sm:w-auto">
                                    <p class="ficha-label text-sm md:text-base text-neon-yellow">🏍️ MOTO 3</p>
                                    <p class="ficha-count text-xl md:text-2xl text-neon-yellow">0</p>
                                    <p class="ficha-text">tokens</p>
                                </div>

                                <div class="separator-vertical separator-50 hidden md:block"></div>

                                <div class="ficha-item w-full sm:w-auto">
                                    <p class="ficha-label text-sm md:text-base text-neon-green">🏍️ MOTO 5</p>
                                    <p class="ficha-count text-xl md:text-2xl text-neon-green">0</p>
                                    <p class="ficha-text">tokens</p>
                                </div>

                                <div class="separator-vertical separator-50 hidden md:block"></div>

                                <div class="ficha-item w-full sm:w-auto">
                                    <p class="ficha-label text-sm md:text-base text-neon-purple">🚗 CAR</p>
                                    <p class="ficha-count text-xl md:text-2xl text-neon-purple">0</p>
                                    <p class="ficha-text">tokens</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 md:mt-6 comprar-container">
                            <h3 class="section-title section-title-cyan text-lg md:text-xl mb-3 md:mb-4">🎟️ BUY TOKENS</h3>
                            
                            <div class="flex flex-wrap justify-center md:justify-around items-center gap-4 md:gap-6">
                                <div class="compra-item w-full sm:w-auto">
                                    <p class="compra-label text-sm md:text-base text-neon-red">🏍️ MOTO 1</p>
                                    <p class="compra-description">1 song</p>
                                    <p class="compra-price text-lg md:text-xl">€ 100.00</p>
                                    <button class="control-btn text-xs sm:text-sm w-full sm:w-auto btn-padding-md">BUY TOKENS</button>
                                </div>

                                <div class="separator-vertical separator-vertical-cyan separator-70 hidden md:block"></div>

                                <div class="compra-item w-full sm:w-auto">
                                    <p class="compra-label text-sm md:text-base text-neon-yellow">🏍️ MOTO 3</p>
                                    <p class="compra-description">3 songs</p>
                                    <p class="compra-price text-lg md:text-xl">€ 250.00</p>
                                    <button class="control-btn text-xs sm:text-sm w-full sm:w-auto btn-padding-md">BUY TOKENS</button>
                                </div>

                                <div class="separator-vertical separator-vertical-cyan separator-70 hidden md:block"></div>

                                <div class="compra-item w-full sm:w-auto">
                                    <p class="compra-label text-sm md:text-base text-neon-green">🏍️ MOTO 5</p>
                                    <p class="compra-description">5 songs</p>
                                    <p class="compra-price text-lg md:text-xl">€ 400.00</p>
                                    <button class="control-btn text-xs sm:text-sm w-full sm:w-auto btn-padding-md">BUY TOKENS</button>
                                </div>

                                <div class="separator-vertical separator-vertical-cyan separator-70 hidden md:block"></div>

                                <div class="compra-item w-full sm:w-auto">
                                    <p class="compra-label text-sm md:text-base text-neon-purple">🚗 CAR</p>
                                    <p class="compra-description">Complete artist</p>
                                    <p class="compra-price text-lg md:text-xl">€ 500.00</p>
                                    <button class="control-btn text-xs sm:text-sm w-full sm:w-auto btn-padding-md">BUY TOKENS</button>
                                </div>
                            </div>
                            
                            <div class="mt-3 md:mt-4 info-box text-center">
                                <p class="text-xs md:text-sm text-gray-light">
                                    💡 Buy tokens with your credits to play music on the jukebox
                                </p>
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
                        <p class="font-neon text-sm md:text-base text-neon-yellow mb-1">💡 INSTRUCTION</p>
                        <p class="text-xs md:text-sm text-gray-400">Navigate the catalog, find your favorite songs and mark them with ⭐</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedQuantity = 1;
        let selectedMode = 'moto';
        let isPlaying = false;

        function selectQuantity(quantity) {
            selectedQuantity = quantity;
            document.querySelectorAll('.traffic-light').forEach(light => light.classList.remove('active'));
            
            if (quantity === 1) {
                document.querySelector('.traffic-light.red').classList.add('active');
                document.getElementById('quantityText').textContent = '🔴 1 SONGS';
            } else if (quantity === 3) {
                document.querySelector('.traffic-light.yellow').classList.add('active');
                document.getElementById('quantityText').textContent = '🟡 3 SONGS';
            } else if (quantity === 5) {
                document.querySelector('.traffic-light.green').classList.add('active');
                document.getElementById('quantityText').textContent = '🟢 5 SONGS';
            }
        }

        function selectMode(mode) {
            selectedMode = mode;
            document.querySelectorAll('.vehicle').forEach(v => v.classList.remove('active'));
            
            if (mode === 'moto') {
                document.getElementById('vehicleMoto').classList.add('active');
                document.getElementById('modeText').textContent = '🏍️ MOTO (SONGS)';
            } else {
                document.getElementById('vehicleCar').classList.add('active');
                document.getElementById('modeText').textContent = '🚗 CAR (COMPLETE ARTIST)';
            }
        }

        function togglePlay() {
            isPlaying = !isPlaying;
            const roadLine = document.getElementById('roadLine');
            const motoLight = document.getElementById('motoLight');
            const carLight = document.getElementById('carLight');
            
            if (isPlaying) {
                roadLine.classList.add('moving');
                motoLight.classList.add('on');
                carLight.classList.add('on');
            } else {
                roadLine.classList.remove('moving');
                motoLight.classList.remove('on');
                carLight.classList.remove('on');
            }
        }

        function pausePlay() {
            isPlaying = false;
            const roadLine = document.getElementById('roadLine');
            const motoLight = document.getElementById('motoLight');
            const carLight = document.getElementById('carLight');
            
            roadLine.classList.remove('moving');
            motoLight.classList.remove('on');
            carLight.classList.remove('on');
        }
    </script>
</x-app-layout>

