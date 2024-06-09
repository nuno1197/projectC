<?php

use App\Http\Controllers\DrillController;
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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profilePhoto', [ProfileController::class, 'updatePhoto'])->name('profile.photo-update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/landing', [SeasonsController::class, 'index'])->name('landing')->middleware(['auth', 'verified']);

Route::prefix('roster')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/{season}', [RosterController::class, 'index'])->name('roster.index');
    Route::get('/roster-menu/{roster}', [RosterController::class, 'indexRoster'])->name('roster.indexRoster');
    Route::get('/{season}/create', [RosterController::class, 'create'])->name('roster.create');
    Route::post('/', [RosterController::class, 'store'])->name('roster.store')->withoutMiddleware(['verified']);
    Route::get('/{season}/edit/{roster}', [RosterController::class, 'edit'])->name('roster.edit');
    Route::patch('/{roster}', [RosterController::class, 'update'])->name('roster.patch');
    Route::delete('/{roster}', [RosterController::class, 'destroy'])->name('roster.delete');
});


Route::prefix('players')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/{roster}', [PlayerController::class, 'index'])->name('players.index');
    Route::get('/{roster}/create', [PlayerController::class, 'create'])->name('players.create');
    Route::post('/', [PlayerController::class, 'store'])->name('players.store');
    Route::get('/edit/{players}', [PlayerController::class, 'edit'])->name('players.edit')->withoutMiddleware(['verified']);
    Route::patch('/{players}', [PlayerController::class, 'update'])->name('players.patch')->withoutMiddleware(['verified']);
    Route::delete('/{players}', [PlayerController::class, 'destroy'])->name('players.delete')->withoutMiddleware(['verified']);
});



Route::prefix('planning/practice')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/{roster}', [PracticeController::class, 'index'])->name('practice.index');
    Route::get('/{roster}/create', [PracticeController::class, 'create'])->name('practice.create');
    Route::post('/', [PracticeController::class, 'store'])->name('practice.store');
    Route::get('/{practice}/edit', [PracticeController::class, 'edit'])->name('practice.edit')->withoutMiddleware(['verified']);
    Route::patch('/{practice}', [PracticeController::class, 'update'])->name('practice.patch')->withoutMiddleware(['verified']);
    //plan pratice -> INDEX PRACTICE BOTAO
    Route::get('/planpractice/{practice}', [PracticeController::class, 'indexPracticePlan'])->name('practice.indexpracticeplan');
});
//Route::post('/drill', [DrillController::class, 'store'])->name('drill.store')->middleware(['auth', 'verified']);

Route::prefix('planning/games')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/{roster}', [GameController::class, 'index'])->name('games.index');
    Route::get('/{roster}/create', [GameController::class, 'create'])->name('games.create');
    Route::get('/{roster}/edit/{game}', [GameController::class, 'edit'])->name('games.edit');
    Route::post('/', [GameController::class, 'store'])->name('games.store');
    Route::patch('/{game}', [GameController::class, 'update'])->name('games.patch')->withoutMiddleware(['verified']);
    Route::delete('/{game}', [GameController::class, 'destroy'])->name('games.delete')->withoutMiddleware(['verified']);
});

Route::prefix('plangame')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/{game}', [GameController::class, 'indexGameplan'])->name('games.indexplangame');
    Route::patch('/{game}', [GameController::class, 'updateGamePlan'])->name('games.updategameplan');
    Route::get('/generatePDF/{game}', [GameController::class, 'createPDF'])->name('games.game_plan_pdf');
});

Route::get('/planning/menu/{roster}', [PlanningController::class, 'index'])->name('planning.index')->middleware(['auth', 'verified']);
Route::get('/planning/events/{roster}', [PlanningController::class, 'events'])->name('planning.events')->middleware(['auth', 'verified']);

Route::prefix('drill')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/menu', [DrillController::class, 'drillMenu'])->name('drill.menu')->middleware(['auth', 'verified']);
    Route::get('/mydrills', [DrillController::class, 'index'])->name('drill.index')->middleware(['auth', 'verified']);
    Route::get('/mydrills/create', [DrillController::class, 'create'])->name('drill.create')->middleware(['auth', 'verified']);
    Route::post('/', [DrillController::class, 'store'])->name('drill.store');
    Route::get('/mydrills/{drill}/edit', [DrillController::class, 'edit'])->name('drill.edit')->middleware(['auth', 'verified']);
    Route::patch('/{drill}', [DrillController::class, 'update'])->name('drill.patch')->withoutMiddleware(['verified']);
});

Route::get('/aux', function (){

    return view('home');
});

Route::get('/aux2', function (){

    return view('aux');
});

require __DIR__.'/auth.php';
