{{-- An OmniaCSS webicon: <x-icon name="mdi:cog-outline" /> (also mdi-light:, material-symbols:, svg-spinners:, flag:, vscode-icons:). Find names on omniaui.eu/ui/webicons.
     vite-icons.js bundles every "<set>:<name>" written in resources/. 1.25rem unless a class sizes it (h-1 w-1, oc-sidebar-menu-icon). --}}
@props(['name'])
<iconify-icon icon="{{ $name }}" height="unset" aria-hidden="true" {{ $attributes }}></iconify-icon>
