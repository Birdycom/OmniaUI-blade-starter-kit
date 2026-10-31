<section class="app-danger-zone">
    <x-oc::heading :title="__('Delete account')" :description="__('Delete your account and all of its resources')" size="sm" />

    <div>
        <x-oc::button variant="destructive" command="show-modal" commandfor="confirm-user-deletion" data-test="delete-user-button">
            {{ __('Delete account') }}
        </x-oc::button>
    </div>

    {{-- Native <dialog>: the button above opens it (command="show-modal"); it opens again by itself after a wrong password. --}}
    <dialog id="confirm-user-deletion" class="oc-modal" closedby="any" aria-labelledby="confirm-user-deletion-title"
        @if ($errors->deleteUser->isNotEmpty()) data-open @endif>
        <form method="POST" action="{{ route('profile.destroy') }}" class="oc-modal-content">
            @csrf
            @method('DELETE')

            <div class="oc-modal-header">
                <h2 class="oc-modal-title" id="confirm-user-deletion-title">{{ __('Are you sure you want to delete your account?') }}</h2>
                <p class="oc-modal-description">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <div class="oc-modal-body">
                <x-oc::password-input id="delete-password" name="password" :label="__('Password')" :show="__('Show')" :hide="__('Hide')" autocomplete="current-password" :error="$errors->deleteUser->has('password')" />
                @error('password', 'deleteUser')
                    <p class="oc-field-error" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="oc-modal-footer">
                <x-oc::button variant="outline" command="close" commandfor="confirm-user-deletion">{{ __('Cancel') }}</x-oc::button>
                <x-oc::button variant="destructive" type="submit" data-test="confirm-delete-user-button">{{ __('Delete account') }}</x-oc::button>
            </div>
        </form>
    </dialog>
    <script>document.querySelector('#confirm-user-deletion[data-open]')?.showModal();</script>
</section>
