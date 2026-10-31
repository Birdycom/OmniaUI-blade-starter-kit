@once
@vite('resources/js/passkeys.js')
@endonce

<div
    x-data="{
        supported: false,
        showForm: false,
        name: '',
        loading: false,
        error: null,
        updateSupport() {
            this.supported = Boolean(window.Passkeys?.isSupported());
        },
        getDefaultPasskeyName() {
            const ua = navigator.userAgent;

            const browser = [
                { pattern: /Edg|Edge/, name: 'Edge' },
                { pattern: /OPR|Opera|OPiOS/, name: 'Opera' },
                { pattern: /Firefox|FxiOS/, name: 'Firefox' },
                { pattern: /Chrome|CriOS/, name: 'Chrome' },
                { pattern: /Safari/, name: 'Safari' },
            ].find(({ pattern }) => pattern.test(ua))?.name;

            const os = [
                { pattern: /iPhone/, name: 'iPhone' },
                { pattern: /iPad|Macintosh(?=.*Mobile)/, name: 'iPad' },
                { pattern: /Android/, name: 'Android' },
                { pattern: /Mac/, name: 'Mac' },
                { pattern: /Windows/, name: 'Windows' },
            ].find(({ pattern }) => pattern.test(ua))?.name;

            return [browser, os].filter(Boolean).join(' on ') || '';
        },
        init() {
            this.name = this.getDefaultPasskeyName();
            this.updateSupport();
            window.addEventListener('passkeys:ready', () => this.updateSupport(), { once: true });
        },
        async register() {
            if (!this.name.trim()) return;

            this.loading = true;
            this.error = null;

            try {
                await window.Passkeys.register({ name: this.name });
                this.name = '';
                this.showForm = false;
                window.location.reload();
            } catch (e) {
                if (e.constructor?.name !== 'UserCancelledError') {
                    this.error = e.message;
                }
            } finally {
                this.loading = false;
            }
        },
        cancel() {
            this.showForm = false;
            this.name = '';
            this.error = null;
        },
    }"
>
    <template x-if="!supported">
        <p class="app-muted">{{ __('Passkeys are not supported in this browser.') }}</p>
    </template>

    <template x-if="supported && !showForm">
        <div>
            <x-oc::button x-on:click="showForm = true">+ {{ __('Add passkey') }}</x-oc::button>
        </div>
    </template>

    <template x-if="supported && showForm">
        <div class="oc-card">
            <div class="oc-card-content flex flex-col gap-1">
                <x-oc::form-field :label="__('Passkey name')" for="passkey-name" :description="__('Give this passkey a name to help you identify it later.')">
                    <x-oc::input id="passkey-name" x-model="name" :placeholder="__('e.g., MacBook Pro, iPhone')"
                        x-on:keydown.enter.prevent="register()" x-ref="passkeyNameInput" x-init="$nextTick(() => $refs.passkeyNameInput?.focus())" />
                </x-oc::form-field>

                <p x-show="error" x-text="error" x-cloak class="oc-field-error" role="alert"></p>

                <div class="flex gap-0.5">
                    <x-oc::button x-on:click="register()" x-bind:disabled="loading || !name.trim()">
                        <span x-show="!loading">{{ __('Register passkey') }}</span>
                        <span x-show="loading" x-cloak>{{ __('Registering...') }}</span>
                    </x-oc::button>
                    <x-oc::button variant="ghost" x-on:click="cancel()">{{ __('Cancel') }}</x-oc::button>
                </div>
            </div>
        </div>
    </template>
</div>
