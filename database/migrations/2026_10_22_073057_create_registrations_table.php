<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_turnamen')->constrained('tournaments')->cascadeOnDelete();
            $table->foreignId('id_user')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('id_tim')->nullable()->constrained('teams')->nullOnDelete();
            
            $table->string('status', 20)->default('menunggu')->comment('menunggu / disetujui / ditolak / dibatalkan');
            $table->integer('nomor_seed')->nullable();
            $table->timestamp('waktu_daftar')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};