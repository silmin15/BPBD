<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('logistik_items', function (Blueprint $t) {
            $t->id();
            $t->date('tanggal');
            $t->string('nama_barang');
            $t->decimal('volume', 18, 0)->default(0);        // bulat
            $t->string('satuan', 50);
            $t->decimal('harga_satuan', 18, 2)->default(0);  // uang
            $t->decimal('jumlah_harga', 18, 2)->default(0);  // uang

            // bagian jumlah
            $t->decimal('jumlah_keluar', 18, 0)->default(0); // bulat
            $t->decimal('jumlah_harga_keluar', 18, 2)->default(0); // uang
            $t->decimal('sisa_barang', 18, 0)->default(0);   // bulat
            $t->decimal('sisa_harga', 18, 2)->default(0);    // uang

            $t->foreignId('created_by')->constrained('users');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logistik_items');
    }
};
