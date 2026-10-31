<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-1">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-1">
            @csrf

            <x-field name="name" :label="__('Name')" required autofocus autocomplete="name" :placeholder="__('Full name')" />
            <x-field name="email" :label="__('Email address')" type="email" required autocomplete="email" placeholder="email@example.com" />
            <x-password-field :label="__('Password')" required autocomplete="new-password" :placeholder="__('Password')" rules />
            <x-password-field name="password_confirmation" :label="__('Confirm password')" required autocomplete="new-password" :placeholder="__('Confirm password')" rules />

            <x-oc::button type="submit" class="w-full" data-test="register-user-button">{{ __('Create account') }}</x-oc::button>
        </form>

        <p class="app-auth-switch">
            {{ __('Already have an account?') }}
            <a class="oc-link" href="{{ route('login') }}">{{ __('Log in') }}</a>
        </p>
    </div>
</x-layouts::auth>
