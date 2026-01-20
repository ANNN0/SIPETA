<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add 'pending', 'approved', 'processing', 'dalam_perjalanan' to order status enum
     */
    public function up(): void
    {
        // For MySQL, we need to modify the enum column
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'ordered', 'approved', 'processing', 'dalam_perjalanan', 'delivered', 'canceled') DEFAULT 'ordered'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('ordered', 'delivered', 'canceled') DEFAULT 'ordered'");
    }
};
