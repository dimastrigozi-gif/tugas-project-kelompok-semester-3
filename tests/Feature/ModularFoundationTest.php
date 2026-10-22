<?php

use App\Models\User;
use App\Modules\Admin\AdminServiceProvider;
use App\Modules\Match\MatchServiceProvider;
use App\Modules\Payment\PaymentServiceProvider;
use App\Modules\Registration\RegistrationServiceProvider;
use App\Modules\Tournament\TournamentServiceProvider;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Test Fondasi Modul 2
|--------------------------------------------------------------------------
| Pastikan: bounded context, modular monolith, route per konteks,
| middleware role, dan registrasi ServiceProvider modul.
*/

test('customer route is public', function () {
    $response = $this->get(route('peserta.home'));

    $response->assertOk();
});

test('customer route carries no auth middleware', function () {
    $middleware = Route::getRoutes()->getByName('peserta.home')->gatherMiddleware();

    expect($middleware)->toContain('web')
        ->and($middleware)->not->toContain('auth')
        ->and($middleware)->not->toContain('role:peserta');
});

test('guest is redirected to login on tenant and admin', function () {
    $this->get(route('penyelenggara.dashboard'))
        ->assertRedirect(route('login'));

    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

test('admin can open admin dashboard', function () {
    $user = User::factory()->superAdmin()->create();

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertOk();
});

test('penyelenggara can open penyelenggara dashboard', function () {
    $user = User::factory()->penyelenggara()->create();

    $this->actingAs($user)
        ->get(route('penyelenggara.dashboard'))
        ->assertOk();
});

test('wrong role is forbidden', function () {
    $admin = User::factory()->superAdmin()->create();
    $peserta = User::factory()->peserta()->create();

    // Admin buka portal penyelenggara -> tolak.
    $this->actingAs($admin)
        ->get(route('penyelenggara.dashboard'))
        ->assertForbidden();

    // Peserta buka portal admin -> tolak.
    $this->actingAs($peserta)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

test('user without role is forbidden', function () {
    $user = User::factory()->withoutRole()->create();

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();

    $this->actingAs($user)
        ->get(route('penyelenggara.dashboard'))
        ->assertForbidden();
});

test('suspended user is forbidden', function () {
    $admin = User::factory()->superAdmin()->suspended()->create();
    $penyelenggara = User::factory()->penyelenggara()->suspended()->create();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertForbidden();

    $this->actingAs($penyelenggara)
        ->get(route('penyelenggara.dashboard'))
        ->assertForbidden();
});

test('all five module providers are registered', function () {
    $providers = [
        AdminServiceProvider::class,
        TournamentServiceProvider::class,
        RegistrationServiceProvider::class,
        PaymentServiceProvider::class,
        MatchServiceProvider::class,
    ];

    $loaded = array_keys(app()->getLoadedProviders());

    foreach ($providers as $provider) {
        expect($loaded)->toContain($provider);
    }
});

test('module providers resolve module path to an absolute existing directory', function () {
    foreach ([
        AdminServiceProvider::class,
        TournamentServiceProvider::class,
        RegistrationServiceProvider::class,
        PaymentServiceProvider::class,
        MatchServiceProvider::class,
    ] as $class) {
        $provider = new $class(app());
        $method = new ReflectionMethod($class, 'modulePath');
        $method->setAccessible(true);

        $path = $method->invoke($provider);

        expect($path)->toStartWith(base_path())
            ->and(is_dir($path))->toBeTrue();
    }
});

test('user model exposes role helpers', function () {
    $admin = User::factory()->superAdmin()->create();
    $penyelenggara = User::factory()->penyelenggara()->create();
    $peserta = User::factory()->peserta()->create();
    $suspended = User::factory()->superAdmin()->suspended()->create();

    expect($admin->isSuperAdmin())->toBeTrue()
        ->and($admin->hasRole('super_admin'))->toBeTrue()
        ->and($admin->isActive())->toBeTrue()
        ->and($penyelenggara->isPenyelenggara())->toBeTrue()
        ->and($peserta->isPeserta())->toBeTrue()
        ->and($peserta->isSuperAdmin())->toBeFalse()
        ->and($suspended->isActive())->toBeFalse()
        ->and($suspended->hasRole('super_admin'))->toBeFalse();
});

test('portal routes use the documented url prefixes and name prefixes', function () {
    expect(route('peserta.home', absolute: false))->toStartWith('/turnamen')
        ->and(route('admin.dashboard', absolute: false))->toStartWith('/admin')
        ->and(route('penyelenggara.dashboard', absolute: false))->toStartWith('/penyelenggara');
});

test('dashboard pages render the shared layout with a stylesheet', function () {
    $admin = User::factory()->superAdmin()->create();

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk();
    $response->assertSee('rel="stylesheet"', false);
    $response->assertSee('Super Admin', false);
});

test('shared ui components render', function () {
    $this->blade('<x-button>Simpan</x-button>')->assertSee('Simpan');
    $this->blade('<x-button variant="secondary">Batal</x-button>')->assertSee('Batal');
    $this->blade('<x-input name="email" label="Email" />')->assertSee('name="email"', false);
    $this->blade('<x-status-badge status="active" />')->assertSee('Aktif');
    $this->blade('<x-status-badge status="suspended" />')->assertSee('Ditangguhkan');
    $this->blade('<x-empty-state title="Kosong" description="Belum ada data" />')->assertSee('Kosong');
});
