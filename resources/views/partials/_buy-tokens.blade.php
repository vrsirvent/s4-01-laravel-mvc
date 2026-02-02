{{-- BUY TOKENS section: purchase tokens with user credits --}}
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


