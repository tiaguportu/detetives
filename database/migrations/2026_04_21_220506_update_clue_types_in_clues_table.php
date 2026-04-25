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
        Schema::table('clues', function (Blueprint $table) {
            // No SQLite o enum é simulado com CHECK, expandir exige recriação ou mudar para string
            // Para maior flexibilidade, vou mudar para string
            $table->string('type')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clues', function (Blueprint $table) {
            $table->enum('type', ['history', 'culture', 'geography', 'fauna', 'flora'])->change();
        });
    }
};
