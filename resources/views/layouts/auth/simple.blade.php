<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="app-auth">
        <div class="app-auth-column">
            <a href="{{ route('home') }}" class="app-auth-logo">
                <x-app-logo-icon />
                <span class="oc-visually-hidden">{{ config('app.name', 'Laravel') }}</span>
            </a>
            {{ $slot }}
        </div>
    </body>
</html>
