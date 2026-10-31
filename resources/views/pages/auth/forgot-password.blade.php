<x-layouts::auth :title="__('Forgot password')">
    <div class="flex flex-col gap-1">
        <x-auth-header :title="__('Forgot password')" :description="__('Enter your email to receive a password reset link')" />

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-1">
            @csrf
            <x-field name="email" :label="__('Email address')" type="email" required autofocus placeholder="email@example.com" />
            <x-oc::button type="submit" class="w-full" data-test="email-password-reset-link-button">{{ __('Email password reset link') }}</x-oc::button>
        </form>

        <p class="app-auth-switch">
            {{ __('Or, return to') }}
            <a class="oc-link" href="{{ route('login') }}">{{ __('log in') }}</a>
        </p>
    </div>
</x-layouts::auth>
