<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PetController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ClientController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/search', [ClientController::class, 'search'])->middleware(['auth']);
Route::resource('clients', ClientController::class)->middleware(['auth']);
Route::resource('pet', PetController::class)->middleware(['auth']);

require __DIR__ . '/auth.php';
