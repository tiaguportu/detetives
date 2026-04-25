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
        Schema::create('investigators', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('countries_count');
            $table->string('avatar_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('history')->nullable();
            $table->text('culture')->nullable();
            $table->text('geography')->nullable();
            $table->text('fauna')->nullable();
            $table->text('flora')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });

        Schema::create('clues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['history', 'culture', 'geography', 'fauna', 'flora']);
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('game_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investigator_id')->constrained();
            $table->enum('status', ['playing', 'won', 'lost'])->default('playing');
            $table->integer('current_step')->default(0);
            $table->integer('total_steps');
            $table->json('path'); // Array of country IDs
            $table->timestamps();
        });

        Schema::create('game_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_session_id')->constrained()->onDelete('cascade');
            $table->integer('step_number');
            $table->foreignId('target_country_id')->constrained('countries');
            $table->boolean('is_correct')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_steps');
        Schema::dropIfExists('game_sessions');
        Schema::dropIfExists('clues');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('investigators');
    }
};
