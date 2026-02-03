<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="auth-form-title">
            REGISTRATION
        </h2>
        <p class="auth-form-subtitle">Join our music collection</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="auth-label" />
            <x-text-input id="name" 
                class="block mt-1 w-full auth-input" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="auth-label" />
            <x-text-input id="email" 
                class="block mt-1 w-full auth-input" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="auth-label" />
            <x-text-input id="password" 
                class="block mt-1 w-full auth-input"
                type="password"
                name="password"
                required 
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="auth-label" />
            <x-text-input id="password_confirmation" 
                class="block mt-1 w-full auth-input"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-6 gap-3">
            <a class="auth-link" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <button type="submit" class="auth-button-primary w-full sm:w-auto">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>
