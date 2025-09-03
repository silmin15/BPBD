<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activity_reports', function (Blueprint $table) {
            $table->id();

            // Role konteks pemilik laporan
            $table->enum('role_context', ['PK','KL','RR'])->index();

            // Kolom laporan
            $table->string('judul_laporan');
            $table->string('kepada_yth')->nullable();
            $table->string('jenis_kegiatan')->nullable();

            // Waktu kegiatan
            $table->string('hari')->nullable();          // contoh: Senin
            $table->date('tanggal')->nullable()->index(); // contoh: 2025-08-24
            $table->string('pukul')->nullable();         // contoh: 08:30–10:00

            // Lokasi & hasil
            $table->string('lokasi_kegiatan')->nullable();
            $table->text('hasil_kegiatan')->nullable();

            // Unsur terlibat (baru)
            $table->text('unsur_yang_terlibat')->nullable();

            // Petugas
            $table->string('petugas')->nullable();       // contoh: "Andi, Budi"

            // Dokumentasi: simpan path foto-foto (array JSON)
            $table->json('dokumentasi')->nullable();

            // Relasi pembuat
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_reports');
    }
};
