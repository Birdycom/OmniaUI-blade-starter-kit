@php
    $links = [
        ['profile.edit', __('Profile'), 'mdi:account-outline'],
        ['security.edit', __('Security'), 'mdi:shield-check-outline'],
        ['appearance.edit', __('Appearance'), 'mdi:palette-outline'],
    ];
@endphp
<div class="app-settings">
    <nav aria-label="{{ __('Settings') }}">
        <ul class="oc-nav-list">
            @foreach ($links as [$route, $label, $icon])
                <li>
                    <a @class(['oc-nav-item-link app-nav-link', 'is-active' => request()->routeIs($route)]) href="{{ route($route) }}" @if (request()->routeIs($route)) aria-current="page" @endif>
                        <x-icon :name="$icon" class="h-1 w-1" /> {{ $label }}
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
