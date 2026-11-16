<x-layouts.penyelenggara title="Daftar Turnamen">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Daftar Turnamen</h1>
            <a href="{{ route('penyelenggara.tournaments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Buat Turnamen
            </a>
        </div>

        @if(session('status'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white rounded border">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-3">Nama Turnamen</th>
                        <th class="p-3">Game</th>
                        <th class="p-3">Biaya</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tournaments as $t)
                        <tr class="border-b">
                            <td class="p-3">{{ $t->nama }}</td>
                            <td class="p-3">{{ $t->game->nama_game ?? '-' }}</td>
                            <td class="p-3">Rp {{ number_format($t->biaya_daftar, 0, ',', '.') }}</td>
                            <td class="p-3">{{ $t->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-gray-500">Belum ada turnamen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.penyelenggara>