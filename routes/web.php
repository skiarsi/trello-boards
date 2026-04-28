<?php

use App\Http\Controllers\GoogleController;
use App\Livewire\Pages\Boardpage;
use App\Livewire\Pages\Home;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function(){
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
    Route::get('/api/auth/google/callback', [GoogleController::class, 'callback']);
});

Route::middleware(['auth'])->group(function(){
    Route::get('/', Home::class)->name('index');

    // boards
    Route::prefix('board')->group(function(){
        Route::get('/{board:slug}', Boardpage::class)->name('board');
    });
});
