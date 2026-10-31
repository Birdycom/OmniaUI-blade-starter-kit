<?php

namespace App\Http\Controllers\Settings;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use PasswordValidationRules;
    use ProfileValidationRules;

    /**
     * Show the profile settings page.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('pages::settings.profile', [
            'user' => $user,
            /* @chisel-email-verification */
            'hasUnverifiedEmail' => $user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail(),
            'showDeleteUser' => ! $user instanceof MustVerifyEmail || $user->hasVerifiedEmail(),
            /* @end-chisel-email-verification */
        ]);
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validate($this->profileRules($user->id)));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return to_route('profile.edit')->with('status', __('Profile updated.'));
    }

    /**
     * Delete the currently authenticated user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('deleteUser', [
            'password' => $this->currentPasswordRules(),
        ]);

        $user = $request->user();

        Auth::guard('web')->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
