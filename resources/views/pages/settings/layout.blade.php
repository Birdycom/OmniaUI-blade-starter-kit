@php
    $links = [
        ['profile.edit', __('Profile'), 'user'],
        ['security.edit', __('Security'), 'shield'],
        ['appearance.edit', __('Appearance'), 'palette'],
    ];
@endphp
<div class="app-settings">
    <nav aria-label="{{ __('Settings') }}">
        <ul class="oc-nav-list">
            @foreach ($links as [$route, $label, $icon])
                <li>
                    <a @class(['oc-nav-item-link app-nav-link', 'is-active' => request()->routeIs($route)]) href="{{ route($route) }}" @if (request()->routeIs($route)) aria-current="page" @endif>
                        <x-icon :name="$icon" width="16" height="16" /> {{ $label }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="app-settings-body">
        <x-oc::heading :title="$heading ?? ''" :description="$subheading ?? ''" />
        <div class="app-settings-content">
            {{ $slot }}
        </div>
    </div>
</div>
