<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('title')->after('id');
            $table->string('sport')->after('title');
            $table->string('location')->after('sport');
            $table->string('image')->nullable()->after('max_participants');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->string('image')->nullable()->after('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['title', 'sport', 'location', 'image']);
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
