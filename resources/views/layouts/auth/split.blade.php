<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body>
        {{-- OmniaUI auth-split block: brand panel with a quote next to the form (one column below 62rem). --}}
        <div class="oc-block-authsplit">
            <aside class="oc-block-authsplit-brand">
                <a class="oc-block-authsplit-logo" href="{{ route('home') }}">
                    <x-app-logo-icon width="28" height="28" /> {{ config('app.name', 'Laravel') }}
                </a>
                @php
                    [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                @endphp
                <blockquote class="oc-block-authsplit-quote">
                    <p>&ldquo;{{ trim($message) }}&rdquo;</p>
                    <footer>{{ trim($author) }}</footer>
                </blockquote>
            </aside>
            <div class="oc-block-authsplit-form">
                <div class="oc-block-authsplit-card">{{ $slot }}</div>
            </div>
        </div>
    </body>
</html>
