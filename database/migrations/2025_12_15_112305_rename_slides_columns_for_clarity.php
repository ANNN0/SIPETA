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
        Schema::table('slides', function (Blueprint $table) {
            // Rename columns for better clarity
            $table->renameColumn('tagline', 'subtitle_small');
            $table->renameColumn('title', 'title_main');
            $table->renameColumn('subtitle', 'subtitle_large');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slides', function (Blueprint $table) {
            // Revert column names
            $table->renameColumn('subtitle_small', 'tagline');
            $table->renameColumn('title_main', 'title');
            $table->renameColumn('subtitle_large', 'subtitle');
        });
    }
};
