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
        Schema::table('meetings', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->after('user_id')->constrained()->onDelete('set null');
            $table->date('proposed_date')->nullable()->after('meeting_date');
            $table->string('proposed_time')->nullable()->after('proposed_date');
            $table->enum('status', ['pending', 'requested', 'approved', 'rejected', 'completed'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn(['location_id', 'proposed_date', 'proposed_time']);
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending')->change();
        });
    }
};