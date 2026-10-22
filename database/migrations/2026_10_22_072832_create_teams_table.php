<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->foreignId('id_game')->constrained('games')->restrictOnDelete();
            $table->foreignId('id_kapten')->constrained('users')->restrictOnDelete();
            $table->string('logo', 255)->nullable();
            $table->timestamps();

            // Nama tim gak boleh sama dalam 1 game yang sama
            $table->unique(['nama', 'id_game']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};