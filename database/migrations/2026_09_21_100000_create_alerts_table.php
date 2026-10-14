<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The "ALERTS" inbox -- one row per message shown to a user.
     */
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // study_reminder | quiz_result | quiz_pending | streak | new_mcqs | welcome
            $table->string('type', 30);

            $table->string('title');
            $table->text('body')->nullable();

            // Where tapping the alert should lead (subject_id, quiz_id, mcq_id, ...).
            $table->json('data')->nullable();

            // Stops the same event from producing the same alert twice
            // (e.g. submitting a quiz twice). NULL = no de-duplication.
            $table->string('dedupe_key')->nullable();

            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'read_at']);
            $table->unique(['user_id', 'dedupe_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
