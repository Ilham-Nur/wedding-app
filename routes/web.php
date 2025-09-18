<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\TamuController;
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
    Route::get('wedding/detail/{id}', [WeddingController::class, 'detail'])->name('wedding.detail');


    // Wedding Gallery
    Route::get('/wedding/{id}/gallery', [GalleryController::class, 'index'])->name('wedding.gallery');

    // Wedding Gift
    Route::get('/wedding/{id}/gift', [GiftController::class, 'index'])->name('wedding.gift');

    // Tamu
    Route::get('/wedding/{id}/tamu', [TamuController::class, 'index'])->name('wedding.tamu');


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});



