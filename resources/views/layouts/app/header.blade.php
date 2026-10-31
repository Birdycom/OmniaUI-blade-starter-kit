<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body>
        {{-- Alternative layout: navigation in a top bar instead of a sidebar. Use it in layouts/app.blade.php. --}}
        <header class="oc-block-appbar app-topbar">
            <button class="oc-btn oc-btn--ghost oc-btn--icon app-mobile-only" type="button" command="show-modal" commandfor="app-mobile-nav" aria-label="{{ __('Open menu') }}">
                <x-icon name="menu" />
            </button>
            <x-app-logo href="{{ route('dashboard') }}" />
            <nav class="oc-block-appbar-nav app-desktop-only" aria-label="{{ __('Main navigation') }}">
                <ul class="oc-navmenu">
                    <li><a class="oc-navmenu-link" href="{{ route('dashboard') }}" @if (request()->routeIs('dashboard')) aria-current="page" @endif>{{ __('Dashboard') }}</a></li>
                </ul>
            </nav>
            <div class="oc-block-appbar-actions">
                <a class="oc-btn oc-btn--ghost oc-btn--icon app-desktop-only" href="https://github.com/Birdycom/omniaui-livewire-starter-kit" target="_blank" title="{{ __('Repository') }}"><x-icon name="folder-git" /></a>
                <a class="oc-btn oc-btn--ghost oc-btn--icon app-desktop-only" href="https://omniaui.eu/ui/frameworks-laravel" target="_blank" title="{{ __('Documentation') }}"><x-icon name="book" /></a>
                <x-user-menu id="user-menu-header" compact />
            </div>
        </header>

        <main class="app-page">
            {{ $slot }}
        </main>

        <x-oc::sheet id="app-mobile-nav" side="left" :title="config('app.name', 'Laravel')" :close="__('Close')">
            <nav class="oc-sidebar app-sheet-nav" aria-label="{{ __('Main navigation') }}">
                <div class="oc-sidebar-content">@include('partials.app-nav')</div>
            </nav>
        </x-oc::sheet>
    </body>
</html>
