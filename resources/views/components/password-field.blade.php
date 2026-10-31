{{-- Password with show/hide button + validation error. Props: name, label, id, rules (adds the passwordrules hint
     for password managers). Other attributes go to the input (required, autocomplete, wire:model …). --}}
@props(['name' => 'password', 'label' => null, 'id' => null, 'rules' => false])
@php
    $id ??= 'field-'.$name;
    $extra = $rules ? ['passwordrules' => \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString()] : [];
@endphp
<div class="app-field">
    <x-oc::password-input :name="$name" :id="$id" :label="$label" :show="__('Show')" :hide="__('Hide')" :error="$errors->has($name)" {{ $attributes->merge($extra) }} />
    @error($name)
        <p class="oc-field-error" role="alert">{{ $message }}</p>
    @enderror
</div>
