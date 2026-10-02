<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900">
    <div class="flex min-h-screen flex-col lg:flex-row">
        <aside class="w-full shrink-0 border-b border-zinc-200 bg-white p-4 lg:h-screen lg:w-64 lg:border-b-0 lg:border-r">
            <div class="mb-6 text-lg font-semibold">🏆 Penyelenggara</div>
            <nav class="flex flex-col gap-1 text-sm lg:max-w-56">
                <a href="{{ route('penyelenggara.dashboard') }}" class="inline-flex min-h-11 items-center rounded-lg bg-zinc-100 px-3 font-medium">
                    Dashboard
                </a>
                <span class="inline-flex min-h-11 items-center px-3 text-zinc-400">Turnamen (soon)</span>
                <span class="inline-flex min-h-11 items-center px-3 text-zinc-400">Pendaftar (soon)</span>
            </nav>
        </aside>

        <div class="flex flex-1 flex-col">
            <header class="flex min-h-14 items-center border-b border-zinc-200 bg-white px-6">
                <span class="font-semibold">{{ $title ?? 'Dashboard' }}</span>
            </header>
            <main class="flex-1 p-4 lg:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>