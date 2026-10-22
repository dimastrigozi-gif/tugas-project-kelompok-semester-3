<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('super_admins', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users (1:1). 
            // Kalau user dihapus, data super_admin ikut terhapus (cascade).
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            
            // Level admin (1 = admin biasa, 2 = admin utama)
            $table->integer('level')->default(1);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('super_admins');
    }
};