@props([
    'sidebar' => false,
])

<a {{ $attributes->class(['oc-sidebar-menu-button oc-sidebar-menu-button--lg' => $sidebar, 'app-brand' => ! $sidebar]) }}>
    <span class="app-brand-mark"><x-app-logo-icon /></span>
    <span class="oc-sidebar-menu-label font-semibold">{{ config('app.name', 'Laravel') }}</span>
</a>
