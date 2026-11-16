<x-layouts.penyelenggara title="Buat Turnamen">
    <div class="p-6 max-w-2xl">
        <h1 class="text-2xl font-bold mb-4">Buat Turnamen Baru</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('penyelenggara.tournaments.store') }}" class="bg-white p-6 rounded border">
            @csrf
            
            <div class="mb-4">
                <label class="block mb-1">Nama Turnamen</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Pilih Game</label>
                <select name="id_game" class="w-full border p-2 rounded" required>
                    <option value="">-- Pilih Game --</option>
                    @foreach($games as $g)
                        <option value="{{ $g->id }}" {{ old('id_game') == $g->id ? 'selected' : '' }}>
                            {{ $g->nama_game }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Jenis Turnamen</label>
                <select name="jenis_game" class="w-full border p-2 rounded" required>
                    <option value="single_elim">Single Elimination</option>
                    <option value="double_elim">Double Elimination</option>
                    <option value="round_robin">Round Robin</option>
                    <option value="battle_royale">Battle Royale</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Maksimal Peserta</label>
                <input type="number" name="maks_peserta" value="{{ old('maks_peserta', 16) }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Biaya Daftar (Rp)</label>
                <input type="number" name="biaya_daftar" value="{{ old('biaya_daftar', 0) }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Hadiah (Rp)</label>
                <input type="number" name="hadiah" value="{{ old('hadiah', 0) }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Waktu Buka</label>
                <input type="datetime-local" name="waktu_buka" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Waktu Tutup</label>
                <input type="datetime-local" name="waktu_tutup" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" class="w-full border p-2 rounded" rows="3"></textarea>
            </div>

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Simpan Turnamen</button>
            <a href="{{ route('penyelenggara.tournaments.index') }}" class="ml-2 text-gray-600">Batal</a>
        </form>
    </div>
</x-layouts.penyelenggara>