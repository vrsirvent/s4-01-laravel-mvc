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
                        <h1>MI JUKEBOX</h1>
                        <p class="subtitle">Bienvenido, {{ Auth::user()->name }}</p>
                    </div>

                    <div class="info-panel">
                        <p class="text-xs text-gray-400">Selección actual:</p>
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
                        <div class="visual-screen mb-4 md:mb-6">
                            <div class="stars"></div>
                            <div class="city"></div>
                            <div class="road">
                                <div class="road-line" id="roadLine"></div>
                            </div>

                            <div class="traffic-box">
                                <div class="traffic-lights">
                                    <div class="traffic-light red" 
                                        :class="{ 'disabled': selectedMode !== 'moto' }"
                                        @click="selectedMode === 'moto' ? selectQuantity(1) : null">1</div>
                                    <div class="traffic-light yellow" 
                                        :class="{ 'disabled': selectedMode !== 'moto' }"
                                        @click="selectedMode === 'moto' ? selectQuantity(3) : null">3</div>
                                    <div class="traffic-light green" 
                                        :class="{ 'disabled': selectedMode !== 'moto' }"
                                        @click="selectedMode === 'moto' ? selectQuantity(5) : null">5</div>
                                </div>
                                <div class="traffic-pole"></div>
                            </div>

                            <div class="controls">
                                <button class="control-btn" @click="togglePlay()">▶️ PLAY</button>
                                <button class="control-btn" @click="pausePlay()">⏸️ PAUSE</button>
                                <button class="control-btn" @click="playNext()" :disabled="!isPlaying">⏭️ NEXT</button>
                                <!-- <button class="control-btn">🔀 SHUFFLE</button> -->
                            </div>

                            <div class="now-playing">
                                <h3 class="text-base md:text-lg now-playing-title">♪ Playing... ♪</h3>
                                <p class="text-sm md:text-base now-playing-subtitle">Select your music</p>
                                <p class="text-xs now-playing-hint">Use the traffic light to select quantity</p>
                            </div>

                            <div class="vehicles">
                                <div class="vehicle moto" id="vehicleMoto" @click="selectMode('moto')">
                                    <div class="moto-body"></div>
                                    <div class="moto-wheel back"></div>
                                    <div class="moto-wheel front"></div>
                                    <div class="moto-light" id="motoLight"></div>
                                </div>

                                <div class="vehicle car" id="vehicleCar" @click="selectMode('car')">
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
                                
                                {{-- MOTO: see songs --}}
                                <div x-show="selectedMode === 'moto'" x-cloak>
                                    <div x-show="availableSongs.length > 0">
                                        <div class="space-y-2">
                                            <template x-for="song in availableSongs" :key="song.id">
                                                <div class="song-item" 
                                                    :class="{ 'selected': isSongSelected(song.id) }">
                                                    <div class="song-item-inner"
                                                        :class="{ 'bg-gray-700': isSongSelected(song.id) }">
                                                        <div class="flex-1 song-selection-area"
                                                            :class="{ 'disabled': !selectedQuantity }"
                                                            @click="selectedQuantity ? toggleSongSelection(song.id) : null">
                                                            <p class="font-neon text-base text-neon-cyan" x-text="song.title"></p>
                                                            <p class="text-xs text-gray-400">
                                                                <span x-text="song.artist_name"></span> • 
                                                                <span x-text="song.style"></span>
                                                            </p>
                                                        </div>
                                                        
                                                        {{-- Favorite button - SIEMPRE ACTIVO --}}
                                                        <button 
                                                            @click.stop="addFavorite(song.id)"
                                                            :disabled="isFavorite(song.id)"
                                                            class="favorite-btn ml-3"
                                                            :class="{ 'active': isFavorite(song.id) }"
                                                            title="Add to favorites">
                                                            <span x-text="isFavorite(song.id) ? '⭐' : '☆'"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- CAR: see artists --}}
                                <div x-show="selectedMode === 'car'" x-cloak>
                                    <div x-show="availableArtists.length > 0">
                                        <div class="space-y-2">
                                            <template x-for="artist in availableArtists" :key="artist.id">
                                                <div class="artist-item"
                                                    :class="{ 'selected': selectedArtist === artist.id }"
                                                    @click.stop="selectArtist(artist.id)">
                                                    <div class="artist-item-inner"
                                                        :class="{ 'bg-gray-700': selectedArtist === artist.id }">
                                                        <div class="flex-1">
                                                            <p class="font-neon text-base text-neon-purple" x-text="artist.name"></p>
                                                            <p class="text-xs text-gray-400">
                                                                <span x-text="artist.songs_count"></span> songs
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Empty (when no mode is selected yet) --}}
                                <div x-show="!selectedMode" x-cloak>
                                    <div class="empty-state">
                                        <p class="empty-state-icon">🎵</p>
                                        <p class="font-neon text-lg md:text-xl empty-state-title text-neon-cyan">SELECT MODE</p>
                                        <p class="text-xs md:text-sm">Choose MOTO or CAR to see the catalog</p>
                                    </div>
                                </div>
                            </div> 
                            <div class="favorites">
                                <h3 class="section-title section-title-pink text-lg md:text-xl mb-3 md:mb-4">💖 FAVORITES</h3>
                                
                                {{-- If have favorites --}}
                                <template x-if="favoriteSongs.length > 0">
                                    <div class="space-y-2">
                                        <template x-for="song in favoriteSongs" :key="'fav-' + song.id">
                                            <div class="favorite-song-item">
                                                <div class="favorite-song-item-inner">
                                                    <div class="flex-1">
                                                        <p class="font-neon text-base text-neon-pink" x-text="song.title"></p>
                                                        <p class="text-xs text-gray-400">
                                                            <span x-text="song.artist_name"></span> • 
                                                            <span x-text="song.style"></span>
                                                        </p>
                                                    </div>
                                                    
                                                    {{-- Button to remove from favorites --}}
                                                    <button 
                                                        @click.stop="removeFavorite(song.id)"
                                                        class="favorite-btn active ml-3"
                                                        title="Remove from favorites">
                                                        <span>⭐</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                
                                {{-- If NO have favorites --}}
                                <template x-if="favoriteSongs.length === 0">
                                    <div class="empty-state">
                                        <p class="empty-state-icon">💖</p>
                                        <p class="font-neon text-lg md:text-xl empty-state-title text-neon-pink">NO FAVORITES</p>
                                        <p class="text-xs md:text-sm">Click ☆ on any song to add it to favorites</p>
                                    </div>
                                </template>
                                
                                <h4 class="font-neon text-base md:text-lg mb-2 md:mb-3 text-neon-cyan mt-4">📖 HOW TO USE</h4>
                                <ol class="list-decimal list-inside text-xs md:text-sm instructions-list">
                                    <li>Use the traffic light to select quantity (1, 3 or 5 songs)</li>
                                    <li>Choose the mode: Moto for individual songs or Car for full artist</li>
                                    <li>Select songs from the catalog or favorites</li>
                                    <li>Play your selection with the controls</li>
                                </ol>
                            </div>
                        </div>

                        <!-- Search -->
                        <div class="mt-4 md:mt-6 mb-4 md:mb-6 search-container-green">
                            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                <input type="text" placeholder="🔍 Search songs..." class="search-input-green w-full sm:flex-1">
                                <button class="control-btn w-full sm:w-auto btn-padding-lg">SEARCH</button>
                            </div>
                        </div>

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

                                <div class="separator-vertical separator-50 hidden md:block"></div>

                                {{-- CAR --}}
                                <div class="ficha-item w-full sm:w-auto">
                                    <p class="ficha-label text-sm md:text-base text-neon-purple">🚗 CAR</p>
                                    <p class="ficha-count text-xl md:text-2xl text-neon-purple" x-text="userTokens['car'] || 0"></p>
                                    <p class="ficha-text">tokens</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 md:mt-6 comprar-container">
                            <h3 class="section-title section-title-cyan text-lg md:text-xl mb-3 md:mb-4">🎟️ BUY TOKENS</h3>
                            
                            <div class="flex flex-wrap justify-center md:justify-around items-center gap-4 md:gap-6">
                                @foreach($availableTokens as $index => $token)
                                    @php
                                        // Token type
                                        $colors = [
                                            'moto_1' => 'red',
                                            'moto_3' => 'yellow',
                                            'moto_5' => 'green',
                                            'car' => 'purple'
                                        ];
                                        $color = $colors[$token->name] ?? 'cyan';
                                        
                                        // Icon type
                                        $icon = str_starts_with($token->name, 'moto') ? '🏍️' : '🚗';
                                        
                                        // Description
                                        $description = $token->song_quantity == 0 
                                            ? 'Complete artist' 
                                            : $token->song_quantity . ' song' . ($token->song_quantity > 1 ? 's' : '');
                                    @endphp
                                    
                                    {{-- Separator --}}
                                    @if($index > 0)
                                        <div class="separator-vertical separator-vertical-cyan separator-70 hidden md:block"></div>
                                    @endif
                                    
                                    <div class="compra-item w-full sm:w-auto">
                                        <p class="compra-label text-sm md:text-base text-neon-{{ $color }}">{{ $icon }} {{ strtoupper($token->name) }}</p>
                                        <p class="compra-description">{{ $description }}</p>
                                        <p class="compra-price text-lg md:text-xl">€ {{ number_format($token->price, 2) }}</p>
                                        <form action="{{ route('jukebox.purchase') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="jukebox_token_id" value="{{ $token->id }}">
                                            <button type="submit" class="control-btn text-xs sm:text-sm w-full sm:w-auto btn-padding-md">BUY TOKEN</button>
                                        </form>
                                    </div>
                                @endforeach
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
document.addEventListener('alpine:init', () => {
    Alpine.data('jukeboxApp', () => ({
        // Estados
        selectedMode: null,
        selectedQuantity: null,
        selectedSongs: [],
        selectedArtist: null,
        _lastSelectedArtist: null,  // Variable persistente que NO se resetea
        isPlaying: false,
        isLocked: false,
        _toggling: false,
        _togglingFavorite: false,
        _lastFavoriteClick: 0,
        
        // Datos desde Blade
        userTokens: @json($tokenCounts),
        availableSongs: @json($allSongs),
        availableArtists: @json($allArtists),
        songsByArtist: @json($songsByArtist),
        favoriteSongs: @json($favoriteSongs), 
        favoriteIds: @json($favoriteIds),

        // Reproductor
        playlist: [],
        currentSongIndex: 0,
        audioPlayer: null,
        isLoading: false,
        currentPlayingSong: null,
        progress: 0,
        currentTime: 0,
        duration: 0,
        
        init() {
            console.log('🎵 Jukebox initialized');
            console.log('📊 Songs:', this.availableSongs.length);
            console.log('🎤 Artists:', this.availableArtists.length);
            console.log('🎫 Tokens:', this.userTokens);
            
            this.audioPlayer = new Audio();
            
            this.audioPlayer.addEventListener('loadedmetadata', () => {
                this.duration = this.audioPlayer.duration;
            });
            
            this.audioPlayer.addEventListener('timeupdate', () => {
                this.currentTime = this.audioPlayer.currentTime;
                this.progress = (this.currentTime / this.duration) * 100 || 0;
            });
            
            this.audioPlayer.addEventListener('ended', () => {
                console.log('🎵 Song ended, playing next...');
                this.playNext();
            });
            
            this.audioPlayer.addEventListener('error', (e) => {
                console.error('❌ Audio error:', e);
                alert('Error playing audio file');
            });
        },
        
        selectQuantity(quantity) {
            if (this.isLocked) return;
            
            this.selectedQuantity = quantity;
            this.selectedSongs = [];
            
            document.querySelectorAll('.traffic-light').forEach(light => light.classList.remove('active'));
            
            if (quantity === 1) {
                document.querySelector('.traffic-light.red').classList.add('active');
                document.getElementById('quantityText').textContent = '🔴 1 SONG';
            } else if (quantity === 3) {
                document.querySelector('.traffic-light.yellow').classList.add('active');
                document.getElementById('quantityText').textContent = '🟡 3 SONGS';
            } else if (quantity === 5) {
                document.querySelector('.traffic-light.green').classList.add('active');
                document.getElementById('quantityText').textContent = '🟢 5 SONGS';
            }
            
            console.log('🚦 Quantity:', quantity);
        },
        
        selectMode(mode) {
            if (this.isLocked) return;
            
            console.log('🚗/🏍️ Changing mode to:', mode);
            
            // Solo limpiar si estamos cambiando de modo
            if (this.selectedMode !== mode) {
                // Limpiar todo primero
                this.selectedSongs = [];
                this.selectedArtist = null;
                this.selectedQuantity = null;
            } else {
                console.log('⚠️ Same mode selected, not resetting');
                return; // Ya está en este modo, no hacer nada
            }
            
            // Forzar re-render: cambiar a null y luego al modo
            this.selectedMode = null;
            
            // Usar setTimeout para asegurar que Alpine procesa el cambio
            setTimeout(() => {
                this.selectedMode = mode;
                
                document.querySelectorAll('.vehicle').forEach(v => v.classList.remove('active'));
                
                if (mode === 'moto') {
                    document.getElementById('vehicleMoto').classList.add('active');
                    document.getElementById('modeText').textContent = '🏍️ MOTO (SONGS)';
                    console.log('🏍️ MOTO mode activated');
                } else {
                    document.getElementById('vehicleCar').classList.add('active');
                    document.getElementById('modeText').textContent = '🚗 CAR (COMPLETE ARTIST)';
                    console.log('🚗 CAR mode activated');
                }
            }, 10);
        },
        
        toggleSongSelection(songId) {
            console.log('🔵 Toggle called for song:', songId);
            
            if (this.isLocked) {
                console.log('🔴 Locked, cannot select');
                return;
            }
            
            // Debounce más agresivo
            if (this._toggling) {
                console.log('🔴 Already toggling, skip');
                return;
            }
            
            this._toggling = true;
            
            setTimeout(() => {
                const index = this.selectedSongs.indexOf(songId);
                
                if (index > -1) {
                    // Quitar canción
                    this.selectedSongs = this.selectedSongs.filter(id => id !== songId);
                    console.log('❌ Deselected:', songId);
                } else {
                    // Agregar canción
                    if (this.selectedSongs.length < this.selectedQuantity) {
                        this.selectedSongs = [...this.selectedSongs, songId];
                        console.log('✅ Selected:', songId);
                    } else {
                        alert(`You can only select ${this.selectedQuantity} songs`);
                    }
                }
                
                console.log('📋 Selected songs:', this.selectedSongs);
                
                // Liberar después de 200ms
                setTimeout(() => this._toggling = false, 200);
            }, 50);
        },
        
        isSongSelected(songId) {
            return this.selectedSongs.includes(songId);
        },
        
        selectArtist(artistId) {
            if (this.isLocked) return;
            
            console.log('🎤 Selecting artist:', artistId);
            this.selectedArtist = artistId;
            this._lastSelectedArtist = artistId;  // Guardar en variable persistente
            console.log('✅ Artist selected, selectedArtist is now:', this.selectedArtist);
            console.log('✅ _lastSelectedArtist is now:', this._lastSelectedArtist);
        },
        
        async togglePlay() {
            console.log('▶️ PLAY clicked');
            
            // Esperar a que Alpine procese todos los cambios reactivos
            await this.$nextTick();
            
            // CAPTURAR VALORES después de que Alpine actualice
            const capturedMode = this.selectedMode;
            const capturedQuantity = this.selectedQuantity;
            const capturedSongs = [...this.selectedSongs];
            // Usar _lastSelectedArtist si selectedArtist es null (fallback)
            const capturedArtist = this.selectedArtist || this._lastSelectedArtist;
            
            console.log('📸 Captured values:');
            console.log('Mode:', capturedMode);
            console.log('Quantity:', capturedQuantity);
            console.log('Selected songs:', capturedSongs);
            console.log('Selected artist:', capturedArtist);
            console.log('_lastSelectedArtist:', this._lastSelectedArtist);
            console.log('Is locked:', this.isLocked);
            
            if (this.isLocked) {
                if (this.isPlaying) {
                    this.pausePlay();
                } else {
                    this.resumePlay();
                }
                return;
            }
            
            // Validar que hay modo y cantidad seleccionados
            if (!capturedMode) {
                alert('Please select a mode first (MOTO or CAR)');
                return;
            }
            
            if (!capturedQuantity && capturedMode === 'moto') {
                alert('Please select quantity from traffic light');
                return;
            }
            
            // Validar selección
            if (capturedMode === 'moto') {
                console.log('Validating MOTO mode...');
                if (capturedSongs.length !== capturedQuantity) {
                    alert(`Please select exactly ${capturedQuantity} songs`);
                    return;
                }
            } else {
                console.log('Validating CAR mode...');
                console.log('Captured artist:', capturedArtist);
                // No validar aquí, el backend lo hace
                // El alert causa problemas con la reactividad de Alpine
            }
            
            // Consumir token y obtener playlist con valores capturados
            await this.consumeTokenAndPlay(capturedMode, capturedQuantity, capturedSongs, capturedArtist);
        },

        async consumeTokenAndPlay(mode, quantity, songs, artist) {
            this.isLoading = true;
            
            try {
                const payload = {
                    mode: mode,
                    quantity: quantity,
                    song_ids: songs,
                    artist_id: artist
                };
                
                console.log('📦 Sending payload:', payload);
                
                const response = await fetch('/player/consume-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                });
                
                const data = await response.json();
                console.log('📥 Server response:', data);
                
                if (!response.ok) {
                    alert(data.error || 'Error consuming token');
                    this.isLoading = false;
                    return;
                }
                
                this.playlist = data.songs;
                this.currentSongIndex = 0;
                this.isLocked = true;
                
                console.log('✅ Token consumed, playlist:', this.playlist);
                
                this.playCurrentSong();
                
                console.log('📊 Before discount - userTokens:', this.userTokens);
                
                if (mode === 'moto') {
                    const tokenKey = `moto_${quantity}`;
                    console.log('🏍️ MOTO mode - tokenKey:', tokenKey);
                    console.log('Current count:', this.userTokens[tokenKey]);
                    if (this.userTokens[tokenKey] > 0) {
                        this.userTokens[tokenKey]--;
                        console.log('✅ MOTO token decremented to:', this.userTokens[tokenKey]);
                    }
                } else {
                    console.log('🚗 CAR mode');
                    console.log('Current CAR count:', this.userTokens['car']);
                    console.log('Type of CAR count:', typeof this.userTokens['car']);
                    if (this.userTokens['car'] > 0) {
                        this.userTokens['car']--;
                        console.log('✅ CAR token decremented to:', this.userTokens['car']);
                    } else {
                        console.log('❌ CAR token NOT decremented - count is 0 or invalid');
                    }
                }
                
                console.log('📊 After discount - userTokens:', this.userTokens);
                
            } catch (error) {
                console.error('Error consuming token:', error);
                alert('Error starting playback');
            } finally {
                this.isLoading = false;
            }
        },

        playCurrentSong() {
            if (this.playlist.length === 0) return;
            
            const song = this.playlist[this.currentSongIndex];
            this.currentPlayingSong = song;
            
            console.log('▶️ Playing:', song.title, 'by', song.artist_name);
            
            this.audioPlayer.src = song.url_file;
            this.audioPlayer.play();
            this.isPlaying = true;
            
            this.updateNowPlaying(song);
            this.startVisualAnimations();
        },

        updateNowPlaying(song) {
            const title = document.querySelector('.now-playing-title');
            const subtitle = document.querySelector('.now-playing-subtitle');
            const hint = document.querySelector('.now-playing-hint');
            
            if (title) title.textContent = `♪ ${song.title} ♪`;
            if (subtitle) subtitle.textContent = song.artist_name;
            if (hint) hint.textContent = song.style;
        },

        startVisualAnimations() {
            const roadLine = document.getElementById('roadLine');
            const motoLight = document.getElementById('motoLight');
            const carLight = document.getElementById('carLight');
            
            if (roadLine) roadLine.classList.add('moving');
            if (motoLight) motoLight.classList.add('on');
            if (carLight) carLight.classList.add('on');
        },

        stopVisualAnimations() {
            const roadLine = document.getElementById('roadLine');
            const motoLight = document.getElementById('motoLight');
            const carLight = document.getElementById('carLight');
            
            if (roadLine) roadLine.classList.remove('moving');
            if (motoLight) motoLight.classList.remove('on');
            if (carLight) carLight.classList.remove('on');
        },

        resumePlay() {
            if (this.audioPlayer) {
                this.audioPlayer.play();
                this.isPlaying = true;
                this.startVisualAnimations();
                console.log('▶️ Resumed');
            }
        },

        pausePlay() {
            if (this.audioPlayer) {
                this.audioPlayer.pause();
                this.isPlaying = false;
                this.stopVisualAnimations();
                console.log('⏸️ Paused');
            }
        },

        playNext() {
            if (this.currentSongIndex < this.playlist.length - 1) {
                this.currentSongIndex++;
                this.playCurrentSong();
            } else {
                console.log('✅ Playlist finished');
                this.stopPlayback();
            }
        },

        stopPlayback() {
            if (this.audioPlayer) {
                this.audioPlayer.pause();
                this.audioPlayer.currentTime = 0;
            }
            
            this.isPlaying = false;
            this.isLocked = false;
            this.playlist = [];
            this.currentSongIndex = 0;
            this.currentPlayingSong = null;
            this.progress = 0;
            
            this.stopVisualAnimations();
            
            const title = document.querySelector('.now-playing-title');
            const subtitle = document.querySelector('.now-playing-subtitle');
            const hint = document.querySelector('.now-playing-hint');
            
            if (title) title.textContent = '♪ Playing... ♪';
            if (subtitle) subtitle.textContent = 'Select your music';
            if (hint) hint.textContent = 'Use the traffic light to select quantity';
            
            console.log('⏹️ Playback stopped');
        },

        isFavorite(songId) {
            return this.favoriteIds.includes(songId);
        },

        // Agregar a favoritos (solo desde catálogo)
        addFavorite(songId) {
            console.log('🎯 addFavorite called for:', songId);
            
            // Si ya está en favoritos, no hacer nada
            if (this.favoriteIds.includes(songId)) {
                console.log('❌ Already in favorites, ignoring');
                return;
            }
            
            console.log('✅ Adding to favorites...');
            
            // Actualizar UI INMEDIATAMENTE (síncrono)
            this.favoriteIds = [...this.favoriteIds, songId];
            
            // Buscar y agregar la canción
            const song = this.availableSongs.find(s => s.id === songId);
            if (song) {
                this.favoriteSongs = [song, ...this.favoriteSongs];
                console.log('✅ UI updated, now calling server...');
            }
            
            // Llamar al servidor en background (no esperar)
            fetch('/favorites/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ music_song_id: songId })
            })
            .then(r => r.json())
            .then(data => {
                console.log('Server response:', data);
                if (data.status !== 'added') {
                    // Si el servidor dice que NO se agregó, revertir
                    console.log('⚠️ Server rejected, reverting...');
                    this.favoriteIds = this.favoriteIds.filter(id => id !== songId);
                    this.favoriteSongs = this.favoriteSongs.filter(s => s.id !== songId);
                }
            })
            .catch(error => {
                console.error('❌ Server error, reverting:', error);
                this.favoriteIds = this.favoriteIds.filter(id => id !== songId);
                this.favoriteSongs = this.favoriteSongs.filter(s => s.id !== songId);
                alert('Error adding to favorites');
            });
        },
        
        // Eliminar de favoritos (solo desde favoritos)
        async removeFavorite(songId) {
            if (this._togglingFavorite) {
                console.log('🔴 Already processing, skip');
                return;
            }
            
            this._togglingFavorite = true;
            
            console.log('=== REMOVE FAVORITE ===');
            console.log('Song ID:', songId);
            
            try {
                const response = await fetch('/favorites/toggle', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ music_song_id: songId })
                });
                
                const data = await response.json();
                console.log('Server response:', data);
                
                if (data.status === 'removed') {
                    // Quitar de favoriteIds
                    this.favoriteIds = this.favoriteIds.filter(id => id !== songId);
                    console.log('💔 Removed from favoriteIds');
                    
                    // Quitar de favoriteSongs
                    this.favoriteSongs = this.favoriteSongs.filter(s => s.id !== songId);
                    console.log('💔 Removed from favoriteSongs');
                }
                
                console.log('=== REMOVE FAVORITE END ===');
                
            } catch (error) {
                console.error('❌ Error removing favorite:', error);
                alert('Error removing from favorites');
            } finally {
                setTimeout(() => {
                    this._togglingFavorite = false;
                }, 300);
            }
        }
    }));
});
</script>
</x-app-layout>

