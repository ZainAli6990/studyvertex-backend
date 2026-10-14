<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('subject_id')
                ->constrained()
                ->cascadeOnDelete();

            // Kept nullable so a quiz (and its results) survives if the
            // topic is ever removed.
            $table->foreignId('topic_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // How many questions the quiz holds and how long it runs.
            $table->unsignedInteger('mcqs_count');
            $table->unsignedInteger('minutes');

            // "pending" (not taken yet) or "completed" (submitted).
            $table->string('status', 20)->default('pending');

            // Number of correct answers, set when the quiz is submitted.
            $table->unsignedInteger('score')->default(0);

            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
