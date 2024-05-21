<?php

use App\Http\Controllers\PlayersController;
use App\Http\Controllers\PracticesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RosterController;
use App\Http\Controllers\SeasonsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    if(Auth::check()){
        return view('roster.index');
    }

    return view('welcome');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

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


Route::get('/players/{roster}', [PlayersController::class, 'index'])->name('players.index')->middleware(['auth', 'verified']);
Route::get('/players/{roster}/create', [PlayersController::class, 'create'])->name('players.create')->middleware(['auth', 'verified']);
Route::post('/players', [PlayersController::class, 'store'])->name('players.store')->middleware(['auth', 'verified']);
Route::get('/players/edit/{players}', [PlayersController::class, 'edit'])->name('players.edit')->middleware('auth');
Route::patch('/players/{players}', [PlayersController::class, 'update'])->name('players.patch')->middleware('auth');
Route::delete('/players/{players}', [PlayersController::class, 'destroy'])->name('players.delete')->middleware('auth');



Route::get('/practices/{roster}', [PracticesController::class, 'index'])->name('practices.index')->middleware(['auth', 'verified']);
Route::get('/practices/{roster}/create', [PracticesController::class, 'create'])->name('practices.create')->middleware(['auth', 'verified']);
Route::post('/practices', [PracticesController::class, 'store'])->name('practice.store')->middleware(['auth', 'verified']);



require __DIR__.'/auth.php';
