<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_turnamen')->constrained('tournaments')->cascadeOnDelete();
            
            $table->string('babak', 30)->comment('R16 / QF / SF / Final');
            $table->integer('nomor_match');
            $table->date('tanggal')->nullable();
            $table->time('jam')->nullable();
            $table->string('status', 20)->default('dijadwalkan')->comment('dijadwalkan / berlangsung / selesai / ditunda / dibatalkan');
            $table->string('url_stream', 255)->nullable();
            
            $table->timestamps();

            // Satu turnamen, satu babak, nomor match harus unik
            $table->unique(['id_turnamen', 'babak', 'nomor_match']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};