<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head', ['title' => __('Welcome')])
    </head>
    <body class="app-welcome">
        @php($start = auth()->check() ? route('dashboard') : (Route::has('register') ? route('register') : route('login')))

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
            {{-- Hero: the pitch on the left, the install commands on the right. --}}
            <section class="oc-section-pad">
                <div class="oc-container oc-split">
                    <div>
                        <p class="oc-eyebrow">Laravel {{ app()->version() }} · Blade · OmniaUI</p>
                        <h1 class="oc-display">{{ __('Your app starts') }} <span class="oc-text-gradient">{{ __('here') }}</span>.</h1>
                        <p class="oc-lead">{{ __('Sign-in, two-factor, passkeys and settings are ready. Every screen is built with OmniaCSS utilities and OmniaUI components: no Tailwind, and only the CSS your views use.') }}</p>
                        <div class="flex flex-wrap gap-1 mt-2">
                            <x-oc::button :href="$start" size="lg">{{ __('Get started') }}</x-oc::button>
                            <x-oc::button href="https://omniaui.eu/ui/components" variant="outline" size="lg" target="_blank" rel="noopener noreferrer">{{ __('Browse components') }}</x-oc::button>
                        </div>
                    </div>
                    <div class="app-welcome-code">
                        <span class="oc-icon-tile oc-icon-tile--float oc-accent--green" aria-hidden="true"><x-icon name="mdi:shield-check-outline" /></span>
                        <span class="oc-icon-tile oc-icon-tile--float oc-accent--violet" aria-hidden="true"><x-icon name="mdi:fingerprint" /></span>
                        <span class="oc-icon-tile oc-icon-tile--float oc-accent--orange" aria-hidden="true"><x-icon name="mdi:palette-outline" /></span>
                        <div class="oc-code-window">
                            <div class="oc-code-window__bar"><i></i><i></i><i></i><span class="oc-code-window__title">terminal</span></div>
<pre class="oc-code-window__body">$ laravel new my-app \
    --using=birdycom/omniaui-blade-starter-kit
