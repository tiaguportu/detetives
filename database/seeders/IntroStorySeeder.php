<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IntroStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stories = [
            'surrupiou a Pedra Filosofal do cofre subterrâneo do Banco de Londres!',
            'substituiu a Mona Lisa por uma caricatura de si mesmo no Museu do Louvre!',
            'roubou o lendário Diamante Koh-i-Noor durante um eclipse solar!',
            'hackeou o sistema financeiro global e desviou bilhões em barras de ouro!',
            'sequestrou o principal botânico real e levou consigo a última Orquídea Negra da Amazônia!'
        ];

        foreach ($stories as $story) {
            \App\Models\IntroStory::updateOrCreate(['content' => $story], ['is_active' => true]);
        }
    }
}
