@props([
    'status',
])

@if ($status)
    <div {{ $attributes->class(['oc-alert oc-alert--success']) }} role="status">
        <p class="oc-alert-description">{{ $status }}</p>
    </div>
@endif
