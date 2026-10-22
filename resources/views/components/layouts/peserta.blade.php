<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900">
    {{-- Header --}}
    <header class="sticky top-0 z-10 flex min-h-14 items-center border-b border-zinc-200 bg-white px-4">
        <span class="text-base font-semibold">🎮 Turnamen Esport</span>
    </header>

    {{-- Konten --}}
    <main class="mx-auto max-w-2xl p-4">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="border-t border-zinc-200 p-4 text-center text-xs text-zinc-500">
        Turnamen Esport &copy; {{ date('Y') }}
    </footer>
</body>
</html>