<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="auth-form-title">
            CONFIRMAR CONTRASEÑA
        </h2>
        <p class="auth-form-subtitle">Área segura de la aplicación</p>
    </div>

    <div class="mb-4 auth-info-text">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="auth-label" />
            <x-text-input id="password" 
                class="block mt-1 w-full auth-input"
                type="password"
                name="password"
                required 
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="auth-button-primary w-full sm:w-auto">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>


