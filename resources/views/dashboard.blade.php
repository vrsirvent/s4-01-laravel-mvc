<x-app-layout>
<div class="py-4 md:py-8">
    <div class="container mx-auto px-2 md:px-4">
        
        {{-- Mensajes de éxito/error --}}
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
                        <p class="font-neon text-sm text-neon-red" id="quantityText">🔴 1 SONG</p>
                        <p class="font-neon text-sm mt-1 text-neon-cyan" id="modeText">🏍️ MOTO (SONGS)</p>
                    </div>

                    <div class="credits">
                        <p class="credits-label">CREDIT:</p>
                        <!-- <p class="credits-amount">€{{ number_format(Auth::user()->money ?? 0, 2) }}</p> (this option has not worked) -->
                        <p class="credits-amount">€{{ number_format($userMoney, 2) }}</p>
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
                                    <div class="traffic-light red active" @click="selectQuantity(1)">1</div>
                                    <div class="traffic-light yellow" @click="selectQuantity(3)">3</div>
                                    <div class="traffic-light green" @click="selectQuantity(5)">5</div>
                                </div>
                                <div class="traffic-pole"></div>
                            </div>

                            <div class="controls">
                                <button class="control-btn" @click="togglePlay()">▶️ PLAY</button>
                                <button class="control-btn" @click="pausePlay()">⏸️ PAUSE</button>
                                <button class="control-btn">⏭️ NEXT</button>
                                <button class="control-btn">🔀 SHUFFLE</button>
                            </div>

                            <div class="now-playing">
                                <h3 class="text-base md:text-lg now-playing-title">♪ Playing... ♪</h3>
                                <p class="text-sm md:text-base now-playing-subtitle">Select your music</p>
                                <p class="text-xs now-playing-hint">Use the traffic light to select quantity</p>
                            </div>

                            <div class="vehicles">
                                <div class="vehicle moto active" id="vehicleMoto" @click="selectMode('moto')">
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
                                
                                {{-- MODO MOTO: Mostrar canciones --}}
                                <template x-if="selectedMode === 'moto'">
                                    <div>
                                        <template x-if="availableSongs.length > 0">
                                            <div class="space-y-2">
                                                <template x-for="song in availableSongs" :key="song.id">
                                                    <div class="song-item" 
                                                        :class="{ 'selected': isSongSelected(song.id) }"
                                                        @click="toggleSongSelection(song.id)"
                                                        style="cursor: pointer;">



                                                        <div class="flex items-center justify-between p-2 rounded hover:bg-gray-800 transition">
                                                            <div class="flex items-center gap-3" @click="toggleSongSelection(song.id)">
                                                                {{-- Checkbox visual --}}
                                                                <div class="checkbox" :class="{ 'checked': isSongSelected(song.id) }">
                                                                    <span x-show="isSongSelected(song.id)">✓</span>
                                                                </div>
                                                                
                                                                {{-- Info de la canción --}}
                                                                <div>
                                                                    <p class="font-neon text-sm text-neon-cyan" x-text="song.title"></p>
                                                                    <p class="text-xs text-gray-400">
                                                                        <span x-text="song.artist_name"></span> • 
                                                                        <span x-text="song.style"></span>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                             <div class="flex items-center gap-3">
                                                                {{-- Duración --}}
                                                                <div class="text-xs text-gray-500">
                                                                    <span x-text="Math.floor(song.length / 60) + ':' + String(song.length % 60).padStart(2, '0')"></span>
                                                                </div>
                                                                
                                                                {{-- Botón de favorito --}}
                                                                <button 
                                                                    @click.stop="toggleFavorite(song.id)"
                                                                    class="favorite-btn"
                                                                    :class="{ 'active': isFavorite(song.id) }"
                                                                    title="Add to favorites">
                                                                    <span x-text="isFavorite(song.id) ? '⭐' : '☆'"></span>
                                                                </button>
                                                            </div>
                                                        </div>                                                      
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                
                                {{-- MODO CAR: Mostrar artistas --}}
                                <template x-if="selectedMode === 'car'">
                                    <div>
                                        <template x-if="availableArtists.length > 0">
                                            <div class="space-y-2">
                                                <template x-for="artist in availableArtists" :key="artist.id">
                                                    <div class="artist-item"
                                                        :class="{ 'selected': selectedArtist === artist.id }"
                                                        @click="selectArtist(artist.id)"
                                                        style="cursor: pointer;">
                                                        <div class="p-3 rounded hover:bg-gray-800 transition"
                                                            :class="{ 'bg-gray-700': selectedArtist === artist.id }">
                                                            <p class="font-neon text-base text-neon-purple" x-text="artist.name"></p>
                                                            <p class="text-xs text-gray-400">
                                                                <span x-text="artist.songs_count"></span> songs
                                                            </p>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                
                                {{-- Estado vacío (cuando no hay modo seleccionado aún) --}}
                                <template x-if="!selectedMode">
                                    <div class="empty-state">
                                        <p class="empty-state-icon">🎵</p>
                                        <p class="font-neon text-lg md:text-xl empty-state-title text-neon-cyan">SELECT MODE</p>
                                        <p class="text-xs md:text-sm">Choose MOTO or CAR to see the catalog</p>
                                    </div>
                                </template>
                            </div> 



