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
        Schema::create('file_konten', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jadwal')->constrained('jadwal_kontens')->onDelete('cascade');
            $table->string('nama_file');
            $table->string('url_file');
            $table->string('tipe_file'); // atau integer jika kamu simpan kode tipe
            $table->timestamps();

            // Jika ingin, bisa tambahkan foreign key
            // $table->foreignId('id_jadwal')->constrained('jadwal_kontens')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_konten');
    }
};
