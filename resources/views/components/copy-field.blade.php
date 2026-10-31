{{-- Read-only value with a copy button (OmniaUI copy-field markup). Alpine does the copying, so it also works inside
     content that Livewire renders later, such as a modal. Props: value, label (aria-label). --}}
@props(['value', 'label' => __('Value')])
<div {{ $attributes->class(['oc-copy-field']) }} x-data="{ copied: false }">
    <input class="oc-copy-field-value" type="text" readonly value="{{ $value }}" aria-label="{{ $label }}">
    <button class="oc-copy-field-button" type="button" x-bind:class="{ 'is-copied': copied }"
        x-on:click="navigator.clipboard.writeText($el.previousElementSibling.value).then(() => { copied = true; setTimeout(() => copied = false, 1500) })">
        <span x-show="!copied">{{ __('Copy') }}</span>
        <span x-show="copied" x-cloak>{{ __('Copied') }}</span>
    </button>
</div>
