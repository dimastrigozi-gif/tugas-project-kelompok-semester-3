<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('turnamen_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turnamen_id')->constrained('tournaments')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role', 30)->default('staff'); // owner, admin, staff
            $table->timestamps();
            
            // Satu user cuma boleh punya satu role di turnamen yang sama
            $table->unique(['turnamen_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('turnamen_staff');
    }
};