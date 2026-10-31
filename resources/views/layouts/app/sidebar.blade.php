<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body>
        {{-- OmniaUI app shell: sidebar + header bar + scrolling content. The toggle collapses the sidebar to icons
             (CSS only); below 48rem the sidebar moves into the sheet opened by the menu button. --}}
        <div class="oc-block-shell">
            <input class="oc-block-shell-toggle" type="checkbox" id="app-sidebar-toggle" aria-label="{{ __('Collapse sidebar') }}">

            <x-oc::sidebar :label="__('Main navigation')">
                <x-slot:header>
                    <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" />
                </x-slot:header>

                @include('partials.app-nav')

                <x-slot:footer>
                    <x-user-menu id="user-menu-sidebar" />
                </x-slot:footer>
            </x-oc::sidebar>

            <div class="oc-block-shell-main">
                <header class="oc-block-appbar">
                    <button class="oc-btn oc-btn--ghost oc-btn--icon oc-block-shell-menu-button" type="button" command="show-modal" commandfor="app-mobile-nav" aria-label="{{ __('Open menu') }}">
                        <x-icon name="menu" />
                    </button>
                    <label class="oc-btn oc-btn--ghost oc-btn--icon app-collapse" for="app-sidebar-toggle" title="{{ __('Collapse sidebar') }}">
                        <x-icon name="menu" /><span class="oc-visually-hidden">{{ __('Collapse sidebar') }}</span>
                    </label>
                    <strong class="app-appbar-title">{{ $title ?? '' }}</strong>
                    <div class="oc-block-appbar-actions">
                        <x-user-menu id="user-menu-appbar" compact class="app-mobile-only" />
                    </div>
                </header>

                <main class="oc-block-shell-content">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <x-oc::sheet id="app-mobile-nav" side="left" :title="config('app.name', 'Laravel')" :close="__('Close')">
            <nav class="oc-sidebar app-sheet-nav" aria-label="{{ __('Main navigation') }}">
                <div class="oc-sidebar-content">@include('partials.app-nav')</div>
            </nav>
        </x-oc::sheet>
    </body>
</html>