$ cd my-app && composer run dev

  ✓ sign-in, two-factor, passkeys
  ✓ profile, password, appearance
  ✓ 35 tests pass</pre>
                        </div>
                    </div>
                </div>
            </section>

            <div class="oc-container">
                <div class="oc-block-stats">
                    <div class="oc-block-stat"><div class="oc-block-stat-value">0</div><div class="oc-block-stat-label">{{ __('Tailwind classes') }}</div></div>
                    <div class="oc-block-stat"><div class="oc-block-stat-value">&lt; 15 kB</div><div class="oc-block-stat-label">{{ __('CSS for the whole app, gzipped') }}</div></div>
                    <div class="oc-block-stat"><div class="oc-block-stat-value">100+</div><div class="oc-block-stat-label">{{ __('OmniaUI components') }}</div></div>
                    <div class="oc-block-stat"><div class="oc-block-stat-value">MIT</div><div class="oc-block-stat-label">{{ __('Free to use') }}</div></div>
                </div>
            </div>

            <x-oc::block.features>
                <x-slot:title>{{ __('Everything a new app needs') }}</x-slot:title>
                <x-slot:text>{{ __('The boring parts are done, tested and styled, so you can start on what makes your app different.') }}</x-slot:text>
                @foreach ([
                    ['mdi:account-lock-outline', __('Authentication'), __('Log in, register, forgot and reset password, e-mail verification.')],
                    ['mdi:shield-check-outline', __('Two-factor'), __('Authenticator apps with QR code setup and recovery codes.')],
                    ['mdi:fingerprint', __('Passkeys'), __('Sign in with Face ID, Touch ID or a security key.')],
                    ['mdi:cog-outline', __('Settings'), __('Profile, password, appearance and account deletion.')],
                    ['mdi:theme-light-dark', __('Light and dark'), __('Follows the system, or the choice saved in the settings.')],
                    ['material-symbols:interests-outline', __('Webicons'), __('MDI, Material Symbols, flags, spinners and more: only the icons you use are bundled.')],
                ] as [$icon, $title, $text])
                    <div class="oc-block-feature-card">
                        <div class="oc-block-feature-icon"><x-icon :name="$icon" /></div>
                        <h3>{{ $title }}</h3>
                        <p>{{ $text }}</p>
                    </div>
                @endforeach
            </x-oc::block.features>

            <section class="oc-section-pad oc-section-pad--tight">
                <div class="oc-container">
                    <p class="oc-eyebrow">{{ __('Make it yours') }}</p>
                    <h2 class="oc-display oc-display--md">{{ __('From install to') }} <span class="oc-text-gradient">{{ __('launch') }}</span>.</h2>
                    <ol class="oc-steps">
                        <li><h3>{{ __('Install') }}</h3><p>{{ __('One laravel new command, then composer run dev.') }}</p></li>
                        <li><h3>{{ __('Brand it') }}</h3><p>{{ __('Change colors, radius and font in resources/css/theme.css.') }}</p></li>
                        <li><h3>{{ __('Add blocks') }}</h3><p>{{ __('Pricing, FAQ or a dashboard: npx omniaui add and done.') }}</p></li>
                        <li><h3>{{ __('Ship') }}</h3><p>{{ __('The build keeps only the CSS your views use.') }}</p></li>
                    </ol>
                </div>
            </section>

            <x-oc::block.faq>
                <x-slot:lead>{{ __('Short answers to what people ask first.') }}</x-slot:lead>
                <x-slot:more>{{ __('More questions?') }} <a class="oc-link-arrow" href="https://omniacss.eu/docs/" target="_blank" rel="noopener noreferrer">{{ __('Read the docs') }}</a></x-slot:more>
                <details class="oc-accordion-item" name="oc-faq" open>
                    <summary class="oc-accordion-trigger">{{ __('Do I need Tailwind?') }}</summary>
                    <div class="oc-accordion-content">{{ __('No. OmniaCSS generates the utilities and OmniaUI brings the components. Tailwind class names can mean something else here (w-5 is 5rem), so do not mix them.') }}</div>
                </details>
                <details class="oc-accordion-item" name="oc-faq">
                    <summary class="oc-accordion-trigger">{{ __('Where do the icons come from?') }}</summary>
                    <div class="oc-accordion-content">{{ __('From the OmniaCSS webicons: Material Design Icons and MDI Light, Material Symbols, SVG Spinners, Flags and VSCode Icons. Name an icon in a view and the build bundles it: nothing is loaded from another server.') }}</div>
                </details>
                <details class="oc-accordion-item" name="oc-faq">
                    <summary class="oc-accordion-trigger">{{ __('How do I change the look?') }}</summary>
                    <div class="oc-accordion-content">{{ __('Edit the theme tokens in resources/css/theme.css. Every component reads them, in light and in dark mode.') }}</div>
                </details>
                <details class="oc-accordion-item" name="oc-faq">
                    <summary class="oc-accordion-trigger">{{ __('Is it free?') }}</summary>
                    <div class="oc-accordion-content">{{ __('Yes. The kit, OmniaCSS and OmniaUI are free. OmniaUI Pro adds extra blocks if you want them.') }}</div>
                </details>
            </x-oc::block.faq>

            <section class="app-welcome-links" aria-label="{{ __('Resources') }}">
                <a class="oc-card app-welcome-link" href="https://omniaui.eu/ui/frameworks-laravel" target="_blank" rel="noopener noreferrer">
                    <div class="oc-card-header">
                        <h2 class="oc-card-title">{{ __('Laravel guide') }}</h2>
                        <p class="oc-card-description">{{ __('Blade components, Livewire variants and the omniacss:install command.') }}</p>
                    </div>
                </a>
                <a class="oc-card app-welcome-link" href="https://omniaui.eu/ui/blocks" target="_blank" rel="noopener noreferrer">
                    <div class="oc-card-header">
                        <h2 class="oc-card-title">{{ __('Blocks') }}</h2>
                        <p class="oc-card-description">{{ __('Dashboards, pricing, sign-in screens: add one with npx omniaui add.') }}</p>
                    </div>
                </a>
                <a class="oc-card app-welcome-link" href="https://omniacss.eu/docs/ai" target="_blank" rel="noopener noreferrer">
                    <div class="oc-card-header">
                        <h2 class="oc-card-title">{{ __('AI assistants') }}</h2>
                        <p class="oc-card-description">{{ __('The OmniaCSS MCP server gives Claude, Cursor and Copilot the real classes.') }}</p>
                    </div>
                </a>
            </section>

            <x-oc::block.cta>
                <x-slot:title>{{ __('Ready to build?') }}</x-slot:title>
                <x-slot:text>{{ __('Create an account and look around: every screen in this kit is yours to change.') }}</x-slot:text>
                <x-slot:actions>
                    <x-oc::button :href="$start" size="lg">{{ __('Get started') }}</x-oc::button>
                </x-slot:actions>
            </x-oc::block.cta>
        </main>

        <footer class="app-welcome-footer">
            <span>&copy; {{ date('Y') }} {{ config('app.name') }}</span>
            <span>{{ __('Built with') }} <a class="oc-link" href="https://omniacss.eu" target="_blank" rel="noopener noreferrer">OmniaCSS</a> {{ __('and') }} <a class="oc-link" href="https://omniaui.eu" target="_blank" rel="noopener noreferrer">OmniaUI</a></span>
        </footer>
    </body>
</html>
