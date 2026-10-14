<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            // Emoji / icon shown on the "Find More" card (e.g. "📚").
            $table->string('icon')->nullable();

            // How many subjects belong to this category (shown as the
            // small "N Subjects" badge on the card).
            $table->unsignedInteger('subjects_count')->default(0);

            // Controls the display order on the "Find More" list.
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index('sort_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
