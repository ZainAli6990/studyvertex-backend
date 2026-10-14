<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exact date + time of the last MCQ the person answered / showed /
     * skipped in each subject. Powers "Scored Last" on REPORT > your name.
     */
    public function up(): void
    {
        Schema::table('user_subjects', function (Blueprint $table) {
            $table->timestamp('last_scored_at')->nullable()->after('mcqs_skipped');
        });
    }

    public function down(): void
    {
        Schema::table('user_subjects', function (Blueprint $table) {
            $table->dropColumn('last_scored_at');
        });
    }
};
