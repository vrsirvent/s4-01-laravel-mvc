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
                    <x-category-carousel />
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

                        <div class="traffic-box" style="pointer-events: none">
                            <div class="traffic-lights">
                                <div class="traffic-light red"></div>
                                <div class="traffic-light yellow"></div>
                                <div class="traffic-light green"></div>
                            </div>                            
                        </div>

                        <div class="vehicles" style="pointer-events: none">
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
                    <!-- Spacer -->
                    <div style="height: 0; min-height: 0;"></div>
                </div>

                <div class="side-panel hidden lg:flex">
                    <div class="speaker"></div>
                    <div class="neon-bar"></div>
                </div>
            </div>

            <div class="footer-gradient text-center">
                <p class="font-neon text-sm md:text-base text-neon-yellow mb-1">IT ACADEMY - SPRINT 4</p>
                <p class="text-xs md:text-sm text-gray-400">Browse the catalog, find and play your favorite songs</p>
                <p class="auth-footer-text">© 2026 City Jukebox App | All rights reserved</p>
            </div>
        </div>
    </div>
</body>
</html>


