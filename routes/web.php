<?php

use App\Http\Controllers\WeddingController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login.index');

Route::post('/login', [LoginController::class, 'login'])->name('login');



Route::middleware('auth')->group(function () {
    Route::get('/wedding', [WeddingController::class, 'index'])->name('wedding.index');
    Route::get('wedding/data', [WeddingController::class, 'getData'])->name('wedding.data');
    Route::post('wedding', [WeddingController::class, 'store'])->name('wedding.store');
    Route::get('wedding/{pernikahan}', [WeddingController::class, 'show'])->name('wedding.show');
    Route::put('wedding/{pernikahan}', [WeddingController::class, 'update'])->name('wedding.update');
    Route::delete('wedding/{pernikahan}', [WeddingController::class, 'destroy'])->name('wedding.destroy');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});



