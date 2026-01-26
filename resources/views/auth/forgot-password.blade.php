<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="auth-form-title">
            RECUPERAR CONTRASEÑA
        </h2>
        <p class="auth-form-subtitle">Restablece el acceso a tu cuenta</p>
    </div>

    <div class="mb-4 auth-info-text">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="auth-label" />
            <x-text-input id="email" 
                class="block mt-1 w-full auth-input" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="auth-button-primary w-full sm:w-auto">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>


