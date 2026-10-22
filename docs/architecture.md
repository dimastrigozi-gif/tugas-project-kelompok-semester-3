# Arsitektur — Sistem Informasi & Tata Kelola Turnamen Esport

Acuan teknis Modul 2: fondasi **modular monolith**.
Pemetaan bounded context: [`rencana-modul-2.md`](./rencana-modul-2.md)

---

## 1. Gaya Arsitektur

Satu aplikasi Laravel, tapi kode dipecah menjadi 5 bounded context terpisah.
Tiap modul punya folder, namespace, provider, route, dan view sendiri, sehingga
bisa diekstrak jadi microservice tanpa mengubah pola pemanggil.

```
app/
├── Modules/
│   ├── ModuleServiceProvider.php      <- base class abstrak semua modul
│   ├── Admin/                         <- alias: admin
│   ├── Tournament/                    <- alias: tournament
│   ├── Registration/                  <- alias: registration
│   ├── Payment/                       <- alias: payment
│   └── Match/                         <- alias: match
├── Http/Middleware/                   <- middleware lintas portal
├── Models/                            <- shared kernel
└── Support/Routing/PortalRoutes.php   <- definisi tunggal grup route per portal
```

Struktur wajib di tiap folder modul:

| Subfolder | Isi |
|-----------|-----|
| `Actions/` | Use case / orkestrasi satu alur bisnis (satu class = satu aksi) |
| `Data/` | Akses data & query internal modul |
| `Services/` | Logika domain yang dipakai lintas action dalam modul yang sama |
| `Http/Controllers/` | Entry point HTTP milik modul itu sendiri |
| `routes/` | File route modul, dimuat otomatis oleh provider |
| `resources/views/` | View modul (namespace view = alias modul) |
| `resources/views/livewire/` | Komponen Livewire modul |

---

## 2. Diagram Dependensi Antar Modul

Modul **tidak boleh saling memanggil secara langsung**. Komunikasi hanya lewat
event atau kontrak (interface) yang dideklarasikan di folder `Contracts/`.

```
                    ┌───────────────────────────────┐
                    │       Shared Kernel           │
                    │  app/Models/  (User, dll)     │
                    └───────────────────────────────┘
                        ▲        ▲        ▲        ▲
          ┌─────────────┘        │        │        └─────────────┐
          │                      │        │                      │
  ┌───────┴────────┐   ┌─────────┴──┐  ┌──┴─────────┐   ┌────────┴───────┐
  │   Tournament   │   │   Match    │  │     Admin  │   │  Registration  │
  │     MODUL      │   │   MODUL    │  │    MODUL   │   │     MODUL      │
  └───────▲────────┘   └──────▲─────┘  └────────────┘   └───────▲────────┘
          │                   │                                  │
          └───────────────────┼──────────────────────────────────┘
                              │
                        ┌─────┴─────┐
                        │  Payment  │
                        │   MODUL   │
                        └───────────┘

Aliran data (satu arah):
  Tournament  ──TournamentPublished──>  Registration
  Tournament  ──ScheduleGenerated────>  Match
  Registration ──PaymentRequested────>  Payment
  Registration ──PaymentConfirmed───>  Tournament   (slot terkunci)
  *            ──UserSuspended──────>  Admin        (audit & quality)

Legenda:
  ──event──>  komunikasi asinkron lewat event, tanpa coupling
  ──kontrak─>  komunikasi lewat interface di folder Contracts/
```

**Bentuk yang benar** — Tournament tidak tahu apa pun soal Registration:

```php
// Modul Tournament
event(new TournamentPublished($turnamen->id, $turnamen->nama));
```

```php
// Modul Registration — mendengar tanpa meng-import class internal Tournament
protected function listen(): array
{
    return [TournamentPublished::class => 'handleTournamentPublished'];
}
```

**Bentuk yang salah (dilarang):**

```php
use App\Modules\Tournament\Http\Controllers\TurnamenController; // ❌ cross-modul
use App\Modules\Tournament\Data\TurnamenInternalQuery;        // ❌ cross-modul
```

---

## 3. Konvensi Penamaan Route

Format nama route: **`{portal}.{aksi}`**

| Portal | Prefix URL | Prefix nama route | Middleware |
|--------|-----------|-------------------|------------|
| Peserta (publik) | `/turnamen` | `peserta.` | `web` saja |
| Penyelenggara | `/penyelenggara` | `penyelenggara.` | `web, auth, verified, role:penyelenggara` |
| Super Admin | `/admin` | `admin.` | `web, auth, verified, role:super_admin` |

> Prefix **URL** dan prefix **nama route** tidak selalu sama:
> `/turnamen` memakai nama route berawalan `peserta.`

