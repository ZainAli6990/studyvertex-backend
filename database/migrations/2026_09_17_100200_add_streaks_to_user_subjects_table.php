<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_subjects', function (Blueprint $table) {
            // Powers the "Current Streak" / "Maximum Streak" text on the
            // correct-answer screen, per user per subject.
            $table->unsignedInteger('current_streak')->default(0)->after('is_active');
            $table->unsignedInteger('max_streak')->default(0)->after('current_streak');
        });
    }

    public function down(): void
    {
        Schema::table('user_subjects', function (Blueprint $table) {
            $table->dropColumn(['current_streak', 'max_streak']);
        });
    }
};
