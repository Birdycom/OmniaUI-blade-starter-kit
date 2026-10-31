<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head', ['title' => __('Welcome')])
    </head>
    <body class="app-welcome">
        <header class="app-welcome-bar">
            <x-app-logo href="{{ route('home') }}" />
            @if (Route::has('login'))
                <nav class="flex gap-0.5" aria-label="{{ __('Account') }}">
                    @auth
                        <x-oc::button :href="route('dashboard')" variant="outline" size="sm">{{ __('Dashboard') }}</x-oc::button>
                    @else
                        <x-oc::button :href="route('login')" variant="ghost" size="sm">{{ __('Log in') }}</x-oc::button>
                        @if (Route::has('register'))
                            <x-oc::button :href="route('register')" size="sm">{{ __('Register') }}</x-oc::button>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main>
            <x-oc::block.hero>
                <x-slot:badge>Laravel {{ app()->version() }} · Livewire · OmniaUI</x-slot:badge>
                <x-slot:title>{{ __('Your app starts here') }}</x-slot:title>
                <x-slot:text>{{ __('Sign-in, two-factor, passkeys and settings are ready. Every screen is built with OmniaCSS utilities and OmniaUI components: no Tailwind, and only the CSS your views use.') }}</x-slot:text>
                <x-slot:actions>
                    <x-oc::button :href="Route::has('register') ? route('register') : route('login')" size="lg">{{ __('Get started') }}</x-oc::button>
                    <x-oc::button href="https://omniaui.eu/ui/components" variant="outline" size="lg" target="_blank">{{ __('Browse components') }}</x-oc::button>
                </x-slot:actions>
            </x-oc::block.hero>

            <section class="app-welcome-links" aria-label="{{ __('Resources') }}">
                <a class="oc-card app-welcome-link" href="https://omniaui.eu/ui/frameworks-laravel" target="_blank">
                    <div class="oc-card-header">
                        <h2 class="oc-card-title">{{ __('Laravel guide') }}</h2>
                        <p class="oc-card-description">{{ __('Blade components, Livewire variants and the omniacss:install command.') }}</p>
                    </div>
                </a>
                <a class="oc-card app-welcome-link" href="https://omniaui.eu/ui/blocks" target="_blank">
                    <div class="oc-card-header">
                        <h2 class="oc-card-title">{{ __('Blocks') }}</h2>
                        <p class="oc-card-description">{{ __('Dashboards, pricing, sign-in screens: add one with npx omniaui add.') }}</p>
                    </div>
                </a>
                <a class="oc-card app-welcome-link" href="https://omniacss.eu/docs/ai" target="_blank">
                    <div class="oc-card-header">
                        <h2 class="oc-card-title">{{ __('AI assistants') }}</h2>
                        <p class="oc-card-description">{{ __('The OmniaCSS MCP server gives Claude, Cursor and Copilot the real classes.') }}</p>
                    </div>
                </a>
            </section>
        </main>
    </body>
</html>
