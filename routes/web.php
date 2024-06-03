<?php

use App\Http\Controllers\PlanningController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\SeasonsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    if(Auth::check()){
        return redirect('landing');
    }

    return view('welcome');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/aux', function () {
    return view('new_dash');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profilePhoto', [ProfileController::class, 'updatePhoto'])->name('profile.photo-update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/landing', [SeasonsController::class, 'index'])->name('landing')->middleware(['auth', 'verified']);

Route::get('/roster/{season}', [RosterController::class, 'index'])->name('roster.index')->middleware(['auth', 'verified']);
Route::get('/roster/roster-menu/{roster}', [RosterController::class, 'indexRoster'])->name('roster.indexRoster')->middleware(['auth', 'verified']);
Route::get('/roster/{season}/create', [RosterController::class, 'create'])->name('roster.create')->middleware(['auth', 'verified']);
Route::post('/roster', [RosterController::class, 'store'])->name('roster.store')->middleware('auth');
Route::get('/roster/{season}/edit/{roster}', [RosterController::class, 'edit'])->name('roster.edit')->middleware('auth');
Route::patch('/roster/{roster}', [RosterController::class, 'update'])->name('roster.patch')->middleware('auth');
Route::delete('/roster/{roster}', [RosterController::class, 'destroy'])->name('roster.delete')->middleware('auth');


Route::get('/players/{roster}', [PlayerController::class, 'index'])->name('players.index')->middleware(['auth', 'verified']);
Route::get('/players/{roster}/create', [PlayerController::class, 'create'])->name('players.create')->middleware(['auth', 'verified']);
Route::post('/players', [PlayerController::class, 'store'])->name('players.store')->middleware(['auth', 'verified']);
Route::get('/players/edit/{players}', [PlayerController::class, 'edit'])->name('players.edit')->middleware('auth');
Route::patch('/players/{players}', [PlayerController::class, 'update'])->name('players.patch')->middleware('auth');
Route::delete('/players/{players}', [PlayerController::class, 'destroy'])->name('players.delete')->middleware('auth');




Route::get('/planning/practices/{roster}/create', [PracticeController::class, 'create'])->name('practices.create')->middleware(['auth', 'verified']);
Route::post('/practices', [PracticeController::class, 'store'])->name('practice.store')->middleware(['auth', 'verified']);
Route::get('/planning/practices/{practice}', [PracticeController::class, 'edit'])->name('practice.edit')->middleware('auth');
Route::patch('/practice/{practice}', [PracticeController::class, 'update'])->name('practice.patch')->middleware('auth');

Route::get('/planning/games/{roster}', [GameController::class, 'index'])->name('games.index')->middleware(['auth', 'verified']);
Route::get('/planning/games/{roster}/create', [GameController::class, 'create'])->name('games.create')->middleware(['auth', 'verified']);
Route::get('/planning/games/{roster}/edit/{game}', [GameController::class, 'edit'])->name('games.edit')->middleware(['auth', 'verified']);
Route::post('/game', [GameController::class, 'store'])->name('games.store')->middleware(['auth', 'verified']);
Route::patch('/games/{game}', [GameController::class, 'update'])->name('games.patch')->middleware('auth');
Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.delete')->middleware('auth');
Route::get('/game/plangame/{game}', [GameController::class, 'indexGameplan'])->name('games.indexplangame')->middleware(['auth', 'verified']);
Route::patch('/plangame/{game}', [GameController::class, 'updateGamePlan'])->name('games.updategameplan')->middleware(['auth', 'verified']);
Route::get('/plangame/generatePDF/{game}', [GameController::class, 'createPDF'])->name('games.game_plan_pdf')->middleware(['auth', 'verified']);

Route::get('/planning/menu/{roster}', [PlanningController::class, 'index'])->name('planning.index')->middleware(['auth', 'verified']);
Route::get('/planning/events/{roster}', [PlanningController::class, 'events'])->name('planning.events')->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
