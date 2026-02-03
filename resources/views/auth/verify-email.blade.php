<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="auth-form-title">
            VERIFY EMAIL
        </h2>
        <p class="auth-form-subtitle">Confirm your email address</p>
    </div>

    <div class="mb-4 auth-info-text">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium auth-success-message">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button type="submit" class="auth-button-primary w-full sm:w-auto">
                    {{ __('Resend Verification Email') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="auth-link">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>