{{-- The signed-in user with a menu: settings and log out. Props: id (unique per page), compact (avatar only). --}}
@props(['id' => 'user-menu', 'compact' => false])
@php($user = auth()->user())
<button type="button" popovertarget="{{ $id }}" {{ $attributes->class(['oc-sidebar-menu-button oc-sidebar-menu-button--lg' => ! $compact, 'oc-btn oc-btn--ghost oc-btn--icon' => $compact]) }} data-test="sidebar-menu-button" aria-label="{{ __('User menu') }}">
    @if ($compact)
        <span class="oc-avatar oc-avatar--sm">{{ $user->initials() }}</span>
    @else
        <x-oc::user :name="$user->name" :email="$user->email" :initials="$user->initials()" size="sm" />
        <x-icon name="chevrons" class="ml-auto" width="16" height="16" />
    @endif
</button>
<div class="oc-dropdown-menu app-user-menu" id="{{ $id }}" popover>
    <div class="oc-dropdown-label">
        <x-oc::user :name="$user->name" :email="$user->email" :initials="$user->initials()" size="sm" />
    </div>
    <div class="oc-dropdown-separator"></div>
    <a class="oc-dropdown-item" href="{{ route('profile.edit') }}"><x-icon name="settings" width="16" height="16" /> {{ __('Settings') }}</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="oc-dropdown-item w-full" data-test="logout-button"><x-icon name="logout" width="16" height="16" /> {{ __('Log out') }}</button>
    </form>
</div>
