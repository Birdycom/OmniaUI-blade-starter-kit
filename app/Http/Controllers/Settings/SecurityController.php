<?php

namespace App\Http\Controllers\Settings;

use App\Concerns\PasswordValidationRules;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;

class SecurityController extends Controller
{
    use PasswordValidationRules;

    /**
     * Show the security settings page: password, two-factor authentication and passkeys.
     *
     * Two-factor setup runs over several requests (Fortify enables it, this page shows the QR code, the user confirms
     * with a code). A setup that was left unconfirmed is cleared on the next visit, unless this request is the one
     * right after enabling.
     */
    public function edit(Request $request, DisableTwoFactorAuthentication $disableTwoFactorAuthentication): View
    {
        $user = $request->user();
        $data = ['canManageTwoFactor' => false, 'canManagePasskeys' => false];

        /* @chisel-2fa */
        $data['canManageTwoFactor'] = Features::canManageTwoFactorAuthentication();

        if ($data['canManageTwoFactor']) {
            $justEnabled = $request->session()->get('status') === Fortify::TWO_FACTOR_AUTHENTICATION_ENABLED;

            if (Fortify::confirmsTwoFactorAuthentication() && is_null($user->two_factor_confirmed_at) && ! $justEnabled) {
                $disableTwoFactorAuthentication($user);
                $user->refresh();
            }

            $data['twoFactorEnabled'] = $user->hasEnabledTwoFactorAuthentication();
            $data['settingUp'] = $user->two_factor_secret && ! $data['twoFactorEnabled'];
            $data['qrCodeSvg'] = $data['settingUp'] ? $user->twoFactorQrCodeSvg() : null;
            $data['setupKey'] = $data['settingUp'] ? decrypt($user->two_factor_secret) : null;
            $data['recoveryCodes'] = $data['twoFactorEnabled'] && $user->two_factor_recovery_codes
                ? json_decode(decrypt($user->two_factor_recovery_codes), true)
                : [];
        }
        /* @end-chisel-2fa */

        /* @chisel-passkeys */
        $data['canManagePasskeys'] = Features::canManagePasskeys();
        $data['passkeys'] = $data['canManagePasskeys'] ? $user->passkeys()->latest()->get() : collect();
        /* @end-chisel-passkeys */

        return view('pages::settings.security', $data);
    }

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => $this->currentPasswordRules(),
            'password' => $this->passwordRules(),
        ]);

        $request->user()->update(['password' => $validated['password']]);

        return to_route('security.edit')->with('status', __('Password updated.'));
    }
}
