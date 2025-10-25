<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WinnerController;
use App\Http\Controllers\DisplayController;

// Tampilan publik display doorprize
Route::get('/display', [DisplayController::class, 'index'])->name('display.index');
Route::get('/display/fetch', [DisplayController::class, 'fetchWinners'])->name('display.fetch');

// Halaman welcome default
Route::get('/', function () {
    return redirect()->route('login');
});

// 🔐 Semua route dashboard di-protect dengan Jetstream Auth
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard utama
    Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');

    // Peserta
    Route::get('/dashboard/participants', [ParticipantController::class, 'index'])
        ->name('participants.index');
    Route::post('/dashboard/participants/generate', [ParticipantController::class, 'generate'])
        ->name('participants.generate');

    // Kategori
    Route::get('/dashboard/categories', [CategoryController::class, 'index'])
        ->name('categories.index');
    Route::post('/dashboard/categories', [CategoryController::class, 'store'])
        ->name('categories.store');
    Route::post('/dashboard/categories/{id}/set-active', [CategoryController::class, 'setActive']);

    // Pemenang
    Route::get('/dashboard/winners', [WinnerController::class, 'index'])
        ->name('winners.index');


    // Set kategori aktif dari dropdown
    Route::post('/dashboard/winners/set-active', [WinnerController::class, 'setActive'])
        ->name('winners.setActive');

    // Acak pemenang kategori aktif
    Route::post('/dashboard/winners/draw', [WinnerController::class, 'drawWinner'])
        ->name('winners.draw');

    // Reset semua undian
    Route::post('/dashboard/winners/reset', [WinnerController::class, 'resetAll'])
        ->name('winners.reset');
});
