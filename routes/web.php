<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;

Route::get('/', [BookController::class,'index'])->name('dashboard');
Route::resource('books', BookController::class)->except(['show','create','edit']);
Route::resource('genres', GenreController::class)->except(['show','create','edit']);
