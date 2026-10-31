{{-- Switch to the top-bar layout: replace layouts::app.sidebar with layouts::app.header. --}}
<x-layouts::app.sidebar :title="$title ?? null">
    {{ $slot }}
</x-layouts::app.sidebar>
