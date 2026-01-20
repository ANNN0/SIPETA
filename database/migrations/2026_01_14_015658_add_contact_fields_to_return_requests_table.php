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
        Schema::table('return_requests', function (Blueprint $table) {
            $table->string('contact_name')->nullable()->after('photos');
            $table->string('contact_phone')->nullable()->after('contact_name');
            $table->text('sender_address')->nullable()->after('contact_phone');
            $table->string('sender_city')->nullable()->after('sender_address');
            $table->string('sender_state')->nullable()->after('sender_city');
            $table->string('sender_zip')->nullable()->after('sender_state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('return_requests', function (Blueprint $table) {
            $table->dropColumn(['contact_name', 'contact_phone', 'sender_address', 'sender_city', 'sender_state', 'sender_zip']);
        });
    }
};
