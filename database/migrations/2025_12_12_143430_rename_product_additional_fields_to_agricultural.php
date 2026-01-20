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
        Schema::table('products', function (Blueprint $table) {
            // Rename fields to agricultural-specific names
            $table->renameColumn('weight', 'harvest_period');
            $table->renameColumn('dimensions', 'shelf_life');
            $table->renameColumn('color', 'organic_status');
            // storage_info remains the same
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('harvest_period', 'weight');
            $table->renameColumn('shelf_life', 'dimensions');
            $table->renameColumn('organic_status', 'color');
        });
    }
};
