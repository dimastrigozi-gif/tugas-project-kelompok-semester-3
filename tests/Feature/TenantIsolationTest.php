<?php

namespace Tests\Feature;

use App\Jobs\CountTenantTournaments;
use App\Models\Game;
use App\Models\Tournament;
use App\Models\User;
use App\Modules\Tournament\Services\PublicTournamentQuery;
use App\Policies\TournamentPolicy;
use App\Support\Tenancy\TenantContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Bikin 1 game buat syarat foreign key
        Game::create([
            'id' => 1,
            'nama_game' => 'Test Game',
            'jenis' => 'tim',
            'maks_anggota' => 5,
            'ikon' => 'test.png',
        ]);
    }

    private function user(string $role = 'penyelenggara'): User
    {
        return User::factory()->create([
            'role' => $role,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }

    private function tournament(int $userId, string $status = 'buka'): Tournament
    {
        return Tournament::create([
            'id_penyelenggara' => $userId,
            'id_game' => 1,
            'nama' => 'Turnamen Uji ' . $userId,
            'jenis_game' => 'single_elim',
            'maks_peserta' => 16,
            'status' => $status,
        ]);
    }

    public function test_global_scope_only_returns_own_tournaments(): void
    {
        $userA = $this->user();
        $userB = $this->user();

        $this->tournament($userA->id);
        $this->tournament($userB->id);

        // Set context jadi User A
        app(TenantContext::class)->set($userA);

        $this->assertSame(1, Tournament::count());
        $this->assertSame($userA->id, Tournament::first()->id_penyelenggara);
    }

    public function test_policy_denies_cross_tenant_update(): void
    {
        $userA = $this->user();
        $userB = $this->user();
        $turnamenB = $this->tournament($userB->id);

        $policy = new TournamentPolicy();
        $this->assertFalse($policy->update($userA, $turnamenB), 'Policy harus menolak akses lintas penyelenggara');
    }

    public function test_scoped_binding_blocks_cross_tenant_url(): void
    {
        $userA = $this->user();
        $userB = $this->user();
        $turnamenB = $this->tournament($userB->id);

        $this->actingAs($userA);
        
        // URL diakses sebagai User A, tapi nyoba nembak ID Turnamen B
        $url = route('penyelenggara.tournaments.show', [
            'penyelenggara' => $userA->id, 
            'tournament' => $turnamenB->id
        ]);

        // Harus 404 (Not Found) karena scopedBinding ngunci di bawah User A
        $this->get($url)->assertNotFound();
    }

    public function test_public_catalog_query_only_shows_open_tournaments(): void
    {
        $userA = $this->user();
        $this->tournament($userA->id, 'buka');
        $this->tournament($userA->id, 'draft');

        $query = new PublicTournamentQuery();
        $result = $query->forPublic();

        $this->assertCount(1, $result);
        $this->assertSame('buka', $result->first()->status);
    }

    public function test_job_sets_and_clears_context(): void
    {
        $user = $this->user();
        $this->tournament($user->id);

        $job = new CountTenantTournaments($user->id);
        $job->handle(app(TenantContext::class));

        $this->assertSame(1, $job->result);
        // Pastikan context dibersihin setelah job selesai
        $this->assertFalse(app(TenantContext::class)->has());
    }
}