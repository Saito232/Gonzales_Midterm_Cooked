<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\GenreController;

Route::get('/', [MovieController::class,'index'])->name('dashboard');
// For convenience during testing, routes are not wrapped in auth middleware by default.
// You can add ->middleware('auth') if you installed auth scaffolding.
Route::resource('movies', MovieController::class)->except(['show','create','edit']);
Route::resource('genres', GenreController::class)->except(['show','create','edit']);
