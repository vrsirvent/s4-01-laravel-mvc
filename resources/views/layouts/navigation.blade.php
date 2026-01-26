<nav x-data="{ open: false }" class="top-nav sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-3 md:px-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2 md:gap-4">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->check() ? route('dashboard') : url('/') }}">
                        <div>
                            <h1 class="font-neon text-lg md:text-2xl nav-title">Music System</h1>
                            <p class="text-xs nav-subtitle hidden sm:block">Your Media Player</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex flex-1 justify-center">
                @guest
                    {{-- (welcome) --}}
                    <a href="{{ route('login') }}" class="nav-link font-neon {{ request()->routeIs('login') ? 'active' : '' }}">LOGIN</a>
                    <a href="{{ route('register') }}" class="nav-link font-neon {{ request()->routeIs('register') ? 'active' : '' }}">REGISTER</a>
                    <div class="nav-underline"></div>
                @else
                    {{-- Users --}}
                    <a href="{{ route('dashboard') }}" class="nav-link font-neon {{ request()->routeIs('dashboard') ? 'active' : '' }}">DASHBOARD</a>
                    <a href="{{ route('song') }}" class="nav-link font-neon {{ request()->routeIs('song') ? 'active' : '' }}">SONGS</a>
                    <a href="{{ route('artist') }}" class="nav-link font-neon {{ request()->routeIs('artist') ? 'active' : '' }}">ARTISTS</a>
                    <a href="{{ route('category') }}" class="nav-link font-neon {{ request()->routeIs('category') ? 'active' : '' }}">CATEGORIES</a>
                @endguest
            </div>

            <!-- Settings Dropdown (Users) -->
            @auth
                <div class="flex items-center gap-2 md:gap-3">
                    {{-- Authenticated User --}}
                    <div class="text-right hidden sm:block">
                        <p class="font-neon text-sm md:text-base text-neon-yellow">{{ Auth::user()->name }}</p>
                    </div>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="user-avatar-container">
                                <div class="user-avatar-inner"></div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="font-mono">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                        class="font-mono">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth

            <!-- Responsive Minimalist Hamburger Menu -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out text-neon-cyan">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @guest
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')" class="font-mono">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')" class="font-mono">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-mono">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('song')" :active="request()->routeIs('song')" class="font-mono">
                    {{ __('Songs') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('artist')" :active="request()->routeIs('artist')" class="font-mono">
                    {{ __('Artists') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('category')" :active="request()->routeIs('category')" class="font-mono">
                    {{ __('Categories') }}
                </x-responsive-nav-link>
            @endguest
        </div>

        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 responsive-settings-border">
                <div class="px-4">
                    <div class="font-medium text-base text-neon-cyan">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="font-mono">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                class="font-mono">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>

