<?php

use App\Http\Controllers\WeddingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/wedding', [WeddingController::class, 'index'])->name('wedding.index');
Route::get('wedding/data', [WeddingController::class, 'getData'])->name('wedding.data');
Route::post('wedding', [WeddingController::class, 'store'])->name('wedding.store');
Route::get('wedding/{pernikahan}', [WeddingController::class, 'show'])->name('wedding.show'); // <--- tambahan
Route::put('wedding/{pernikahan}', [WeddingController::class, 'update'])->name('wedding.update');
Route::delete('wedding/{pernikahan}', [WeddingController::class, 'destroy'])->name('wedding.destroy');