<div class="favorites">
    <h3 class="section-title section-title-pink text-lg md:text-xl mb-3 md:mb-4">💖 FAVORITES</h3>
    
    {{-- Si tiene favoritos --}}
    <template x-if="favoriteSongs.length > 0">
        <div class="space-y-2">
            <template x-for="song in favoriteSongs" :key="'fav-' + song.id">
                <div class="favorite-song-item">
                    <div class="flex items-center justify-between p-2 rounded hover:bg-gray-800 transition">
                        <div class="flex items-center gap-3">
                            {{-- Info de la canción --}}
                            <div>
                                <p class="font-neon text-sm text-neon-pink" x-text="song.title"></p>
                                <p class="text-xs text-gray-400">
                                    <span x-text="song.artist_name"></span> • 
                                    <span x-text="song.style"></span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            {{-- Duración --}}
                            <div class="text-xs text-gray-500">
                                <span x-text="Math.floor(song.length / 60) + ':' + String(song.length % 60).padStart(2, '0')"></span>
                            </div>
                            
                            {{-- Botón para quitar de favoritos --}}
                            <button 
                                @click="toggleFavorite(song.id)"
                                class="favorite-btn active"
                                title="Remove from favorites">
                                <span>⭐</span>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </template>
    
    {{-- Si NO tiene favoritos --}}
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
                                    <p class="ficha-count text-xl md:text-2xl text-neon-red">{{ $tokenCounts['moto_1'] ?? 0 }}</p>
                                    <p class="ficha-text">tokens</p>
                                </div>

                                <div class="separator-vertical separator-50 hidden md:block"></div>

                                {{-- MOTO 3 --}}
                                <div class="ficha-item w-full sm:w-auto">
                                    <p class="ficha-label text-sm md:text-base text-neon-yellow">🏍️ MOTO 3</p>
                                    <p class="ficha-count text-xl md:text-2xl text-neon-yellow">{{ $tokenCounts['moto_3'] ?? 0 }}</p>
                                    <p class="ficha-text">tokens</p>
                                </div>

                                <div class="separator-vertical separator-50 hidden md:block"></div>

                                {{-- MOTO 5 --}}
                                <div class="ficha-item w-full sm:w-auto">
                                    <p class="ficha-label text-sm md:text-base text-neon-green">🏍️ MOTO 5</p>
                                    <p class="ficha-count text-xl md:text-2xl text-neon-green">{{ $tokenCounts['moto_5'] ?? 0 }}</p>
                                    <p class="ficha-text">tokens</p>
                                </div>

                                <div class="separator-vertical separator-50 hidden md:block"></div>

                                {{-- CAR --}}
                                <div class="ficha-item w-full sm:w-auto">
                                    <p class="ficha-label text-sm md:text-base text-neon-purple">🚗 CAR</p>
                                    <p class="ficha-count text-xl md:text-2xl text-neon-purple">{{ $tokenCounts['car'] ?? 0 }}</p>
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
function jukeboxApp() {
    return {
        // Estado
        selectedMode: 'moto',
        selectedQuantity: 1,
        selectedSongs: [],
        selectedArtist: null,
        isPlaying: false,
        isLocked: false,
        
        // Datos desde Blade
        userTokens: @json($tokenCounts),
        availableSongs: @json($allSongs),
        availableArtists: @json($allArtists),
        songsByArtist: @json($songsByArtist),
        favoriteSongs: @json($favoriteSongs), 
        favoriteIds: @json($favoriteIds), 
        
        // Inicialización
        init() {
            console.log('🎵 Jukebox initialized');
            console.log('📊 Songs:', this.availableSongs.length);
            console.log('🎤 Artists:', this.availableArtists.length);
            console.log('🎫 Tokens:', this.userTokens);
        },
        
        // Seleccionar cantidad (semáforo)
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
        
        // Seleccionar modo (vehículo)
        selectMode(mode) {
            if (this.isLocked) return;
            
            this.selectedMode = mode;
            this.selectedSongs = [];
            this.selectedArtist = null;
            
            document.querySelectorAll('.vehicle').forEach(v => v.classList.remove('active'));
            
            if (mode === 'moto') {
                document.getElementById('vehicleMoto').classList.add('active');
                document.getElementById('modeText').textContent = '🏍️ MOTO (SONGS)';
                console.log('🏍️ MOTO mode');
            } else {
                document.getElementById('vehicleCar').classList.add('active');
                document.getElementById('modeText').textContent = '🚗 CAR (COMPLETE ARTIST)';
                console.log('🚗 CAR mode');
            }
        },
        
        // Seleccionar canción (modo MOTO)
        toggleSongSelection(songId) {
            if (this.isLocked) return;
            
            const index = this.selectedSongs.indexOf(songId);
            
            if (index > -1) {
                this.selectedSongs.splice(index, 1);
                console.log('❌ Deselected:', songId);
            } else {
                if (this.selectedSongs.length < this.selectedQuantity) {
                    this.selectedSongs.push(songId);
                    console.log('✅ Selected:', songId);
                } else {
                    alert(`You can only select ${this.selectedQuantity} songs`);
                }
            }
        },
        
        // Verificar si canción está seleccionada
        isSongSelected(songId) {
            return this.selectedSongs.includes(songId);
        },
        
        // Seleccionar artista (modo CAR)
        selectArtist(artistId) {
            if (this.isLocked) return;
            this.selectedArtist = artistId;
            console.log('🎤 Artist selected:', artistId);
        },
        
        // Botón PLAY
        togglePlay() {
            console.log('▶️ PLAY');
            
            const roadLine = document.getElementById('roadLine');
            const motoLight = document.getElementById('motoLight');
            const carLight = document.getElementById('carLight');
            
            this.isPlaying = !this.isPlaying;
            
            if (this.isPlaying) {
                roadLine.classList.add('moving');
                motoLight.classList.add('on');
                carLight.classList.add('on');
            } else {
                roadLine.classList.remove('moving');
                motoLight.classList.remove('on');
                carLight.classList.remove('on');
            }
        },
        
        // Botón PAUSE
        pausePlay() {
            console.log('⏸️ PAUSE');
            
            this.isPlaying = false;
            
            const roadLine = document.getElementById('roadLine');
            const motoLight = document.getElementById('motoLight');
            const carLight = document.getElementById('carLight');
            
            roadLine.classList.remove('moving');
            motoLight.classList.remove('on');
            carLight.classList.remove('on');
        },
        
        // Verificar si canción es favorita
        isFavorite(songId) {
            return this.favoriteIds.includes(songId);
        },

        // Toggle favorito (agregar o quitar)
        async toggleFavorite(songId) {
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
                
                if (data.status === 'added') {
                    this.favoriteIds.push(songId);
                    console.log('⭐ Added to favorites:', songId);
                    
                    // Agregar a la lista de favoritos
                    const song = this.availableSongs.find(s => s.id === songId);
                    if (song) {
                        this.favoriteSongs.unshift(song);
                    }
                } else {
                    const index = this.favoriteIds.indexOf(songId);
                    if (index > -1) {
                        this.favoriteIds.splice(index, 1);
                    }
                    console.log('💔 Removed from favorites:', songId);
                    
                    // Quitar de la lista de favoritos
                    this.favoriteSongs = this.favoriteSongs.filter(s => s.id !== songId);
                }
            } catch (error) {
                console.error('Error toggling favorite:', error);
                alert('Error updating favorites');
            }
        }
    }
}
</script>
</x-app-layout>

