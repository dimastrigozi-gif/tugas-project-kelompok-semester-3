# Aturan Isolasi Data (Multi-Tenancy)

## 1. Tabel yang WAJIB Dikunci (Tenant-Owned)
Tabel ini cuma boleh diakses oleh Penyelenggara pemiliknya (atau peserta yang terlibat):
- `tournaments` (dikunci pakai `id_penyelenggara`)
- `matches` (dikunci lewat relasi `id_turnamen`)
- `registrations` (dikunci lewat relasi `id_turnamen`)
- `payments` (dikunci lewat relasi `id_pendaftaran` -> `registrations`)

## 2. Tabel yang Boleh Dilihat Semua Orang (Platform-Scoped)
Tabel ini datanya publik, gak masalah kalau dilihat siapa aja:
- `games` (daftar game)
- `users` (profil dasar)
- `teams` (daftar tim yang terdaftar)

## 3. Jalur Bypass (Lewat Pagar)
Aplikasi kita punya halaman publik (peserta lihat daftar turnamen). 
Halaman ini BOLEH nembus pagar isolasi, TAPI wajib dikasih filter: 
"Hanya tampilkan turnamen yang statusnya `buka` (atau berjalan), jangan tampilkan yang masih `draft`."