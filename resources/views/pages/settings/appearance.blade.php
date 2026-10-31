<x-layouts::app :title="__('Appearance settings')">
    @include('partials.settings-heading')

    <x-pages::settings.layout :heading="__('Appearance')" :subheading="__('Update the appearance settings for your account')">
        {{-- OmniaUI segmented control. The choice is kept in this browser (localStorage) and applied as data-theme on
             <html> by partials/head.blade.php; "System" follows the operating system. --}}
        <div
            class="oc-segmented"
            role="radiogroup"
            aria-label="{{ __('Appearance') }}"
            x-data="{
                theme: localStorage.getItem('appearance') || 'system',
                apply() {
                    localStorage.setItem('appearance', this.theme);
                    if (this.theme === 'system') delete document.documentElement.dataset.theme;
                    else document.documentElement.dataset.theme = this.theme;
                },
            }"
        >
            @foreach (['light' => __('Light'), 'dark' => __('Dark'), 'system' => __('System')] as $value => $label)
                <label class="oc-segmented-item">
                    <input type="radio" name="appearance" value="{{ $value }}" x-model="theme" x-on:change="apply()">
                    {{ $label }}
                </label>
            @endforeach
        </div>
    </x-pages::settings.layout>
</x-layouts::app>
