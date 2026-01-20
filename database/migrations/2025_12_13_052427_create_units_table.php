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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Kilogram", "Ikat", "Buah"
            $table->string('symbol')->unique(); // e.g., "kg", "ikat", "buah"
            $table->string('category'); // e.g., "weight", "count", "container"
            $table->decimal('base_unit_value', 10, 4)->default(1); // For conversion (e.g., 1 ton = 1000 kg)
            $table->timestamps();

            // Indexes
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
