<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder akun demo untuk testing role.
 * Modul 2 — 3 akun: super_admin, penyelenggara, peserta.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $akunDemo = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@turnamen.test',
                'role' => 'super_admin',
            ],
            [
                'name' => 'Penyelenggara Turnamen',
                'email' => 'penyelenggara@turnamen.test',
                'role' => 'penyelenggara',
            ],
            [
                'name' => 'Peserta Turnamen',
                'email' => 'peserta@turnamen.test',
                'role' => 'peserta',
            ],
        ];

        foreach ($akunDemo as $akun) {
            User::updateOrCreate(
                ['email' => $akun['email']],
                [
                    'name' => $akun['name'],
                    'password' => Hash::make('password'),
                    'role' => $akun['role'],
                    'status' => 'active',
                    'email_verified_at' => now(),
                ],
            );
        }
    }
}
