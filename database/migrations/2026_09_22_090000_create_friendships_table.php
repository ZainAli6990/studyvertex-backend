<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();

            // Who sent the request, and who received it.
            $table->foreignId('requester_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('addressee_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // pending -> sent, waiting on the Requests tab.
            // accepted -> shows up on both people's Friends tab.
            $table->string('status')->default('pending');

            $table->timestamps();

            // One request/friendship per pair, either direction.
            $table->unique(['requester_id', 'addressee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('friendships');
    }
};
