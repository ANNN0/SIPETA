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
        Schema::table('contacts', function (Blueprint $table) {
            $table->enum('message_type', ['pertanyaan', 'keluhan', 'testimonial', 'saran'])
                ->default('pertanyaan')
                ->after('comment');
            $table->tinyInteger('rating')->nullable()->after('message_type'); // 1-5 stars
            $table->boolean('is_approved')->default(false)->after('rating');
            $table->timestamp('approved_at')->nullable()->after('is_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['message_type', 'rating', 'is_approved', 'approved_at']);
        });
    }
};
