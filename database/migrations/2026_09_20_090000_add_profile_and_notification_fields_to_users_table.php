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
        Schema::table('users', function (Blueprint $table) {
            // Profile screen -- personal information.
            $table->string('phone')->nullable()->after('username');

            // Profile screen -- push notification preferences.
            $table->unsignedTinyInteger('mcqs_per_hour')->default(3)->after('phone');
            $table->string('notify_start_at')->nullable()->after('mcqs_per_hour');
            $table->string('notify_stop_at')->nullable()->after('notify_start_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'mcqs_per_hour',
                'notify_start_at',
                'notify_stop_at',
            ]);
        });
    }
};
