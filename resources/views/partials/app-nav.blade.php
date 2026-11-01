{{-- The app navigation: used by the sidebar layout and by the mobile sheet. Add your own items here. --}}
<x-oc::sidebar.group :label="__('Platform')">
    <x-oc::sidebar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')">
        <x-slot:icon><x-icon name="mdi:view-dashboard-outline" class="oc-sidebar-menu-icon" /></x-slot:icon>
        {{ __('Dashboard') }}
    </x-oc::sidebar.item>
</x-oc::sidebar.group>

<x-oc::sidebar.group separator>
    <x-oc::sidebar.item href="https://github.com/Birdycom/omniaui-blade-starter-kit" target="_blank">
        <x-slot:icon><x-icon name="mdi:github" class="oc-sidebar-menu-icon" /></x-slot:icon>
        {{ __('Repository') }}
    </x-oc::sidebar.item>
    <x-oc::sidebar.item href="https://omniaui.eu/ui/frameworks-laravel" target="_blank">
        <x-slot:icon><x-icon name="mdi:book-open-variant-outline" class="oc-sidebar-menu-icon" /></x-slot:icon>
        {{ __('Documentation') }}
    </x-oc::sidebar.item>
</x-oc::sidebar.group>
