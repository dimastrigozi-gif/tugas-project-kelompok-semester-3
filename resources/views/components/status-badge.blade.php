@props([
    'status' => 'active',
    'label' => null,
])

@php
    $palette = [
        'active' => ['label' => 'Aktif', 'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20'],
        'pending' => ['label' => 'Menunggu', 'class' => 'bg-amber-50 text-amber-700 ring-amber-600/20'],
        'suspended' => ['label' => 'Ditangguhkan', 'class' => 'bg-red-50 text-red-700 ring-red-600/20'],
        'rejected' => ['label' => 'Ditolak', 'class' => 'bg-zinc-100 text-zinc-700 ring-zinc-600/20'],
    ];

    $current = $palette[$status] ?? ['label' => ucfirst((string) $status), 'class' => 'bg-zinc-100 text-zinc-700 ring-zinc-600/20'];

    $classes = implode(' ', [
        'inline-flex min-h-6 items-center rounded-full px-2.5 py-0.5',
        'text-xs font-medium ring-1 ring-inset',
        $current['class'],
    ]);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>{{ $label ?? $current['label'] }}</span>