<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('analisis_jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_konten_id')->constrained('jadwal_kontens')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('isi_laporan');
            $table->date('tanggal_laporan')->nullable();
            $table->enum('status_laporan', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analisis_jadwals');
    }
};
