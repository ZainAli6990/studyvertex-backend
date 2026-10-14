<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // The Active / Inactive button on Home: study reminders are only
            // sent while it is Active. Off by default, like the button.
            $table->boolean('study_alerts_active')->default(false)->after('notify_stop_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('study_alerts_active');
        });
    }
};
