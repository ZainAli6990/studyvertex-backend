<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Correct / Incorrect / Show / Skip counted per user per subject, for
     * the subject-by-subject REPORT (tap your name on REPORT). The lifetime
     * totals on the users table stay as they are; these start at 0 and
     * grow from now on.
     */
    public function up(): void
    {
        Schema::table('user_subjects', function (Blueprint $table) {
            $table->unsignedInteger('mcqs_correct')->default(0)->after('max_streak');
            $table->unsignedInteger('mcqs_incorrect')->default(0)->after('mcqs_correct');
            $table->unsignedInteger('mcqs_shown')->default(0)->after('mcqs_incorrect');
            $table->unsignedInteger('mcqs_skipped')->default(0)->after('mcqs_shown');
        });
    }

    public function down(): void
    {
        Schema::table('user_subjects', function (Blueprint $table) {
            $table->dropColumn(['mcqs_correct', 'mcqs_incorrect', 'mcqs_shown', 'mcqs_skipped']);
        });
    }
};
