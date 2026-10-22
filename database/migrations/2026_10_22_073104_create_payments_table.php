<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Relasi 1:1 dengan registrations
            $table->foreignId('id_pendaftaran')->unique()->constrained('registrations')->cascadeOnDelete();
            
            $table->decimal('jumlah', 12, 2);
            $table->string('metode', 20)->comment('transfer / ewallet / qris / va');
            $table->string('bukti', 255)->nullable();
            $table->string('status', 20)->default('belum_bayar')->comment('belum_bayar / sudah_bayar / kadaluarsa');
            $table->dateTime('waktu_bayar')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};