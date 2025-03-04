<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/encode', [UrlController::class, 'encode'])->name('encode');
Route::post('/decode', [UrlController::class, 'decode'])->name('decode');