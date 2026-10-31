<x-layouts::auth :title="__('Email verification')">
    <div class="flex flex-col gap-1">
        <x-auth-header :title="__('Verify your email')" :description="__('Please verify your email address by clicking on the link we just emailed to you.')" />

        @if (session('status') == 'verification-link-sent')
            <x-auth-session-status :status="__('A new verification link has been sent to the email address you provided during registration.')" />
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-oc::button type="submit" class="w-full">{{ __('Resend verification email') }}</x-oc::button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <x-oc::button type="submit" variant="ghost" size="sm" data-test="logout-button">{{ __('Log out') }}</x-oc::button>
        </form>
    </div>
</x-layouts::auth>
