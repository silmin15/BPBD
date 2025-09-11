<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Enable PostGIS extension if database is PostgreSQL
        try {
            DB::statement('CREATE EXTENSION IF NOT EXISTS postgis');
        } catch (\Throwable $e) {
            // Ignore if not supported (e.g., non-PostgreSQL envs)
        }
    }

    public function down(): void
    {
        try {
            DB::statement('DROP EXTENSION IF EXISTS postgis');
        } catch (\Throwable $e) {
            // noop
        }
    }
};


