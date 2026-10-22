# Rencana Modul 2 — Bounded Context

## Aktor & Portal

> Catatan: prefix **URL** dan prefix **nama route** bedakan.
> Prefix URL Peserta = `/turnamen`, sedangkan prefix nama route = `peserta.`.

| Aktor | Portal | Fungsi |
|-------|--------|--------|
| Peserta | `/turnamen` | Lihat turnamen, daftar, lihat jadwal |
| Penyelenggara | `/penyelenggara` | Bikin turnamen, verifikasi pendaftar |
| Super Admin | `/admin` | Kelola user, game, sistem |

## Modul (Folder `app/Modules/`)

| # | Modul | Tanggung Jawab | Aktor Pemakai |
|---|-------|----------------|---------------|
| 1 | Admin | Kelola user, game, sistem | Super Admin |
| 2 | Tournament | Bikin & kelola turnamen | Penyelenggara |
| 3 | Registration | Pendaftaran peserta/tim | Peserta |
| 4 | Payment | Pembayaran | Peserta |
| 5 | Match | Jadwal pertandingan | Penyelenggara & Peserta |

## Aturan Dependensi

- Modul **gak boleh akses** tabel internal modul lain langsung
- Komunikasi antar modul **via event** atau **interface/service**
- Model Eloquent tetap di `app/Models/` (shared kernel)
- Layout UI tetap di `resources/views/components/`