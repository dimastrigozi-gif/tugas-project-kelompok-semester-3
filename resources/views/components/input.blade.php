@props([
    'name' => null,
    'label' => null,
    'type' => 'text',
    'value' => null,
])

@php
    $id = $attributes->get('id') ?? ($name ? 'field-'.\Illuminate\Support\Str::slug($name) : null);

    $classes = implode(' ', [
        'min-h-11 w-full rounded-lg border border-zinc-300 bg-white px-3',
        'text-sm text-zinc-900 placeholder:text-zinc-400',
        'focus:border-zinc-900 focus:outline-none focus:ring-2 focus:ring-zinc-900/20',
    ]);

    // Atribut tambahan dari pemanggil (mis. wire:model, autocomplete) diteruskan ke input.
    $input = $attributes->except(['id'])->merge(['class' => $classes]);
@endphp

<div class="grid gap-1.5">
    @if ($label)
        <label for="{{ $id }}" class="text-sm font-medium text-zinc-700">{{ $label }}</label>
    @endif

    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" @if (! is_null($value)) value="{{ $value }}" @endif {{ $input }} />

    @if (isset($errors) && $errors->has($name))
        <p class="text-sm text-red-600">{{ $errors->first($name) }}</p>
    @endif
</div>