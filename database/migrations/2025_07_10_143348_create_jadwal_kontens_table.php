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
        Schema::create('jadwal_kontens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade'); 
            $table->string('judul_konten');
            $table->dateTime('tanggal_postingan'); 
            $table->text('caption'); 
            $table->string('akun_ditandai')->nullable(); 
            $table->string('hastag')->nullable(); 
            $table->enum('status', ['scheduled', 'published', 'failed'])->default('scheduled'); 
            $table->dateTime('waktu_dibuat'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kontens');
    }
};
