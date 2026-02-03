<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="auth-form-title">
            NEW PASSWORD
        </h2>
        <p class="auth-form-subtitle">Set your new password</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="auth-label" />
            <x-text-input id="email" 
                class="block mt-1 w-full auth-input" 
                type="email" 
                name="email" 
                :value="old('email', $request->email)" 
                required 
                autofocus 
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

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="auth-button-primary w-full sm:w-auto">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
</x-guest-layout>