Grup route didefinisikan sekali di `app/Support/Routing/PortalRoutes.php`.
Route modul **tidak boleh** memanggil `Route::get()` langsung — harus dibungkus
`PortalRoutes::tenant()` agar middleware dan prefix konsisten.

```php
// app/Modules/Tournament/routes/tenant.php
PortalRoutes::tenant(function () {
    Route::get('/turnamen', [TurnamenController::class, 'index'])->name('turnamen.index');
    // nama route menjadi: penyelenggara.turnamen.index
});
```

Role tersedia: `super_admin`, `penyelenggara`, `peserta`.
Cek role lewat model `User`:

```php
$user->hasRole('super_admin');   // role cocok DAN status aktif
$user->isSuperAdmin();
$user->isPenyelenggara();
$user->isPeserta();
$user->isActive();
```

> `hasRole()` sekaligus memanggil `isActive()`, jadi akun **suspended**
> otomatis kena `403` tanpa cek terpisah.

---

## 4. Konvensi Namespace Modul

Format: **`App\Modules\{NamaModul}`**, `{NamaModul}` memakai **PascalCase**.

| Modul | Namespace Root |
|-------|----------------|
| Admin | `App\Modules\Admin` |
| Tournament | `App\Modules\Tournament` |
| Registration | `App\Modules\Registration` |
| Payment | `App\Modules\Payment` |
| Match | `App\Modules\Match` |

Semua class modul wajib `declare(strict_types=1)`, dan pakai `final`
bila memang tidak akan di-extend.

```php
namespace App\Modules\Tournament\Actions;

final class BuatTurnamen
{
    // ...
}
```

Komponen Livewire modul dipanggil dengan alias modul:

```blade
<livewire:tournament::buat-turnamen />
```

---

## 5. Konvensi Komponen Blade

Komponen UI global tinggal di `resources/views/components/`.

### Layout per portal

```blade
<x-layouts.peserta title="Portal Peserta">
    <h1 class="text-2xl font-bold">Portal Peserta</h1>
</x-layouts.peserta>

<x-layouts.penyelenggara title="Dashboard Penyelenggara">
    <h1 class="text-2xl font-bold">Dashboard</h1>
</x-layouts.penyelenggara>

<x-layouts.admin title="Dashboard Super Admin">
    <h1 class="text-2xl font-bold">Dashboard</h1>
</x-layouts.admin>
```

Tiap layout wajib:

- memuat `@include('partials.head')` di dalam `<head>`
- menyertakan `{{ $slot }}`
- punya target sentuh `min-h-11` (44px) atau lebih
- nyaman dibaca di lebar 375px (mobile) dan 1024px (desktop)

### Komponen dasar

| Komponen | Dipakai sebagai | Isi |
|----------|-----------------|-----|
| `x-button` | `<x-button variant="primary\|secondary\|danger">` | target sentuh `min-h-11`, render `<button>` atau `<a>` bila `href` diisi |
| `x-input` | `<x-input name="email" label="Email" />` | `<label>` + `<input>`, tampilkan pesan error validasi |
| `x-status-badge` | `<x-status-badge status="active" />` | warna berbeda untuk `active`, `pending`, `suspended`, `rejected` |
| `x-empty-state` | `<x-empty-state title="..." description="...">` | kondisi kosong + slot untuk tombol aksi |

---

## 6. Aturan Dependensi

1. Modul **gak boleh** mengakses tabel atau model internal modul lain secara langsung.
2. Komunikasi antar modul lewat **event** atau **interface/service** di `Contracts/`.
3. **Gak boleh** meng-import controller, action, atau service milik modul lain.
4. Model Eloquent yang dipakai lintas modul ditaruh di `app/Models/` (shared kernel).
5. Layout dan komponen UI global ditaruh di `resources/views/components/`.
6. Tiap modul tetap punya `Http/Controllers/` sendiri untuk entry point HTTP-nya.

---

## 7. Ringkasan Konvensi

| Jenis | Format | Contoh |
|-------|--------|--------|
| Route name | `{portal}.{aksi}` | `penyelenggara.turnamen.index` |
| Prefix URL | `/turnamen`, `/penyelenggara`, `/admin` | `/admin/dashboard` |
| Namespace modul | `App\Modules\{NamaModul}` | `App\Modules\Payment\Services` |
| Alias view modul | nama modul lowercase | `view('payment::bayar')` |
| Livewire modul | `<livewire:{alias}::nama-komponen />` | `<livewire:match::jadwal />` |
| Layout Blade | `x-layouts.{portal}` | `<x-layouts.admin>` |
| Komponen Blade | `x-{komponen}` | `<x-status-badge>` |
| Provider | `{NamaModul}ServiceProvider` | `TournamentServiceProvider` |
| Test | `tests/Feature/{Topik}Test.php` | `ModularFoundationTest.php` |