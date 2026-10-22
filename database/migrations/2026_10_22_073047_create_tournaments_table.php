<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penyelenggara')->constrained('users')->restrictOnDelete();
            $table->foreignId('id_game')->constrained('games')->restrictOnDelete();
            $table->string('nama', 150);
            $table->text('deskripsi')->nullable();
            $table->string('jenis_game', 30)->comment('single_elim / double_elim / round_robin / battle_royale');
            $table->integer('maks_peserta');
            $table->decimal('biaya_daftar', 12, 2)->default(0);
            $table->decimal('hadiah', 12, 2)->default(0);
            
            $table->dateTime('waktu_buka')->nullable();
            $table->dateTime('waktu_tutup')->nullable();
            
            $table->string('status', 20)->default('draft')->comment('draft / buka / berjalan / selesai / dibatalkan');
            $table->string('banner', 255)->nullable();
            
            // Info Lokasi
            $table->string('nama_lokasi', 150)->nullable();
            $table->string('tipe', 20)->nullable()->comment('offline / online');
            $table->string('alamat', 255)->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('link_maps', 255)->nullable();
            $table->string('platform_stream', 50)->nullable();
            $table->string('link_stream', 255)->nullable();
            $table->string('tempat_live', 150)->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};