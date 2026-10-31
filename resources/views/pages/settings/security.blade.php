<x-layouts::app :title="__('Security settings')">
    @include('partials.settings-heading')

    <x-pages::settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        @if (session('status') === __('Password updated.'))
            <x-auth-session-status :status="session('status')" />
        @endif

        <form method="POST" action="{{ route('user-password.update') }}" class="flex flex-col gap-1">
            @csrf
            @method('PUT')

            @foreach (['current_password' => [__('Current password'), 'current-password', false], 'password' => [__('New password'), 'new-password', true], 'password_confirmation' => [__('Confirm password'), 'new-password', true]] as $field => [$label, $autocomplete, $rules])
                <div class="app-field">
                    <x-oc::password-input :id="'field-'.$field" :name="$field" :label="$label" :show="__('Show')" :hide="__('Hide')" required :autocomplete="$autocomplete"
                        :error="$errors->updatePassword->has($field)" :passwordrules="$rules ? \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() : null" />
                    @error($field, 'updatePassword')
                        <p class="oc-field-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            <div>
                <x-oc::button type="submit" data-test="update-password-button">{{ __('Save') }}</x-oc::button>
            </div>
        </form>

        {{-- @chisel-2fa --}}
        @if ($canManageTwoFactor)
            <section class="app-settings-section">
                <x-oc::heading :title="__('Two-factor authentication')" :description="__('Manage your two-factor authentication settings')" size="sm" />

                @if ($twoFactorEnabled)
                    <div class="oc-alert oc-alert--success" role="status">
                        <p class="oc-alert-title"><x-oc::badge variant="success">{{ __('Enabled') }}</x-oc::badge></p>
                        <p class="oc-alert-description">{{ __('You will be prompted for a secure, random pin during login, which you can retrieve from the TOTP-supported application on your phone.') }}</p>
                    </div>
                    <form method="POST" action="{{ route('two-factor.disable') }}">
                        @csrf
                        @method('DELETE')
                        <x-oc::button type="submit" variant="destructive">{{ __('Disable 2FA') }}</x-oc::button>
                    </form>

                    {{-- Recovery codes: shown on request (<details>, no JavaScript). --}}
                    <details class="oc-card app-recovery" @if (session('status') === 'recovery-codes-generated') open @endif>
                        <summary class="oc-card-header">
                            <span class="oc-card-title">{{ __('2FA recovery codes') }}</span>
                            <span class="oc-card-description">{{ __('Recovery codes let you regain access if you lose your 2FA device. Store them in a secure password manager.') }}</span>
                        </summary>
                        <div class="oc-card-content flex flex-col gap-1">
                            <div class="oc-recovery-codes">
                                <p class="oc-recovery-codes-warning">{{ __('Each recovery code can be used once to access your account and will be removed after use. If you need more, click Regenerate codes above.') }}</p>
                                <ul class="oc-recovery-codes-list" aria-label="{{ __('Recovery codes') }}">
                                    @foreach ($recoveryCodes as $code)
                                        <li>{{ $code }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <form method="POST" action="{{ route('two-factor.regenerate-recovery-codes') }}">
                                @csrf
                                <x-oc::button type="submit" variant="outline">{{ __('Regenerate codes') }}</x-oc::button>
                            </form>
                        </div>
                    </details>
                @elseif ($settingUp)
                    {{-- Step 2 of the setup: scan the QR code, then confirm with a code from the app. --}}
                    <div class="oc-card">
                        <div class="oc-card-header">
                            <h3 class="oc-card-title">{{ __('Enable two-factor authentication') }}</h3>
                            <p class="oc-card-description">{{ __('To finish enabling two-factor authentication, scan the QR code or enter the setup key in your authenticator app.') }}</p>
                        </div>
                        <div class="oc-card-content flex flex-col gap-1">
                            <div class="app-qr">{!! $qrCodeSvg !!}</div>
                            <x-oc::separator :label="__('or, enter the code manually')" />
                            <x-copy-field :value="$setupKey" :label="__('Setup key')" />

                            <form method="POST" action="{{ route('two-factor.confirm') }}" class="flex flex-col gap-1">
                                @csrf
                                <div class="app-otp">
                                    <x-oc::otp-input name="code" :label="__('Authentication code')" :error="$errors->confirmTwoFactorAuthentication->has('code')" autofocus />
                                    @error('code', 'confirmTwoFactorAuthentication')
                                        <p class="oc-field-error" role="alert">{{ $message }}</p>
                                    @enderror
                                </div>
                                <x-oc::button type="submit" class="w-full">{{ __('Confirm') }}</x-oc::button>
                            </form>
                        </div>
                    </div>
                @else
                    <p class="app-muted">{{ __('When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a TOTP-supported application on your phone.') }}</p>
                    <form method="POST" action="{{ route('two-factor.enable') }}">
                        @csrf
                        <x-oc::button type="submit">{{ __('Enable 2FA') }}</x-oc::button>
                    </form>
                @endif
            </section>
        @endif
        {{-- @end-chisel-2fa --}}

        {{-- @chisel-passkeys --}}
        @if ($canManagePasskeys)
            <section class="app-settings-section">
                <x-oc::heading :title="__('Passkeys')" :description="__('Manage your passkeys for passwordless sign-in')" size="sm" />

                @if ($passkeys->isNotEmpty())
                    <ul class="oc-card app-passkeys" role="list">
                        @foreach ($passkeys as $passkey)
                            <li class="app-passkey">
                                <span class="app-passkey-icon"><x-icon name="key" /></span>
                                <div class="app-passkey-text">
                                    <p class="font-medium">
                                        {{ $passkey->name }}
                                        @if ($passkey->authenticator)
                                            <x-oc::badge variant="secondary">{{ $passkey->authenticator }}</x-oc::badge>
                                        @endif
                                    </p>
                                    <p class="app-muted">
                                        {{ __('Added :time', ['time' => $passkey->created_at->diffForHumans()]) }}
                                        @if ($passkey->last_used_at)
                                            · {{ __('Last used :time', ['time' => $passkey->last_used_at->diffForHumans()]) }}
                                        @endif
                                    </p>
                                </div>
                                <x-oc::button variant="ghost" size="sm" command="show-modal" commandfor="delete-passkey-{{ $passkey->id }}">{{ __('Remove') }}</x-oc::button>

                                <x-oc::modal :id="'delete-passkey-'.$passkey->id" :title="__('Remove passkey')" size="sm">
                                    <p>{{ __('Are you sure you want to remove the passkey ":name"? You will no longer be able to use it to sign in.', ['name' => $passkey->name]) }}</p>
                                    <x-slot:footer>
                                        <x-oc::button variant="outline" command="close" :commandfor="'delete-passkey-'.$passkey->id">{{ __('Cancel') }}</x-oc::button>
                                        <form method="POST" action="{{ route('passkey.destroy', $passkey) }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-oc::button type="submit" variant="destructive">{{ __('Remove passkey') }}</x-oc::button>
                                        </form>
                                    </x-slot:footer>
                                </x-oc::modal>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <x-oc::empty-state icon="🔑" :title="__('No passkeys yet')" :text="__('Add a passkey to sign in without a password')" />
                @endif

                <x-passkey-registration />
            </section>
        @endif
        {{-- @end-chisel-passkeys --}}
    </x-pages::settings.layout>
</x-layouts::app>
