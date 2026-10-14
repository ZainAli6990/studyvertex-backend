<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mcqs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('topic_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('question');

            // Exactly 4 answer choices, stored as a JSON array of strings.
            $table->json('options');

            // Index (0-3) into "options" that holds the correct choice.
            $table->unsignedTinyInteger('correct_index');

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index('topic_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mcqs');
    }
};
