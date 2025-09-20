<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LokasiPernikahanController;
use App\Http\Controllers\UndanganController;
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
    Route::put('/wedding/{id}/extra', [WeddingController::class, 'updateExtra'])->name('wedding.updateExtra');


    // Wedding Gallery
    Route::get('/wedding/{id}/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/galeri/{pernikahan}', [GalleryController::class, 'show'])->name('gallery.show');
    Route::post('/galeri', [GalleryController::class, 'store'])->name('gallery.store');
    Route::delete('/galeri/{galeri}', [GalleryController::class, 'destroy'])->name('gallery.destroy');

    // Wedding Gift
    Route::get('/wedding/{pernikahanId}/gift', [GiftController::class, 'index'])->name('wedding.gift');

    // Tamu
    Route::get('/wedding/{id}/tamu', [TamuController::class, 'index'])->name('wedding.tamu');

    // Lokasi
    Route::get('/wedding/{pernikahanId}/lokasi', [LokasiPernikahanController::class, 'index'])->name('wedding.lokasi');

    // Gift (Rekening)
    Route::get('/gift', [GiftController::class, 'index'])->name('gift.index');
    Route::get('/gift/data/{pernikahanId}', [GiftController::class, 'data'])->name('gift.data');
    Route::post('/gift/store', [GiftController::class, 'store'])->name('gift.store');
    Route::get('/gift/{id}/edit', [GiftController::class, 'edit'])->name('gift.edit');
    Route::get('/gift/{id}/show', [GiftController::class, 'show'])->name('gift.show');
    Route::put('/gift/{id}/update', [GiftController::class, 'update'])->name('gift.update');
    Route::delete('/gift/{id}/delete', [GiftController::class, 'destroy'])->name('gift.destroy');

    // Lokasi Pernikahan
    Route::get('/lokasi', [LokasiPernikahanController::class, 'index'])->name('lokasi.index');
    Route::get('/lokasi/data/{pernikahanId}', [LokasiPernikahanController::class, 'data'])->name('lokasi.data');
    Route::post('/lokasi/store', [LokasiPernikahanController::class, 'store'])->name('lokasi.store');
    Route::get('/lokasi/{id}/show', [LokasiPernikahanController::class, 'show'])->name('lokasi.show');
    Route::get('/lokasi/{id}/edit', [LokasiPernikahanController::class, 'edit'])->name('lokasi.edit');
    Route::put('/lokasi/{id}/update', [LokasiPernikahanController::class, 'update'])->name('lokasi.update');
    Route::delete('/lokasi/{id}/delete', [LokasiPernikahanController::class, 'destroy'])->name('lokasi.destroy');

    //slug for undangan
    Route::get('/undangan/{slug}', [UndanganController::class, 'show'])->name('undangan.show');


    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});



