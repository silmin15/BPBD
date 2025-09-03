<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sk_documents', function (Blueprint $table) {
            $table->id();

            // Data utama SK
            $table->string('no_sk')->unique();   // NO SK (unik)
            $table->string('judul_sk');          // Judul SK

            // Masa berlaku (opsional)
            $table->date('start_at')->nullable();  // mulai berlaku
            $table->date('end_at')->nullable();    // akhir berlaku

            // Tanggal SK (wajib) + nama bulan dalam teks (mis. "Agustus")
            $table->date('tanggal_sk');
            $table->string('bulan_text', 20)->nullable();

            // File PDF yang diunggah (disimpan di storage, simpan path-nya di sini)
            $table->string('pdf_path');

            // Pemilik data (KL yang input) -> referensi ke users.id
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

            $table->timestamps();

            // Index bantu untuk query rekap per tahun/bulan & pemilik
            $table->index('tanggal_sk');
            $table->index(['created_by', 'tanggal_sk']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sk_documents');
    }
};
