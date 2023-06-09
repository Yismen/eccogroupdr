@props([
'type' => 'text',
'required' => true,
'field',
])
<div class="mb-3">
    {{ $slot }}

    <input type="{{ $type }}" id="{{ $field }}" aria-describedby="{{ $field }}Help" wire:model='{{ $field }}' {{
        $attributes->class([
    'form-control',
    'is-invalid' => $errors->has($field)
    ])->merge([
    ]) }}
    >

    <x-support::inputs.error :field="$field" />
</div>