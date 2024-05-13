<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RosterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profilePhoto', [ProfileController::class, 'updatePhoto'])->name('profile.photo-update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/roster', [RosterController::class, 'index'])->name('roster.index')->middleware(['auth', 'verified']);
Route::get('/roster/create', [RosterController::class, 'create'])->name('roster.create')->middleware(['auth', 'verified']);
Route::post('/roster', [RosterController::class, 'store'])->name('roster.store')->middleware('auth');
Route::get('/roster/{roster}', [RosterController::class, 'edit'])->name('roster.edit')->middleware('auth');
Route::patch('/roster/{roster}', [RosterController::class, 'update'])->name('roster.patch')->middleware('auth');
Route::delete('/roster/{roster}', [RosterController::class, 'destroy'])->name('roster.delete')->middleware('auth');
require __DIR__.'/auth.php';
