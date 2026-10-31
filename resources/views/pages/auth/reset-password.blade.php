<x-layouts::auth :title="__('Reset password')">
    <div class="flex flex-col gap-1">
        <x-auth-header :title="__('Reset password')" :description="__('Please enter your new password below')" />

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-1">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <x-field name="email" :value="request('email')" :label="__('Email')" type="email" required autocomplete="email" />
            <x-password-field :label="__('Password')" required autocomplete="new-password" :placeholder="__('Password')" rules />
            <x-password-field name="password_confirmation" :label="__('Confirm password')" required autocomplete="new-password" :placeholder="__('Confirm password')" rules />

            <x-oc::button type="submit" class="w-full" data-test="reset-password-button">{{ __('Reset password') }}</x-oc::button>
        </form>
    </div>
</x-layouts::auth>
