<nav x-data="{ open: false }" style="background: linear-gradient(90deg, rgba(10, 10, 10, 0.95), rgba(26, 26, 26, 0.95)); backdrop-filter: blur(10px); border-bottom: 2px solid var(--neon-cyan); box-shadow: 0 4px 20px rgba(100, 210, 255, 0.3);">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <span class="font-neon text-2xl" style="color: var(--neon-cyan); text-shadow: 0 0 15px var(--neon-cyan);">
                            JUKEBOX CITY
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                                class="font-mono" 
                                style="color: #e0e0e0;">                        
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                
                <!-- User money. -->
                <div class="me-4 px-4 py-2 rounded-lg" 
                     style="background: linear-gradient(145deg, rgba(255, 214, 10, 0.2), rgba(255, 214, 10, 0.1)); border: 2px solid var(--neon-yellow);">
                    <span class="font-mono text-sm" style="color: var(--neon-yellow);">
                        € {{ number_format(Auth::user()->money ?? 0, 2) }}
                    </span>
                </div>

                 <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md focus:outline-none transition ease-in-out duration-150" 
                                style="color: var(--neon-cyan); background: rgba(100, 210, 255, 0.1);">
                            <div class="font-mono">{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
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

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md transition duration-150 ease-in-out" 
                        style="color: var(--neon-cyan);">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-mono">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t" style="border-color: var(--neon-cyan);">
            
            <!-- Mobile credits. -->
            <div class="px-4 mb-3">
                <div class="px-4 py-2 rounded-lg text-center" 
                     style="background: linear-gradient(145deg, rgba(255, 214, 10, 0.2), rgba(255, 214, 10, 0.1)); border: 2px solid var(--neon-yellow);">
                    <span class="font-mono text-sm" style="color: var(--neon-yellow);">
                        ${{ number_format(Auth::user()->money ?? 0, 2) }}
                    </span>
                </div>
            </div>

            <div class="px-4">
                <div class="font-medium text-base" style="color: var(--neon-cyan);">{{ Auth::user()->name }}</div>
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
    </div>
</nav>

