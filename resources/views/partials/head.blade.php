<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

{{-- Appearance (Settings > Appearance): light, dark or the system setting, remembered in this browser. Runs before
     the CSS so the page never flashes in the wrong theme. OmniaUI follows data-theme on <html>. --}}
<script>
    (() => {
        const theme = localStorage.getItem('appearance');
        if (theme === 'light' || theme === 'dark') document.documentElement.dataset.theme = theme;
    })();
</script>

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])
