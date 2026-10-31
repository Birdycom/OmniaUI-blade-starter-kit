<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-1">
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        <x-auth-session-status :status="session('status')" />

        {{-- @chisel-passkeys --}}
        <x-passkey-verify />
        {{-- @end-chisel-passkeys --}}

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-1">
            @csrf

            <x-field name="email" :label="__('Email address')" type="email" required autofocus autocomplete="email" placeholder="email@example.com" />

            <div class="app-password-row">
                <x-password-field :label="__('Password')" required autocomplete="current-password" :placeholder="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="oc-link app-forgot" href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                @endif
            </div>

            <x-oc::checkbox name="remember" :checked="old('remember')" :label="__('Remember me')" />

            <x-oc::button type="submit" class="w-full" data-test="login-button">{{ __('Log in') }}</x-oc::button>
        </form>

        {{-- @chisel-registration --}}
        <p class="app-auth-switch">
            {{ __('Don\'t have an account?') }}
            <a class="oc-link" href="{{ route('register') }}">{{ __('Sign up') }}</a>
        </p>
        {{-- @end-chisel-registration --}}
    </div>
</x-layouts::auth>
