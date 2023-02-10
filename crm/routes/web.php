<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', [ClientController::class, 'index'])->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
