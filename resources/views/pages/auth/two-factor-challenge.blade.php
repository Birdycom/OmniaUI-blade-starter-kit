<x-layouts::auth :title="__('Two-factor authentication')">
    <div
        class="flex flex-col gap-1"
        x-cloak
        x-data="{
            showRecoveryInput: @js($errors->has('recovery_code')),
            code: '',
            recovery_code: '',
            init() {
                if (! this.showRecoveryInput) this.$nextTick(() => this.$refs.otp?.focus());
            },
            toggleInput() {
                this.showRecoveryInput = ! this.showRecoveryInput;
                this.code = '';
                this.recovery_code = '';
                this.$nextTick(() => (this.showRecoveryInput ? this.$refs.recovery_code : this.$refs.otp)?.focus());
            },
        }"
    >
        <div x-show="!showRecoveryInput">
            <x-auth-header :title="__('Authentication code')" :description="__('Enter the authentication code provided by your authenticator application.')" />
        </div>
        <div x-show="showRecoveryInput">
            <x-auth-header :title="__('Recovery code')" :description="__('Please confirm access to your account by entering one of your emergency recovery codes.')" />
        </div>

        <form method="POST" action="{{ route('two-factor.login.store') }}" class="flex flex-col gap-1">
            @csrf

            <div x-show="!showRecoveryInput" class="app-otp">
                <x-oc::otp-input name="code" :label="__('Authentication code')" x-model="code" x-ref="otp" :error="$errors->has('code')" />
                @error('code')
                    <p class="oc-field-error" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div x-show="showRecoveryInput">
                <x-oc::form-field :label="__('Recovery code')" for="recovery_code" name="recovery_code">
                    <x-oc::input id="recovery_code" name="recovery_code" x-ref="recovery_code" x-bind:required="showRecoveryInput" autocomplete="one-time-code" x-model="recovery_code" />
                </x-oc::form-field>
            </div>

            <x-oc::button type="submit" class="w-full">{{ __('Continue') }}</x-oc::button>
        </form>

        <p class="app-auth-switch">
            {{ __('or you can') }}
            <button type="button" class="oc-btn oc-btn--link oc-btn--inline" x-on:click="toggleInput()">
                <span x-show="!showRecoveryInput">{{ __('login using a recovery code') }}</span>
                <span x-show="showRecoveryInput">{{ __('login using an authentication code') }}</span>
            </button>
        </p>
    </div>
</x-layouts::auth>
