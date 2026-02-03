{{-- Player display screen. Alpine's <script> controls these elements. --}}
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

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('jukeboxApp', () => ({
        // States
        selectedMode: null,
        selectedQuantity: null,
        selectedSongs: [],
        selectedArtist: null,
        _lastSelectedArtist: null,
        isPlaying: false,
        isLocked: false,
        _togglingFavorite: false,
        _lastFavoriteClick: 0,
        
        // Data from Blade
        userTokens: @json($tokenCounts),
        availableSongs: @json($allSongs),
        availableArtists: @json($allArtists),
        favoriteSongs: @json($favoriteSongs), 
        favoriteIds: @json($favoriteIds),


        // Player
        playlist: [],
        currentSongIndex: 0,
        audioPlayer: null,
        isLoading: false,
        currentPlayingSong: null,
        progress: 0,
        currentTime: 0,
        duration: 0,
        
        init() {
            this.audioPlayer = new Audio();
            
            this.audioPlayer.addEventListener('loadedmetadata', () => {
                this.duration = this.audioPlayer.duration;
            });
            
            this.audioPlayer.addEventListener('timeupdate', () => {
                this.currentTime = this.audioPlayer.currentTime;
                this.progress = (this.currentTime / this.duration) * 100 || 0;
            });
            
            this.audioPlayer.addEventListener('ended', () => {
                this.playNext();
            });
            
            this.audioPlayer.addEventListener('error', () => {
                alert('Error playing audio file');
            });
            
            this.$watch('selectedSongs', (value) => {
                if (this.selectedQuantity && this.selectedMode === 'moto') {
                    const text = document.getElementById('quantityText');
                    if (!text) return;
                    
                    const count = value.length;
                    const total = this.selectedQuantity;
                    
                    if (this.selectedQuantity === 1) {
                        text.textContent = `🔴 1 SONG (${count}/${total})`;
                    } else if (this.selectedQuantity === 3) {
                        text.textContent = `🟡 3 SONGS (${count}/${total})`;
                    } else if (this.selectedQuantity === 5) {
                        text.textContent = `🟢 5 SONGS (${count}/${total})`;
                    }
                }
            });
        },
        
        selectQuantity(quantity) {
            if (this.isLocked) return;
            
            this.selectedQuantity = quantity;
            this.selectedSongs = [];
            
            document.querySelectorAll('.traffic-light').forEach(light => light.classList.remove('active'));
            
            if (quantity === 1) {
                document.querySelector('.traffic-light.red').classList.add('active');
                document.getElementById('quantityText').textContent = '🔴 1 SONG (0/1)';
            } else if (quantity === 3) {
                document.querySelector('.traffic-light.yellow').classList.add('active');
                document.getElementById('quantityText').textContent = '🟡 3 SONGS (0/3)';
            } else if (quantity === 5) {
                document.querySelector('.traffic-light.green').classList.add('active');
                document.getElementById('quantityText').textContent = '🟢 5 SONGS (0/5)';
            }
        },
        
        selectMode(mode) {
            if (this.isLocked) return;
            
            if (this.selectedMode !== mode) {
                this.selectedSongs = [];
                this.selectedArtist = null;
                this.selectedQuantity = null;
            } else {
                return;
            }
            
            this.selectedMode = null;
            
            setTimeout(() => {
                this.selectedMode = mode;
                
                document.querySelectorAll('.vehicle').forEach(v => v.classList.remove('active'));
                
                if (mode === 'moto') {
                    document.getElementById('vehicleMoto').classList.add('active');
                    document.getElementById('modeText').textContent = '🏍️ MOTO (SONGS)';
                } else {
                    document.getElementById('vehicleCar').classList.add('active');
                    document.getElementById('modeText').textContent = '🚗 CAR (COMPLETE ARTIST)';
                }
            }, 10);
        },
        
        toggleSongSelection(songId) {
            if (this.isLocked) return;
            
            const index = this.selectedSongs.indexOf(songId);
            
            if (index > -1) {
                this.selectedSongs = this.selectedSongs.filter(id => id !== songId);
            } else {
                if (this.selectedSongs.length < this.selectedQuantity) {
                    this.selectedSongs = [...this.selectedSongs, songId];
                } else {
                    alert(`You can only select ${this.selectedQuantity} songs`);
                }
            }
            
            this.$nextTick(() => {
            });
        },
        
        isSongSelected(songId) {
            return this.selectedSongs.includes(songId);
        },
        
        selectArtist(artistId) {
            if (this.isLocked) return;
            
            this.selectedArtist = artistId;
            this._lastSelectedArtist = artistId;
        },
        
        async togglePlay() {
            if (this.isLocked) {
                if (this.isPlaying) {
                    this.pausePlay();
                } else {
                    this.resumePlay();
                }
                return;
            }
            
            await this.$nextTick();
            await new Promise(resolve => setTimeout(resolve, 200));
            
            const capturedMode = this.selectedMode;
            const capturedQuantity = this.selectedQuantity;
            const capturedSongs = [...this.selectedSongs];
            const capturedArtist = this.selectedArtist || this._lastSelectedArtist;
            
            if (!capturedMode) {
                alert('Please select a mode first (MOTO or CAR)');
                return;
            }
            
            if (capturedMode === 'moto' && !capturedQuantity) {
                alert('Please select quantity from traffic light');
                return;
            }
            
            if (capturedMode === 'moto') {
                if (capturedSongs.length !== capturedQuantity) {
                    alert(`Please select exactly ${capturedQuantity} songs`);
                    return;
                }
            } else if (capturedMode === 'car') {
                if (!capturedArtist) {
                    alert('The artist is required');
                    return;
                }
            }
            
            await this.consumeTokenAndPlay(capturedMode, capturedQuantity, capturedSongs, capturedArtist);
        },

        async consumeTokenAndPlay(mode, quantity, songs, artist) {
            this.isLoading = true;
            
            try {
                const response = await fetch('/player/consume-token', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        mode: mode,
                        quantity: quantity,
                        song_ids: songs,
                        artist_id: artist
                    })
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    alert(data.error || 'Error consuming token');
                    this.isLoading = false;
                    return;
                }
                
                this.playlist = data.songs;
                this.currentSongIndex = 0;
                this.isLocked = true;
                
                this.playCurrentSong();
                
                if (mode === 'moto') {
                    const tokenKey = `moto_${quantity}`;
                    if (this.userTokens[tokenKey] > 0) {
                        this.userTokens[tokenKey]--;
                    }
                } else {
                    if (this.userTokens['car'] > 0) {
                        this.userTokens['car']--;
                    }
                }
                
            } catch (error) {
                alert('Error starting playback');
            } finally {
                this.isLoading = false;
            }
        },

        playCurrentSong() {
            if (this.playlist.length === 0) return;
            
            const song = this.playlist[this.currentSongIndex];
            this.currentPlayingSong = song;
            
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
            }
        },

        pausePlay() {
            if (this.audioPlayer) {
                this.audioPlayer.pause();
                this.isPlaying = false;
                this.stopVisualAnimations();
            }
        },

        playNext() {
            if (this.currentSongIndex < this.playlist.length - 1) {
                this.currentSongIndex++;
                this.playCurrentSong();
            } else {
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
        },

        isFavorite(songId) {
            return this.favoriteIds.includes(songId);
        },

        // Add to favorites (only from catalog)
        addFavorite(songId) {
            if (this.favoriteIds.includes(songId)) return;
            
            this.favoriteIds = [...this.favoriteIds, songId];
            
            const song = this.availableSongs.find(s => s.id === songId);
            if (song) {
                this.favoriteSongs = [song, ...this.favoriteSongs];
            }
            
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
                if (data.status !== 'added') {
                    this.favoriteIds = this.favoriteIds.filter(id => id !== songId);
                    this.favoriteSongs = this.favoriteSongs.filter(s => s.id !== songId);
                }
            })
            .catch(() => {
                this.favoriteIds = this.favoriteIds.filter(id => id !== songId);
                this.favoriteSongs = this.favoriteSongs.filter(s => s.id !== songId);
                alert('Error adding to favorites');
            });
        },
        
        // Remove from favorites (only from favorites)
        async removeFavorite(songId) {
            if (this._togglingFavorite) return;
            
            this._togglingFavorite = true;
            
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
                
                if (data.status === 'removed') {
                    this.favoriteIds = this.favoriteIds.filter(id => id !== songId);
                    this.favoriteSongs = this.favoriteSongs.filter(s => s.id !== songId);
                }
                
            } catch (error) {
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


