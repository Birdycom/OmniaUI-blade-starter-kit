<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="app-auth app-auth--muted">
        <div class="app-auth-column app-auth-column--wide">
            <a href="{{ route('home') }}" class="app-auth-logo">
                <x-app-logo-icon />
                <span class="oc-visually-hidden">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <div class="oc-card">
                <div class="oc-card-content app-auth-card">{{ $slot }}</div>
            </div>
        </div>
    </body>
</html>
