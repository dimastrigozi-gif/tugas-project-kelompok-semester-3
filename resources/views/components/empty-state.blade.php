@props([
    'title' => null,
    'description' => null,
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-zinc-300 bg-white/60 px-6 py-12 text-center']) }}>
    @if ($icon)
        <div class="mb-1 text-3xl" aria-hidden="true">{{ $icon }}</div>
    @endif

    @if ($title)
        <h3 class="text-base font-semibold text-zinc-900">{{ $title }}</h3>
    @endif

    @if ($description)
        <p class="max-w-sm text-sm text-zinc-500">{{ $description }}</p>
    @endif

    @unless ($slot->isEmpty())
        <div class="mt-2 flex flex-wrap items-center justify-center gap-2">
            {{ $slot }}
        </div>
    @endunless
</div>