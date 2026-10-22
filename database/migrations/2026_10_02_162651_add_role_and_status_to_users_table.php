<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Modul 2 — tambah kolom role & status di tabel users.
 * 'super_admin'    : pengelola sistem
 * 'penyelenggara'  : organizer turnamen
 * 'peserta'        : pemain peserta turnamen
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('role', 20)->default('peserta')->after('email');
            $table->string('status', 20)->default('active')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn(['role', 'status']);
        });
    }
};
