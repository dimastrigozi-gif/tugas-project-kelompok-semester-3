<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penyelenggara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            
            $table->string('nama_organisasi', 150);
            $table->text('deskripsi')->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('kontak', 50)->nullable();
            $table->string('alamat', 255)->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyelenggara');
    }
};