<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Investigator;
use App\Models\GameSession;
use App\Models\GameStep;
use Illuminate\Support\Facades\DB;

class GameService
{
    /**
     * Inicia uma nova sessão de jogo.
     */
    public function startNewGame(Investigator $investigator): GameSession
    {
        return DB::transaction(function () use ($investigator) {
            $pathLength = $investigator->countries_count;
            
            // Sorteia o caminho de países únicos
            $pathIds = Country::inRandomOrder()
                ->limit($pathLength)
                ->pluck('id')
                ->toArray();

            $game = GameSession::create([
                'investigator_id' => $investigator->id,
                'status' => 'playing',
                'current_step' => 1,
                'total_steps' => $pathLength,
                'path' => $pathIds,
            ]);

            // Cria o primeiro passo
            GameStep::create([
                'game_session_id' => $game->id,
                'step_number' => 1,
                'target_country_id' => $pathIds[0],
                'is_correct' => true,
            ]);

            return $game;
        });
    }

    /**
     * Obtém o país atual do jogador.
     */
    public function getCurrentCountry(GameSession $game)
    {
        $path = $game->path;
        $currentIdx = $game->current_step - 1;
        return Country::find($path[$currentIdx]);
    }

    /**
     * Obtém o próximo país (o alvo que o jogador deve descobrir).
     */
    public function getNextTargetCountry(GameSession $game)
    {
        $path = $game->path;
        if ($game->current_step >= count($path)) {
            return null; // Já está no último país
        }
        
        $nextId = $path[$game->current_step] ?? null;
        return $nextId ? Country::find($nextId) : null;
    }

    /**
     * Obtém as pistas para o PRÓXIMO país.
     */
    public function getCluesForNextStep(GameSession $game)
    {
        $nextCountry = $this->getNextTargetCountry($game);
        if (!$nextCountry) return [];

        return $nextCountry->clues()->inRandomOrder()->limit(3)->get();
    }

    /**
     * Processa a viagem do jogador para um destino.
     */
    public function travel(GameSession $game, Country $destination): bool
    {
        $nextCountry = $this->getNextTargetCountry($game);

        if ($nextCountry && $destination->id === $nextCountry->id) {
            // Viagem correta
            $game->increment('current_step');
            
            // Verifica se ganhou
            if ($game->current_step === $game->total_steps) {
                $game->update(['status' => 'won']);
            }

            return true;
        }

        // Se errou, no clássico você volta ou fica no mesmo lugar e perde tempo.
        // Aqui vamos simplificar: você viaja para o lugar errado e tem que tentar de novo.
        return false;
    }

    /**
     * Lista possíveis destinos de viagem (o correto + alguns aleatórios).
     */
    public function getPossibleDestinations(GameSession $game)
    {
        $nextCountry = $this->getNextTargetCountry($game);
        $currentCountry = $this->getCurrentCountry($game);

        $destinations = Country::where('id', '!=', $currentCountry->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        if ($nextCountry && !$destinations->contains('id', $nextCountry->id)) {
            $destinations->pop();
            $destinations->push($nextCountry);
        }

        return $destinations->shuffle();
    }
}
