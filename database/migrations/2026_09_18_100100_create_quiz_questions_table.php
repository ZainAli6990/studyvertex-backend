<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('quiz_id')
                ->constrained()
                ->cascadeOnDelete();

            // Where the question was copied from. Nullable because the
            // import command can delete MCQs (--truncate-topic); the quiz
            // keeps its own copy below, so old results still work.
            $table->foreignId('mcq_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // 0-based order of the question inside the quiz.
            $table->unsignedInteger('position');

            // Snapshot of the MCQ at the time the quiz was created.
            $table->text('question');
            $table->json('options');
            $table->unsignedTinyInteger('correct_index');

            // Filled in when the quiz is submitted. selected_index stays
            // null for a question the user skipped.
            $table->unsignedTinyInteger('selected_index')->nullable();
            $table->boolean('is_correct')->nullable();

            $table->timestamps();

            $table->unique(['quiz_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
