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
        Schema::create('kejadian_bencanas', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kejadian');

            $table->foreignId('jenis_bencana_id')->constrained()->onDelete('cascade');

            $table->text('alamat_lengkap');
            $table->string('kecamatan');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->date('tanggal_kejadian');
            $table->time('waktu_kejadian')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kejadian_bencanas');
    }
};
