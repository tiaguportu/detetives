<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GameController;

Route::get('/', [GameController::class, 'index'])->name('home');
Route::match(['get', 'post'], '/game/start/{investigator}', [GameController::class, 'start'])->name('game.start');
Route::get('/game/{game}', [GameController::class, 'show'])->name('game.show');
Route::post('/game/{game}/travel', [GameController::class, 'travel'])->name('game.travel');
