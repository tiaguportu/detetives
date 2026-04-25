<?php

namespace App\Http\Controllers;

use App\Models\Investigator;
use App\Models\GameSession;
use App\Models\Country;
use App\Services\GameService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    protected $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index()
    {
        $investigators = Investigator::all();
        
        $currentVillany = \App\Models\IntroStory::where('is_active', true)->inRandomOrder()->first()?->content 
            ?? 'fugiu com os planos secretos da agência!';
        
        return view('game.index', compact('investigators', 'currentVillany'));
    }

    public function start(Investigator $investigator)
    {
        $game = $this->gameService->startNewGame($investigator);
        return redirect()->route('game.show', $game);
    }

    public function show(GameSession $game)
    {
        $currentCountry = $this->gameService->getCurrentCountry($game);
        $clues = $this->gameService->getCluesForNextStep($game);
        $destinations = $this->gameService->getPossibleDestinations($game);
        $randomInformant = $currentCountry->random_informant;

        return view('game.show', compact('game', 'currentCountry', 'clues', 'destinations', 'randomInformant'));
    }

    public function travel(Request $request, GameSession $game)
    {
        $destination = Country::findOrFail($request->country_id);
        $success = $this->gameService->travel($game, $destination);

        if ($success) {
            if ($game->status === 'won') {
                return redirect()->route('game.show', $game)->with('message', 'Parabéns! Você capturou o suspeito!');
            }
            return redirect()->route('game.show', $game)->with('message', 'Você viajou para o destino correto!');
        }

        return redirect()->route('game.show', $game)->with('error', 'O suspeito não foi visto por aqui. Tente outro lugar!');
    }
}
