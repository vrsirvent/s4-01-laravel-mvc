<section class="space-y-6">
    <header>
        <h2 class="profile-section-title-danger">
            {{ __('Delete Account') }}
        </h2>

        <p class="profile-section-description">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="auth-button-danger"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 profile-modal-content">
            @csrf
            @method('delete')

            <h2 class="profile-section-title-danger">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 profile-section-description">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 profile-input-danger"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button 
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="auth-button-secondary"
                >
                    {{ __('Cancel') }}
                </button>

                <button 
                    type="submit"
                    class="auth-button-danger"
                >
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>