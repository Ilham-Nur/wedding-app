<?php

use App\Http\Controllers\WeddingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/wedding', [WeddingController::class, 'index'])->name('wedding.index');

