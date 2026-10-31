<x-layouts::app :title="__('Profile settings')">
    @include('partials.settings-heading')

    <x-pages::settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form method="POST" action="{{ route('profile.update') }}" class="flex flex-col gap-1">
            @csrf
            @method('PATCH')

            <x-field name="name" :value="$user->name" :label="__('Name')" required autofocus autocomplete="name" />
            <x-field name="email" :value="$user->email" :label="__('Email')" type="email" required autocomplete="email" />

            {{-- @chisel-email-verification --}}
            @if ($hasUnverifiedEmail)
                <div class="oc-alert oc-alert--warning" role="status">
                    <p class="oc-alert-description">
                        {{ __('Your email address is unverified.') }}
                        <button type="submit" form="send-verification" class="oc-btn oc-btn--link oc-btn--inline">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="oc-alert-description font-medium">{{ __('A new verification link has been sent to your email address.') }}</p>
                    @endif
                </div>
            @endif
            {{-- @end-chisel-email-verification --}}

            <div>
                <x-oc::button type="submit" data-test="update-profile-button">{{ __('Save') }}</x-oc::button>
            </div>
        </form>

        {{-- @chisel-email-verification --}}
        <form id="send-verification" method="POST" action="{{ route('verification.send') }}">@csrf</form>

        @if ($showDeleteUser)
        {{-- @end-chisel-email-verification --}}
            @include('pages::settings.delete-user')
        {{-- @chisel-email-verification --}}
        @endif
        {{-- @end-chisel-email-verification --}}
    </x-pages::settings.layout>
</x-layouts::app>
