@props([
    'optionsRoute' => 'passkey.login-options',
    'submitRoute' => 'passkey.login',
    'label' => __('Sign in with a passkey'),
    'loadingLabel' => __('Authenticating...'),
    'separator' => __('Or continue with email'),
])

@once
@vite('resources/js/passkeys.js')
@endonce

<div
    x-data="{
        supported: false,
        loading: false,
        error: null,
        updateSupport() {
            this.supported = Boolean(window.Passkeys?.isSupported());
        },
        init() {
            this.updateSupport();
            window.addEventListener('passkeys:ready', () => this.updateSupport(), { once: true });
        },
        async verify() {
            this.loading = true;
            this.error = null;
            try {
                const response = await window.Passkeys.verify({
                    routes: {
                        options: '{{ route($optionsRoute) }}',
                        submit: '{{ route($submitRoute) }}',
                    },
                });
                window.location.href = response.redirect || '/dashboard';
            } catch (e) {
                if (e.constructor?.name !== 'UserCancelledError') {
                    this.error = e.message;
                }
            } finally {
                this.loading = false;
            }
        },
    }"
>
    <template x-if="supported">
        <div class="flex flex-col gap-1">
            <button type="button" class="oc-btn oc-btn--outline w-full" x-on:click="verify()" x-bind:disabled="loading">
                <x-icon name="mdi:key-outline" class="h-1 w-1" />
                <span x-show="!loading">{{ $label }}</span>
                <span x-show="loading" x-cloak>{{ $loadingLabel }}</span>
            </button>
            <p x-show="error" x-text="error" x-cloak class="oc-field-error text-center" role="alert"></p>
            <x-oc::separator :label="$separator" />
        </div>
    </template>
</div>
