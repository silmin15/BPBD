<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kejadian_bencanas', function (Blueprint $table) {
            $table->string('geofile_path')->nullable()->after('keterangan');
            $table->string('geofile_name')->nullable()->after('geofile_path');
        });
    }

    public function down(): void
    {
        Schema::table('kejadian_bencanas', function (Blueprint $table) {
            $table->dropColumn(['geofile_path', 'geofile_name']);
        });
    }
};


