<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PetController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'check.user.setting'])->group(function () {
    Route::get('/dashboard', [ClientController::class, 'index'])->name('dashboard');
    Route::get('/search', [ClientController::class, 'search']);
    Route::resource('clients', ClientController::class);
    Route::resource('pet', PetController::class)->except('create');
    Route::get('pets/{id}/', [PetController::class, 'create'])->name('pets.create');
});

require __DIR__ . '/auth.php';
