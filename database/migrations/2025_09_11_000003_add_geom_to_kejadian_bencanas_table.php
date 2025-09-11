<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add geometry(Point, 4326) column using raw statement for portability
        try {
            DB::statement('ALTER TABLE kejadian_bencanas ADD COLUMN IF NOT EXISTS geom geometry(Point, 4326)');
            DB::statement('CREATE INDEX IF NOT EXISTS kejadian_bencanas_geom_gist ON kejadian_bencanas USING GIST (geom)');
        } catch (\Throwable $e) {
            // ignore on non-Postgres envs
        }
    }

    public function down(): void
    {
        try {
            DB::statement('DROP INDEX IF EXISTS kejadian_bencanas_geom_gist');
            DB::statement('ALTER TABLE kejadian_bencanas DROP COLUMN IF EXISTS geom');
        } catch (\Throwable $e) {
            // noop
        }
    }
};


