@props([
    'variant' => 'primary',
    'type' => 'button',
    'href' => null,
])

@php
    $variants = [
        'primary' => 'bg-zinc-900 text-white hover:bg-zinc-800 focus-visible:outline-zinc-900',
        'secondary' => 'border border-zinc-300 bg-white text-zinc-900 hover:bg-zinc-50 focus-visible:outline-zinc-900',
        'danger' => 'bg-red-600 text-white hover:bg-red-500 focus-visible:outline-red-600',
    ];

    $classes = implode(' ', [
        'inline-flex min-h-11 items-center justify-center gap-2 rounded-lg px-4',
        'text-sm font-medium transition',
        'focus-visible:outline-2 focus-visible:outline-offset-2',
        'disabled:pointer-events-none disabled:opacity-50',
        $variants[$variant] ?? $variants['primary'],
    ]);
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif