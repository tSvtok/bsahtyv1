<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('CREATE EXTENSION IF NOT EXISTS postgis;');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            // Use CASCADE to drop dependent objects
            // Note: In production, you likely don't want to drop PostGIS
            // Consider skipping this migration rollback in production
            try {
                DB::statement('DROP EXTENSION IF EXISTS postgis CASCADE;');
            } catch (\Exception $e) {
                // Log but don't fail if extension cleanup has issues
                \Log::warning('Failed to drop PostGIS extension: ' . $e->getMessage());
            }
        }
    }
};
