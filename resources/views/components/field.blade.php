{{-- Label + OmniaUI input + validation error. Props: name, label, description, id, value. Other attributes go to the
     input (type, required, autocomplete, wire:model …). After a failed form post the old value is filled in again. --}}
@props(['name', 'label' => null, 'description' => null, 'id' => null, 'value' => null])
@php
    $id ??= 'field-'.str_replace(['.', '[', ']'], '-', $name);
    $bound = $attributes->whereStartsWith('wire:model')->isNotEmpty();
@endphp
<x-oc::form-field :label="$label" :for="$id" :description="$description" :name="$name">
    @if ($bound)
        <x-oc::input :name="$name" :id="$id" {{ $attributes }} />
    @else
        <x-oc::input :name="$name" :id="$id" :value="old($name, $value)" {{ $attributes }} />
    @endif
</x-oc::form-field>
