<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Lifetime counters behind the REPORT screen (Correct / Incorrect /
     * Show / Skip). Kept on the user directly -- simple running totals,
     * not tied to any one subject -- since the report lists people
     * (you + friends), not subjects.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('mcqs_correct')->default(0)->after('last_study_alert_at');
            $table->unsignedInteger('mcqs_incorrect')->default(0)->after('mcqs_correct');
            $table->unsignedInteger('mcqs_shown')->default(0)->after('mcqs_incorrect');
            $table->unsignedInteger('mcqs_skipped')->default(0)->after('mcqs_shown');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mcqs_correct', 'mcqs_incorrect', 'mcqs_shown', 'mcqs_skipped']);
        });
    }
};
