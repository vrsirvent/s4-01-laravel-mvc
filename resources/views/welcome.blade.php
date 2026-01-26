<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jukebox</title>
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('layouts.navigation')

    <div class="container mx-auto px-2 md:px-4 py-4 md:py-8">
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
                    <h1>CITY JUKEBOX</h1>
                </div>
            </div>

            <div class="flex">
                <div class="side-panel hidden lg:flex">
                    <div class="speaker"></div>
                    <div class="neon-bar"></div>
                </div>

                <div class="flex-1 p-3 md:p-6">
                    <div class="visual-screen mb-4 md:mb-6">

                        <div class="stars">
                            <p class="subtitle">Your Vintage Music Experience</p>
                        </div>
                        <div class="city"></div>
                        <div class="road">
                            <div class="road-line" id="roadLine"></div>
                        </div>

                        <div class="traffic-box">
                            <div class="traffic-lights">
                                <div class="traffic-light red active"></div>
                                <div class="traffic-light yellow"></div>
                                <div class="traffic-light green"></div>
                            </div>                            
                        </div>

                        <div class="vehicles">
                            <div class="vehicle moto" id="vehicleMoto">
                                <div class="moto-body"></div>
                                <div class="moto-wheel back"></div>
                                <div class="moto-wheel front"></div>
                                <div class="moto-light"></div>
                            </div>

                            <div class="vehicle car" id="vehicleCar">
                                <div class="car-roof"></div>
                                <div class="car-body"></div>
                                <div class="car-wheel back"></div>
                                <div class="car-wheel front"></div>
                                <div class="car-headlight"></div>
                                <div class="car-taillight"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Spacer to maintain dimensions -->
                    <div style="height: 0; min-height: 0;"></div>
                </div>

                <div class="side-panel hidden lg:flex">
                    <div class="speaker"></div>
                    <div class="neon-bar"></div>
                </div>
            </div>

            <div class="footer-gradient"></div>
        </div>
    </div>

</body>
</html>
