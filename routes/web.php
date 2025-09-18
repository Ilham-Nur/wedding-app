<?php

use App\Http\Controllers\WeddingController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::controller(LoginController::class)->middleware('guest')->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::controller(WeddingController::class)->prefix('wedding')->name('wedding.')->group(function () {
    Route::get('/', 'index')->name('index');
});
