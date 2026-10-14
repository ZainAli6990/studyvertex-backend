<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // When the last study reminder was sent. Used to decide if the
            // next one is due, and to make sure two requests arriving at the
            // same moment don't both send one.
            $table->timestamp('last_study_alert_at')->nullable()->after('study_alerts_active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_study_alert_at');
        });
    }
};
