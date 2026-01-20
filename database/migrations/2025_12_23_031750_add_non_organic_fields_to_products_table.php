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
            $table->date('production_date')->nullable()->after('organic_status');
            $table->string('bpom_number')->nullable()->after('production_date');
            $table->text('composition')->nullable()->after('bpom_number');
            $table->date('expiry_date')->nullable()->after('composition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['production_date', 'bpom_number', 'composition', 'expiry_date']);
        });
    }
};
