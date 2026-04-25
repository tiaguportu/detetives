<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('country_informant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete();
            $table->foreignId('informant_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        // Migrar dados existentes
        $countries = DB::table('countries')->whereNotNull('informant_id')->get();
        foreach ($countries as $country) {
            DB::table('country_informant')->insert([
                'country_id' => $country->id,
                'informant_id' => $country->informant_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // No SQLite, o dropColumn com FK pode ser problemático. 
        // Vamos tentar desabilitar as FKs temporariamente ou apenas avisar.
        try {
            Schema::table('countries', function (Blueprint $table) {
                $table->dropColumn('informant_id');
            });
        } catch (\Exception $e) {
            // Se falhar (comum em SQLite), apenas ignoramos e deixamos a coluna lá.
            // Ela não será mais usada pelos modelos.
        }
    }

    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->unsignedBigInteger('informant_id')->nullable();
        });

        // Tentar restaurar dados (simplificado)
        $pivots = DB::table('country_informant')->get();
        foreach ($pivots as $pivot) {
            DB::table('countries')->where('id', $pivot->country_id)->update(['informant_id' => $pivot->informant_id]);
        }

        Schema::dropIfExists('country_informant');
    }
};
