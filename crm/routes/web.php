<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ClientController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/search', [ClientController::class, 'search'])->middleware(['auth']);
Route::resource('clients', ClientController::class)->middleware(['auth']);

require __DIR__ . '/auth.php';
