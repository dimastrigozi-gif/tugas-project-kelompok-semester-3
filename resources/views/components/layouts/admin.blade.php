<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900">
    <header class="flex min-h-14 items-center border-b border-zinc-200 bg-white px-6">
        <span class="text-lg font-semibold">👑 Super Admin</span>
        <span class="ms-3 text-sm text-zinc-500">{{ $title ?? '' }}</span>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 p-6">
        {{ $slot }}
    </main>
</body>
</html>